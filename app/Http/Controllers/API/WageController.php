<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Wage;
use App\Models\Game;
use App\Models\League;
use App\Models\Betting;
use App\Models\Comment;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Sport;
use App\Models\Team;

class WageController extends Controller
{
    //
    public function create(Request $request){
        
        $validatedData = Validator::make($request->all(),[
            'game_id'=> 'required',
            'betting_team_id'=> 'required',
            'home_team_odd'=> 'required',
            'away_team_odd'=> 'required',
            'receiver_id'=> 'required',
            'amount'=> 'required',
            'sport_id'=> 'required',
            'home_team_id'=> 'required',
            'away_team_id'=> 'required',
        ]);

        if ($validatedData->fails())
        {
            // The given data did not pass validation
            return response()->json([ 'message' => $validatedData->errors()]);
        }

        $receiver_id = $request->input("receiver_id");
        $amount = $request->input("amount");
        $sport_id = $request->input("sport_id");
        $betting_team_id = $request->input('betting_team_id');
        $game_id = $request->input('game_id');
        $home_team_odd = $request->input("home_team_odd");
        $away_team_odd = $request->input("away_team_odd");
        $away_team_id = $request->input("away_team_id");
        $home_team_id = $request->input("home_team_id");
        $sender_id = auth()->id();
        $wage = Wage::create([
            'amount' => $amount,
            'sport_id' =>$sport_id,
            'user_id' => $sender_id,
            'game_id' => $game_id,
            'status' => '0'
        ]);
        if($betting_team_id == $home_team_id){
            $sender_betting = Betting::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'team_id' => $home_team_id,
                'type' => 0,
                'wage_id' => $wage->id,
                'odd' => $home_team_odd
            ]);

