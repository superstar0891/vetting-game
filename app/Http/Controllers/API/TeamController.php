<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Team;

class TeamController extends Controller
{
    //
    public function detail($id){
        $team = Team::find($id);
        return response()->json(['message'=>'success','team'=>$team]);
        
    }
    
}
