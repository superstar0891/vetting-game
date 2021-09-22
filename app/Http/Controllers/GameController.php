<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Team;
use App\Models\Sport;
use App\Models\League;
use App\Models\Game;
use App\Models\Status;
use App\Models\Odd;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    //
    public function index($id){
        $today = now()->toDateString('Y-m-d');
        $sport = Sport::find($id);
        $games = DB::table('games')
                ->where('sport_id',$id)
                ->where('date_time',$today)
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->select('games.*','home_team.name as home_team_name','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return view('admin/betting',['sport'=>$sport,'games' => $games]);
    }

    public function load($id){
        $sport_id = $id;
        $sport = Sport::find($sport_id);
        $base_url = $sport->url;
        $today = now()->toDateString('Y-m-d');
        $curl = curl_init();
        $url = "";

        if($sport_id == 1){
            $url = "https://".$base_url."/games/?date=".$today;
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: ".$base_url,
                    "x-rapidapi-key: ".env('RAPID_API_KEY')
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
    
            if ($err) {
               return response()->json(['message' => 'failure', 'errors' => $err]);
            } else {
                $games_results = json_decode($response);
                $games  = $games_results->response;
                $real_game = array();
                foreach($games as $game){
                    
                    if($game->status->short != "FT" && $game->status->short != "AOT"){
                        if($game->league->name == "NCAA" || $game->league->name == "NBA"){
                            $season  = "";
                            if(is_numeric($game->league->season)){
                                $season = (string) $game->league->season;
                            }else{
                                $season = $game->league->season;
                            }
                            $home_team = Team::create([
                                "type" => "home",
                                'odd' => '+10',
                                'team_id' => $game->teams->home->id,
                                'name' => $game->teams->home->name,
                                'logo' => $game->teams->home->logo
                            ]);

                            $away_team = Team::create([
                                "type" => "away",
                                'odd' => '-10',
                                "team_id" => $game->teams->away->id,
                                "name" => $game->teams->away->name,
                                "logo" => $game->teams->away->logo
                            ]);

                            

                            $league = League::create([
                                "league_id" => $game->league->id,
                                "name" => $game->league->name,
                                "logo" => $game->league->logo,
                                "seasons" => $season,
                            ]);

                            Game::create([
                                'sport_id' => $sport_id,
                                'game_id' => $game->id,
                                'time' => $game->time,
                                'date_time' => $today,
                                'timezone'  => $game->timezone,
                                'timestamp' => $game->timestamp,
                                'league_id' => $league->id,
                                'home_team_id' => $home_team->id,
                                'away_team_id' => $away_team->id,
                            ]);
                        }
                    }
                }
                
            }
        }
        else if($sport_id == 2){
            $url = "https://".$base_url."/games/?date=".$today;
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: ".$base_url,
                    "x-rapidapi-key: ".env('RAPID_API_KEY')
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
               return response()->json(['message' => 'failure', 'errors' => $err]);
            } else {
                $games_results = json_decode($response);
                $games  = $games_results->response;
                $real_game = array();
                foreach($games as $game){
                    
                    if($game->status->short != "FT" && $game->status->short != "AOT"){
                        if($game->league->name == "NHL"){
                            $season  = "";
                            if(is_numeric($game->league->season)){
                                $season = (string) $game->league->season;
                            }else{
                                $season = $game->league->season;
                            }


                            $home_team = Team::create([
                                "type" => "home",
                                'odd' => '+10',
                                'team_id' => $game->teams->home->id,
                                'name' => $game->teams->home->name,
                                'logo' => $game->teams->home->logo
                            ]);

                            $away_team = Team::create([
                                "type" => "away",
                                'odd' => '-10',
                                "team_id" => $game->teams->away->id,
                                "name" => $game->teams->away->name,
                                "logo" => $game->teams->away->logo
                            ]);

                            

                            $league = League::create([
                                "league_id" => $game->league->id,
                                "name" => $game->league->name,
                                "logo" => $game->league->logo,
                                "seasons" => $season,
                            ]);

                            Game::create([
                                'sport_id' => $sport_id,
                                'game_id' => $game->id,
                                'time' => $game->time,
                                'date_time' => $today,
                                'timezone'  => $game->timezone,
                                'timestamp' => $game->timestamp,
                                'league_id' => $league->id,
                                'home_team_id' => $home_team->id,
                                'away_team_id' => $away_team->id,
                            ]);
                        }
                    }
                }

            }
        }
        else if($sport_id == 3){
            $url = "https://".$base_url."/fixtures/?date=".$today;
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: ".$base_url,
                    "x-rapidapi-key: ".env('RAPID_API_KEY')
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
    
            if ($err) {
               return response()->json(['message' => 'failure', 'errors' => $err]);
            } else {
                $games_results = json_decode($response);
                $games  = $games_results->response;
                $real_game = array();
                foreach($games as $game){         
                    if($game->fixture->status->short != "FT"){
                        //array...
                        if($game->league->name == "NFL"){
                            $season  = "";
                            if(is_numeric($game->league->season)){
                                $season = (string) $game->league->season;
                            }else{
                                $season = $game->league->season;
                            }

                            $time = Carbon::parse($game->fixture->timestamp)->format('H:i:s');
                            //$date_arr= explode("T", $game->fixture->timestamp);
                            
                            $home_team = Team::create([
                                "type" => "home",
                                'odd' => '+10',
                                'team_id' => $game->teams->home->id,
                                'name' => $game->teams->home->name,
                                'logo' => $game->teams->home->logo
                            ]);

                            $away_team = Team::create([
                                "type" => "away",
                                'odd' => '-10',
                                "team_id" => $game->teams->away->id,
                                "name" => $game->teams->away->name,
                                "logo" => $game->teams->away->logo
                            ]);

                            

                            $league = League::create([
                                "league_id" => $game->league->id,
                                "name" => $game->league->name,
                                "logo" => $game->league->logo,
                                "seasons" => $season,
                            ]);


                            Game::create([
                                'sport_id' => $sport_id,
                                'game_id' => $game->fixture->id,
                                'timezone'  =>  $game->fixture->timezone,
                                'timestamp' => $game->fixture->timestamp,
                                'league_id' => $league->id,
                                'date_time' => $today,
                                'time' => $time,
                                'home_team_id' => $home_team->id,
                                'away_team_id' => $away_team->id,
                            ]);
                        }
                        
                    }
                }
            }
        }else{
            $url = "https://".$base_url."/games/?date=".$today;
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: ".$base_url,
                    "x-rapidapi-key: ".env('RAPID_API_KEY')
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
    
            if ($err) {
               return response()->json(['message' => 'failure', 'errors' => $err]);
            } else {
                $games_results = json_decode($response);
                $games  = $games_results->response;
                $real_game = array();
                foreach($games as $game){            
                    if($game->status->short != "FT" && $game->status->short != "AOT" && $game->status->long != "Over Time"){
                        $season  = "";
                        if(is_numeric($game->league->season)){
                            $season = (string) $game->league->season;
                        }else{
                            $season = $game->league->season;
                        }

                        

                        $home_team = Team::create([
                            "type" => "home",
                            'odd' => '+10',
                            'team_id' => $game->teams->home->id,
                            'name' => $game->teams->home->name,
                            'logo' => $game->teams->home->logo
                        ]);

                        $away_team = Team::create([
                            "type" => "away",
                            'odd' => '-10',
                            "team_id" => $game->teams->away->id,
                            "name" => $game->teams->away->name,
                            "logo" => $game->teams->away->logo
                        ]);

                        

                        $league = League::create([
                            "league_id" => $game->league->id,
                            "name" => $game->league->name,
                            "logo" => $game->league->logo,
                            "seasons" => $season,
                        ]);

                        Game::create([
                            'sport_id' => $sport_id,
                            'game_id' => $game->id,
                            'time' => $game->time,
                            'date_time' => $today,
                            'timezone'  => $game->timezone,
                            'timestamp' => $game->timestamp,
                            'league_id' => $league->id,
                            'home_team_id' => $home_team->id,
                            'away_team_id' => $away_team->id,
                        ]);
                    }
                }
  
            }
        }
        return redirect()->back();
    }

    public function getOdds(Request $request){
        $id = $request->input('id');
        $game = Game::find($id);
        $home_team = Team::where('id',$game->home_team_id)->first();
        $away_team = Team::where('id',$game->away_team_id)->first();
        return response()->json(['home'=>$home_team, 'away'=>$away_team]);
    }

    public function updateOdds(Request $request){
        $home_id = $request->input('home_id');
        $home_odd = $request->input('home_odd');
        $away_id = $request->input('away_id');
        $away_odd = $request->input('away_odd');
        $home_team = Team::find($home_id);
        $home_team->odd = $home_odd;
        $home_team->save();
        $away_team = Team::find($away_id);
        $away_team->odd = $away_odd;
        $away_team->save();

        return redirect()->back();
    }

    
}