            $receiver_betting = Betting::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'team_id' => $away_team_id,
                'type' => 1,
                'wage_id' => $wage->id,
                'odd' => $away_team_odd
            ]);

        }else{
            $sender_betting = Betting::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'team_id' => $away_team_id,
                'type' => 0,
                'wage_id' => $wage->id,
                'odd' => $away_team_odd
            ]);

            $receiver_betting = Betting::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'team_id' => $home_team_id,
                'type' => 1,
                'wage_id' => $wage->id,
                'odd' => $home_team_odd
            ]);
        }

        $firebaseToken  = User::find($receiver_id)->device_token;
        $SERVER_API_KEY  = env('FIREBASE_SERVER_KEY');
        $user = User::find($sender_id);

        $user->notification = $user->notification + 1;
        $user->save();

        $game = Game::find($game_id);
        $league = League::find($game->league_id);
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "Notification for Spread Application Wage",
                "body" => $user->first_name." ".$user->last_name." sent the wage for ".$league->name,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        
        return response()->json(["message"=>$SERVER_API_KEY]);
        exit;
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);

        return response()->json(["message"=>"success"]);
    }

    public function receive($id){
        $wage = DB::table('wages')
                ->join('bettings','wages.id','=','bettings.wage_id')
                ->join('games','games.id','=','wages.game_id')
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->join('users as sender','sender.id','=','bettings.sender_id')
                ->where('bettings.type','1')
                ->where('wages.status','0')
                ->where('wages.id',$id)
                ->select('wages.*','sender.*','bettings.team_id','bettings.odd','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        
        return response()->json(["message"=>"success",'wage' => $wage]);
    }

    public function detail($id){
        $wage = DB::table('wages')
                ->join('bettings','wages.id','=','bettings.wage_id')
                ->join('games','games.id','=','wages.game_id')
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->where('bettings.sender_id',auth()->id())
                ->orWhere('bettings.receiver_id',auth()->id())
                ->where('wages.id',$id)
                ->select('wages.*','bettings.team_id','bettings.odd','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return response()->json(["message"=>"success",'wage' => $wage]);
    }

    public function accept($id){
        $wage = Wage::find($id);
        if($wage == null){
            return response()->json(["message"=>"failure"]);
        }
        $wage->status = "1";
        $wage->save();
        return response()->json(["message"=>"success"]);
    }

    public function deny($id){
        $wage = Wage::find($id);
        if($wage == null){
            return response()->json(["message"=>"failure"]);
        }
        $wage->status = "2";
        $wage->save();
        return response()->json(["message"=>"success"]);
    }

    public function complete($id){
        $wage = Wage::find($id);
        if($wage == null){
            return response()->json(["message"=>"failure"]);
        }
        $wage->status = "3";
        $wage->save();
        return response()->json(["message"=>"success"]);
    }

    public function send_list(){
        $wages = DB::table('wages')
                ->join('bettings','wages.id','=','bettings.wage_id')
                ->join('games','games.id','=','wages.game_id')
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->join('users as receiver','bettings.receiver_id','=','receiver.id')
                ->where('bettings.sender_id',auth()->id())
                ->where('wages.status',0)
                ->select('wages.*','receiver.*','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return response()->json(["message"=>"success",'wages'=> $complete_wages]);
    }



    public function receive_list(){
        $pending_wages = DB::table('wages')
                ->join('bettings','wages.id','=','bettings.wage_id')
                ->join('games','games.id','=','wages.game_id')
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->join('users as sender','sender.id','=','bettings.sender_id')
                ->where('bettings.receiver_id',auth()->id())
                ->where('bettings.type',1)
                ->where('wages.status',0)
                ->select('wages.*','sender.*','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return response()->json(["message"=>"success",'wages'=> $pending_wages]);
    }

    

    public function pending_list(){
        $pending_wages = DB::table('wages')
                        ->join('bettings','wages.id','=','bettings.wage_id')
                        ->join('games','games.id','=','wages.game_id')
                        ->join('leagues','games.league_id','=','leagues.id')
                        ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                        ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                        ->join('users as sender','sender.id','=','bettings.sender_id')
                        ->join('users as receiver','receiver.id','=','bettings.receiver_id')
                        ->where('bettings.sender_id',auth()->id())
                        ->orWhere('bettings.receiver_id',auth()->id())
                        ->where('wages.status',1)
                        ->select('wages.*','sender.id as sender_id','sender.first_name as sender_first_name','sender.last_name as sender_last_name','receiver.id as receiver_id','receiver.first_name as receiver_first_name','receiver.last_name as sender_last_name','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                        ->get();
       
        return response()->json(["message"=>"success",'wages'=> $pending_wages]);
    }

    public function deny_list(){
        $pending_wages = DB::table('wages')
                        ->join('bettings','wages.id','=','bettings.wage_id')
                        ->join('games','games.id','=','wages.game_id')
                        ->join('leagues','games.league_id','=','leagues.id')
                        ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                        ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                        ->join('users as sender','sender.id','=','bettings.sender_id')
                        ->join('users as receiver','receiver.id','=','bettings.receiver_id')
                        ->where('bettings.sender_id',auth()->id())
                        ->orWhere('bettings.receiver_id',auth()->id())
                        ->where('wages.status',2)
                        ->select('wages.*','sender.id as sender_id','sender.first_name as sender_first_name','sender.last_name as sender_last_name','receiver.id as receiver_id','receiver.first_name as receiver_first_name','receiver.last_name as sender_last_name','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                        ->get();
        return response()->json(["message"=>"success",'wages'=> $pending_wages]);
    }

    public function complete_list(){
        $complete_wages = DB::table('wages')
                ->join('bettings','wages.id','=','bettings.wage_id')
                ->join('games','games.id','=','wages.game_id')
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->join('users as sender','sender.id','=','bettings.sender_id')
                ->join('users as receiver','receiver.id','=','bettings.receiver_id')
                ->where('bettings.sender_id',auth()->id())
                ->orWhere('bettings.receiver_id',auth()->id())
                ->where('wages.status',3)
                ->select('wages.*','sender.id as sender_id','sender.first_name as sender_first_name','sender.last_name as sender_last_name','receiver.id as receiver_id','receiver.first_name as receiver_first_name','receiver.last_name as sender_last_name','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return response()->json(["message"=>"success",'wages'=> $complete_wages]);
    }

    public function recent_list(){
        $recent_wages = DB::table('wages')
                        ->join('bettings','wages.id','=','bettings.wage_id')
                        ->join('games','games.id','=','wages.game_id')
                        ->join('leagues','games.league_id','=','leagues.id')
                        ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                        ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                        ->join('users as sender','sender.id','=','bettings.sender_id')
                        ->join('users as receiver','receiver.id','=','bettings.receiver_id')
                        ->where('bettings.sender_id',auth()->id())
                        ->orWhere('bettings.receiver_id',auth()->id())
                        ->where('wages.status',3)
                        ->orderBy('wages.id', 'desc')
                        ->select('wages.*','sender.id as sender_id','sender.first_name as sender_first_name','sender.last_name as sender_last_name','receiver.id as receiver_id','receiver.first_name as receiver_first_name','receiver.last_name as sender_last_name','games.time','games.date_time','home_team.name as home_team_name','home_team.id as home_team_id','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.id as away_team_id','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                        ->take(5)
                        ->get();
                
        return response()->json(["message"=>"success",'wages'=> $recent_wages]);
    }


    public function create_comment(Request $request){
        $wage_id = $request->input('wage_id');
        $sender_id = $request->input('sender_id');
        $receiver_id = auth()->id();
        $content = $request->input('content');
        $star = $request->input('star');
        Comment::create([
            'wage_id' => $wage_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $sender_id,
            'content' => $content,
            'star' => $star
        ]);
        return response()->json(['message' =>'sussess']);
    }

    public function get_comment($id){
        $comment = Comment::find($id);
        return response()->json(['feed' => $comment]);
    }

    public function update_comment(Request $request){
        $comment_id = $request->id;
        $content = $request->content;
        $star = $request->star;
        $comment = Comment::find($comment_id);
        $comment->update(['content'=>$content,'star' => $star]);
        return response()->json(['message' => 'success']);
    }



    public function feeds($id){
        $feeds = DB::table('wages')
                ->join('games','games.id','=','wages.game_id')
                ->join('leagues','games.league_id','=','leagues.id')
                ->join('teams as home_team', 'games.home_team_id', '=','home_team.id')
                ->join('teams as away_team', 'games.away_team_id', '=','away_team.id')
                ->join('comments','wages.id','=','comments.wage_id')
                ->join('users','users.id','=','comments.friend_id')
                ->where('wages.id',$id)
                ->select('comments.content','comments.star','comments.id','users.first_name as friend_first_name','users.last_name as friend_last_name','comments.content','comments.star','home_team.name as home_team_name','home_team.logo as home_team_logo','home_team.odd as home_team_odd','away_team.name as away_team_name','away_team.odd as away_team_odd','away_team.logo as away_team_logo','leagues.name as league_name','leagues.logo as league_logo','leagues.seasons')
                ->get();
        return response()->json(["message"=>"success",'feeds'=> $feeds]);
    }

    public function result($id){
        $wage = Wage::find($id);
        if($wage == null){
            return response()->json(['message'=>"There is no wage"]);
        }
        $sport_id = $wage->sport_id;
        $sport = Sport::find($sport_id);
        $game_id = $wage->game_id;
        $game = Game::find($game_id);
        $base_url = $sport->url;

        $betting_result = Betting::where('wage_id',$id)
                                    ->where('user_id',auth()->id())
                                    ->first();
        if($betting_result->result == ""){
            if($sport_id == 1){
                $curl = curl_init();
                $url = "https://".$base_url."/games/?id=".$game->game_id;
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
                    $game_results = json_decode($response);
                    $real_game  = $game_results->response;
                    if($real_game[0]->status->short == "FT"){
                        $wage->status = 3;
                        $wage->save();
    
                        $home_scores = $real_game[0]->scores->home->total;
                        $home_team = $real_game[0]->teams->home->id;
                        $away_scores = $real_game[0]->scores->away->total;
                        $away_team = $real_game[0]->teams->away->id;
    
                        $my_betting = Betting::where('wage_id',$id)
                                        ->where('user_id',auth()->id())
                                        ->first();
    
                        
                        $my_betting_type = $my_betting->type;
                        $friend_betting_type = ($my_betting_type + 1) % 2;
                        $friend_betting = Betting::where('wage_id',$id)
                                        ->where('type',$friend_betting_type)
                                        ->first();
                        $owner = User::find(auth()->id());
                        $friend = User::find($friend_betting->user_id);
                        $my_betting_odd = $my_betting->odd;
                        $my_betting_team = Team::find($my_betting->team_id)->team_id;
                        if($my_betting_team == $home_team){
                            if($my_betting_odd > 0){
                                if($home_scores > $away_scores || abs($home_scores - $away_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    TransactionHistory::create([
                                        'user_id' => $owner->id,
                                        'amount' => $wage->amount,
                                        'type' => 2,
                                        'fee' => 0
                                    ]);
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($home_scores - $away_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($home_scores - $away_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($home_scores-$away_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }else{
                            if($my_betting_odd > 0){
                                if($away_scores > $home_scores || abs($away_scores - $home_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($away_scores - $home_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($away_scores - $home_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($away_scores-$home_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }
                        
                    }else{
                        return response()->json(["message" => "Not Finish Game yet"]);
                    }
                    
                }
            }else if($sport_id == 2){
                $curl = curl_init();
                $url = "https://".$base_url."/games/?id=".$game->game_id;
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
                    $game_results = json_decode($response);
                    $real_game  = $game_results->response;
                    if($real_game[0]->status->short == "FT"){
                        $wage->status = 3;
                        $wage->save();
    
                        $home_scores = $real_game[0]->scores->home->total;
                        $home_team = $real_game[0]->teams->home->id;
                        $away_scores = $real_game[0]->scores->away->total;
                        $away_team = $real_game[0]->teams->away->id;
    
                        $my_betting = Betting::where('wage_id',$id)
                                        ->where('user_id',auth()->id())
                                        ->first();
    
                        
                        $my_betting_type = $my_betting->type;
                        $friend_betting_type = ($my_betting_type + 1) % 2;
                        $friend_betting = Betting::where('wage_id',$id)
                                        ->where('type',$friend_betting_type)
                                        ->first();
                        $owner = User::find(auth()->id());
                        $friend = User::find($friend_betting->user_id);
                        $my_betting_odd = $my_betting->odd;
                        $my_betting_team = Team::find($my_betting->team_id)->team_id;
                        if($my_betting_team == $home_team){
                            if($my_betting_odd > 0){
                                if($home_scores > $away_scores || abs($home_scores - $away_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($home_scores - $away_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($home_scores - $away_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($home_scores-$away_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }else{
                            if($my_betting_odd > 0){
                                if($away_scores > $home_scores || abs($away_scores - $home_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($away_scores - $home_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($away_scores - $home_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($away_scores-$home_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }
                        
                    }else{
                        return response()->json(["message" => "Not Finish Game yet"]);
                    }
                    
                }
            }else if($sport_id == 3){
                $curl = curl_init();
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
                    $real_game  = $games_results->response;
                    if($real_game[0]->fixture->status->short == "FT"){
                        $wage->status = 3;
                        $wage->save();
                        $home_scores = $real_game[0]->goals->home;
                        $home_team = $real_game[0]->teams->home->id;
                        $away_scores = $real_game[0]->goals->away;
                        $away_team = $real_game[0]->teams->away->id;
    
                        $my_betting = Betting::where('wage_id',$id)
                                        ->where('user_id',auth()->id())
                                        ->first();
    
                        
                        $my_betting_type = $my_betting->type;
                        $friend_betting_type = ($my_betting_type + 1) % 2;
                        $friend_betting = Betting::where('wage_id',$id)
                                        ->where('type',$friend_betting_type)
                                        ->first();
                        $owner = User::find(auth()->id());
                        $friend = User::find($friend_betting->user_id);
                        $my_betting_odd = $my_betting->odd;
                        $my_betting_team = Team::find($my_betting->team_id)->team_id;
                        if($my_betting_team == $home_team){
                            if($my_betting_odd > 0){
                                if($home_scores > $away_scores || abs($home_scores - $away_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($home_scores - $away_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($home_scores - $away_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($home_scores-$away_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }else{
                            if($my_betting_odd > 0){
                                if($away_scores > $home_scores || abs($away_scores - $home_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($away_scores - $home_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($away_scores - $home_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($away_scores-$home_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }
                        
                    }else{
                        return response()->json(["message" => "Not Finish Game yet"]);
                    }
                }
            }else{
                $curl = curl_init();
                $url = "https://".$base_url."/games/?id=".$game->game_id;
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
                    $game_results = json_decode($response);
                    $real_game  = $game_results->response;
                    if($real_game[0]->status->short == "FT"){
                        $wage->status = 3;
                        $wage->save();
    
                        $home_scores = $real_game[0]->scores->home->total;
                        $home_team = $real_game[0]->teams->home->id;
                        $away_scores = $real_game[0]->scores->away->total;
                        $away_team = $real_game[0]->teams->away->id;
    
                        $my_betting = Betting::where('wage_id',$id)
                                        ->where('user_id',auth()->id())
                                        ->first();
    
                        
                        $my_betting_type = $my_betting->type;
                        $friend_betting_type = ($my_betting_type + 1) % 2;
                        $friend_betting = Betting::where('wage_id',$id)
                                        ->where('type',$friend_betting_type)
                                        ->first();
                        $owner = User::find(auth()->id());
                        $friend = User::find($friend_betting->user_id);
                        $my_betting_odd = $my_betting->odd;
                        $my_betting_team = Team::find($my_betting->team_id)->team_id;
                        if($my_betting_team == $home_team){
                            if($my_betting_odd > 0){
                                if($home_scores > $away_scores || abs($home_scores - $away_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($home_scores - $away_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($home_scores - $away_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($home_scores-$away_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }else{
                            if($my_betting_odd > 0){
                                if($away_scores > $home_scores || abs($away_scores - $home_scores) < $my_betting_odd){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
                                if(abs($away_scores - $home_scores) > $my_betting_odd){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }else{
                                if($away_scores - $home_scores > abs($my_betting_odd)){
                                    $my_betting->result = "win";
                                    $my_betting->save();
                                    $friend_betting->result = "lost";
                                    $friend_betting->save();
                                    $owner->balance += $game->amount;
                                    $friend->balance -= $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"win"]);
                                }
    
                                if($away_scores-$home_scores < abs($my_betting_odd) || $home_scores - $away_scores < 0){
                                    $my_betting->result = "lost";
                                    $my_betting->save();
                                    $friend_betting->result = "win";
                                    $friend_betting->save();
                                    $owner->balance -= $game->amount;
                                    $friend->balance += $game->amount;
                                    $owner->save();
                                    $friend->save();
                                    return response()->json(["message"=>"lost"]);
                                }
                            }
                        }
                        
                    }else{
                        return response()->json(["message" => "Not Finish Game yet"]);
                    }
                    
                }
            }
    
        }else{
            return response()->json(["message"=>$betting_result->result]);
        }
        
    }
    
}
