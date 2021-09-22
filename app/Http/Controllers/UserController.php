<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wage;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use URL;
use Session;
use Redirect;
use Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Currency;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Payout;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class UserController extends Controller
{
    //
    private $_api_context;
    private $payment_amount;
    private $base_encode;
    private $oauth_token ;
    
    public function __construct()
    {    
        $payment_amount = 0;
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
        $this->base_encode = base64_encode($paypal_configuration['client_id'].":".$paypal_configuration['secret']);
        $this->oauth_token = new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']);
    }
    public function dashboard(){
        $owner_id = auth()->id();
        $friends = DB::table('contacts')
                ->where('owner_id',$owner_id)
                ->join('users','users.id','=','contacts.user_id')
                ->select('users.*')
                ->get();
        $user_count = count($friends);
        $completed_wages = Wage::where('status',3)->where('user_id',$owner_id)->get();
        $pending_wages = Wage::where('status',0)->where('user_id',$owner_id)->get();
        $transactions = DB::table('users')
                        ->where('user_id',$owner_id)
                        ->join('transactions','users.id','=','transactions.user_id')
                        ->select('users.first_name','users.last_name','users.email','transactions.*')
                        ->take(20)
                        ->get();
        $total = number_format(TransactionHistory::sum('fee'),2);
        $completed_wages_count = count($completed_wages);
        $pending_wages_count = count($pending_wages);
        $dashbord_users = DB::table('contacts')
                        ->where('owner_id',$owner_id)
                        ->join('users','users.id','=','contacts.user_id')
                        ->select('users.*')
                        ->take(20)
                        ->get();
        $dashbord_transactions =  DB::table('users')
                                ->where('user_id',$owner_id)
                                ->join('transactions','users.id','=','transactions.user_id')
                                ->select('users.first_name','users.last_name','users.email','transactions.*')
                                ->get();

        return view('user/dashboard',['transactions' => $dashbord_transactions,'users' => $dashbord_users, 'user_count'=>$user_count,'transaction_count' =>$total,'completed_count'=>$completed_wages_count,'pending_count'=>$pending_wages_count]);
        
    }



    //Verify Part....................
    public function payment_verify(){  
        return view('user/verify');
    }

    public function checkout(Request $request){

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$verify = new Item();
        $verify->setName('Verify')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice('0.25');

        
        $item_list = new ItemList();
        $item_list->setItems(array($verify));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal('0.25');

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Verify for Spread');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('verify_status'))
            ->setCancelUrl(URL::route('verify_status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));            
        try {
            
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                Session::put('error','Connection timeout');
                returnRedirect::route('verify');               
            } else {
                Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('verify');                
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        
        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {            
            return Redirect::away($redirect_url);
        }

        Session::put('error','Unknown error occurred');
    	return Redirect::route('verify');
    }

    public function verify_status(Request $request){
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Session::put('error','Payment failed');
            return Redirect::route('verify');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        
        $payer = $payment->getPayer();
        $payerInfo = $payer->getPayerInfo();
        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') { 
            TransactionHistory::create([
                'user_id' => auth()->id(),
                'amount' => 0,
                'fee' => 0.25,
                'type' => 5
            ]); 
            $user = User::find(auth()->id());
            $user->payment_verify = '1'; 
            $user->payment_email = $payerInfo->getEmail();
            $user->updated_at = Carbon::now();
            $user->save();
            Session::forget('payment_amount');
            Session::put('success','Payment success !!');
            return Redirect::route('verify');
        }
        Session::put('error','Payment failed !!');
		return Redirect::route('verify');
    }






    //Deposit Part..................
    public function payment_deposit(){  
        return view('user/deposit');
    }

    public function deposit(Request $request){
        $payment_amount = $request->amount;
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$deposit = new Item();
        $fee = new Item();
        $deposit->setName('Deposit')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($payment_amount);

        
        $item_list = new ItemList();
        $item_list->setItems(array($deposit));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($payment_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Deposit for Spread');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('deposit_status'))
            ->setCancelUrl(URL::route('deposit_status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));            
        try {
            
            $payment->create($this->_api_context);
            Session::put('payment_amount',$payment_amount);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                Session::put('error','Connection timeout');
                returnRedirect::route('deposit_confirm');               
            } else {
                Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('deposit_confirm');                
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {            
            return Redirect::away($redirect_url);
        }

        Session::put('error','Unknown error occurred');
    	return Redirect::route('deposit_confirm');
    }

    public function deposit_confirm(){
        return view('user/confirm');
    }

    public function deposit_status(Request $request){
        $payment_id = Session::get('paypal_payment_id');
        $amount = Session::get('payment_amount');
        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Session::put('error','Payment failed');
            return Redirect::route('deposit_confirm');
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') { 
            $amount = ($amount - $amount * 0.029 -0.3)  - 0.8;
            TransactionHistory::create([
                'user_id' => auth()->id(),
                'amount' => $amount ,
                'fee' => 0.8,
                'type' => 3
            ]); 
            $user = User::find(auth()->id());
            $user->balance += $amount;
            $user->updated_at = Carbon::now();
            $user->save();
            Session::forget('payment_amount');
            Session::put('success','Payment success !!');
            return Redirect::route('deposit_confirm');
        }

        Session::put('error','Payment failed !!');
		return Redirect::route('deposit_confirm');
    }

    

    public function payment_withdraw(){  
        return view('user/withdraw');
    }

    public function withdraw(Request $request){

        $payment_email =  User::find(auth()->id())->payment_email;
        $amount = $request->input('amount');
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.sandbox.paypal.com/v1/oauth2/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic '.$this->base_encode,
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);
        //$res = array();
        curl_close($curl);
        $res = json_decode($response);
        $params = array(
            'sender_batch_header' => array(
                'sender_batch_id'=>  uniqid(),
                'email_subject'  => 'You have a payout!',
                'email_message' => 'You have received a payout! Thanks for using our service!'
            ),
            'items' => array([
                'recipient_type'=> 'EMAIL',
                'amount' => array(
                    'value'=> $amount,
                    'currency'=> 'USD'
                ),
                'note'=> 'Thanks for your patronage!',
                'sender_item_id'=> uniqid(),
                'receiver'=> $payment_email,
                'alternate_notification_method' => array(
                    'phone' => array(
                        'country_code' => '1',
                        'national_number' => '9999988888'
                    )
                ),
                'notification_language' => 'en-EN'
            ])
        );
        
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/payments/payouts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($params),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$res->access_token
                ),
            ));
          
            $response = curl_exec($curl);
          
            curl_close($curl);


            $payout = json_decode($response);
            if($payout->batch_header){
                TransactionHistory::create([
                    'user_id' => auth()->id(),
                    'amount' => $amount,
                    'fee' => 0.8,
                    'type' => 3
                ]); 
                $user = User::find(auth()->id());
                $user->balance -= ($amount + 0.8 + 0.25);
                $user->updated_at = Carbon::now();
                $user->save();
                Session::put('success','Payment success !!');
                return Redirect::route('withdraw_confirm');
            }else{
                Session::put('error','Payment Failure !!');
                return Redirect::route('withdraw_confirm');
            }

 
    }
    
    public function withdraw_confirm(){
        return view('user/withdraw_confirm');
    }
    public function transaction(){
        $id = auth()->id();
        $transactions = TransactionHistory::where('user_id',$id)->get();
        return view('user/transaction',['transactions' => $transactions]);
    }



    public function history(){
        $wages = DB::table('wages')
                ->join('games','games.id','=','wages.game_id')
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->where('user_id',auth()->id())
                ->where('wages.status',3)
                ->select('wages.*','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return view('user/history',['wages' => $wages]);
    }

    public function friend(){
        $owner_id = auth()->id();
        $friends = DB::table('contacts')
                ->where('owner_id',$owner_id)
                ->join('users','users.id','=','contacts.user_id')
                ->select('users.*')
                ->get();
        return view('user/friend',['friends' => $friends]);
    }

}
