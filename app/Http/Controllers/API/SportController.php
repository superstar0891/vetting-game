<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sport;

class SportController extends Controller
{
    //
    public function list(){
        $list = Sport::all('id','name');
        return response()->json(['sports' => $list]);
    }
}
