<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Wage;
class DashboardController extends Controller
{
    //
    public function index(){
        $users = User::where('type','user')->get();
        $user_count = count($users);
        $completed_wages = Wage::where('status',3)->get();
        $pending_wages = Wage::where('status',0)->get();
        $transactions = DB::table('users')
                        ->join('transactions','users.id','=','transactions.user_id')
                        ->select('users.first_name','users.last_name','users.email','transactions.*')
                        ->take(20)
                        ->get();
        $total = number_format(TransactionHistory::sum('fee'),2);
        $completed_wages_count = count($completed_wages);
        $pending_wages_count = count($pending_wages);
        $dashbord_users = DB::table('users')->take(20)->get();
        $dashbord_transactions =  DB::table('users')
                                ->join('transactions','users.id','=','transactions.user_id')
                                ->select('users.first_name','users.last_name','users.email','transactions.*')
                                ->get();

        return view('admin/dashboard',['transactions' => $dashbord_transactions,'users' => $dashbord_users, 'user_count'=>$user_count,'transaction_count' =>$total,'completed_count'=>$completed_wages_count,'pending_count'=>$pending_wages_count]);
    }

    public function users(){
        $users = User::where('type','user')->get();
        return view('/admin/user',['users' => $users]);
    }

    public function edit(Request $request){
        $id = $request->id;
        $user = User::find($id);
        return response()->json(["user" => $user]);
    }

    public function update(Request $request){
        $id = $request->id;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $user = User::find($id);
        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name= $last_name;
        $user->save();
        return redirect('admin/users');
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return redirect('admin/users');
    }

    public function add(Request $request){
        $validatedData = Validator::make($request->all(),[
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'device_token' =>'required'
        ]);
        
        if ($validatedData->fails())
        {
            // The given data did not pass validation
            return  redirect()->back()->withErrors($validatedData)->withInput();
        }
        
        $user = User::create([
            'first_name' =>$request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'type' => 'user',
            'device_token' => $request->device_token,
            'password' => Hash::make($request->password)
        ]);   
        $user->assignRole('user');
        return redirect()->back();
    }
    public function user_show(){
        $users = User::all();
        return view('admin_user.index',['users' => $users]);
    }
}
