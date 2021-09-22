<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Sport;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    //
    public function list($sport_id){
        $today = now()->toDateString('Y-m-d');
        $sport = Sport::find($sport_id);
        $games = DB::table('games')
                ->where('sport_id',$sport_id)
                ->where('date_time',$today)
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->select('games.id','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return response()->json(['message'=>'success','games' => $games]);
    }

    public function detail($id){
        $game = DB::table('games')
                ->where('id',$id)
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->select('games.id','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return response()->json(['message'=>'success','game' => $game]);

    }
    public function game_result(Request $request){

    }

    
}
