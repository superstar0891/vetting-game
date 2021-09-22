<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function confirm(){
        auth()->user()->update(['notification'=>0]);
        return response()->json(["message" =>"success"]);
    }

    public function get_notification(){
        $notification = auth()->notification();
        return response()->json(['notifications' => $notification]);
    }
}
