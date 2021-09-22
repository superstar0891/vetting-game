<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;

class ContactController extends Controller
{
    //
    public function list(){
        $owner_id = auth()->id();
        $contats = DB::table('contacts')
                    ->where('owner_id',$owner_id)
                    ->join('users','users.id','=','contacts.user_id')
                    ->select('users.*')
                    ->get();

        return response()->json(['contats' => $contats]);
    }

    public function detail($id){
        $user = User::find($id);
        return response()->json(['user' => $user]);
    }

    public function find_user(Request $request){
        $search = $request->input('search');
        $owner_id = auth()->id();
        $users = User::where('first_name','like','%'.$search.'%')
                ->where('type','<>','admin')
                ->where('id','<>',$owner_id)
                ->where('last_name','like','%'.$search.'%')
                ->get();
        return response()->json(['users' => $users]);
    }

    public function user_list(){
        $users = User::where('type','user')
                ->where('id','<>',auth()->id())
                ->get();
        return response()->json(['users' => $users]);
    }

    public function enable_contact($user_id){
        $owner_id = auth()->id();
        Contact::create([
            'owner_id' => $owner_id,
            'user_id' => $user_id
        ]);
        return response()->json(['message' => 'OK']);
    }

    public function get_friends(){
        $contacts = Contact::where('owner_id',auth()->id())->get();
        $friends = count($contacts);
        return response()->json(['friends' => $friends]);
    }

    
}
