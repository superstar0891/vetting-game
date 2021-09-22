<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    //
    private $_api_context;

    public function __construct()
    {

    }

    public function index(){
        $transactions = DB::table('users')
                        ->join('transactions','users.id','=','transactions.user_id')
                        ->select('users.first_name','users.last_name','users.email','transactions.*')
                        ->get();
        $total = number_format(TransactionHistory::sum('fee'),2);
        return view('admin/payment',['transactions' => $transactions,'total' => $total]);
    }



}
