@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="page-title">{{$sport->name}} Tables</h4>
        </div>
        @if( count($games) == 0)
        <div class="col-sm-7 col-7 text-right m-b-30">
            <form action = "/admin/bettings/{{$sport->id}}" method="post">
                @csrf
                <button  class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i>Loading Games</button>
            </form>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    
                    <div class="table-responsive">
                        <table class="datatable table table-stripped ">
                        <thead>
                            <tr>
                                <th>Game Name</th>
                                <th>Game Time</th>
                                <th>Game TimeZone</th>
                                <th>Seasons</th>
                                <th>Home Team Name</th>
                                <th>Home Team Odd</th>
                                <th>Away Team Name</th>
                                <th>Away Team Odd</th>
                                <th>Actions</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($games as $game)
                            <tr>
                            <td>{{$game->league_name}}</td>
                                <td>{{$game->time}}</td>
                                <td>{{$game->timezone}}</td>
                                <td>{{$game->seasons}}</td>
                                <td>{{$game->home_team_name}}</td>
                                <td>{{$game->home_team_odd}}</td>
                                <td>{{$game->away_team_name}}</td>
                                <td>{{$game->away_team_odd}}</td>
                                <td><button type="button" class="btn btn-success" onclick="javascript:change_odds('{{$game->id}}')">Change Odds</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="update_modal" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <form method="POST" action="/admin/games/updateOdds">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label id="home_name"></label>
                                <input type="hidden" name="home_id" id="home_id"/>
                                <input  class="form-control "   type='text' id="home_odd" name="home_odd">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label id="away_name"></label>
                                <input type="hidden" name="away_id" id="away_id"/>
                                <input  class="form-control "   type='text' id="away_odd" name="away_odd">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                            <a href="#" class="btn btn-success submit-btn" data-dismiss="modal">Cancel</a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function change_odds(id){
        var _token = $("input[name='_token']").val();
        $.ajax({
            url:'/admin/games/getOdds',
            data:{
                id      :   id,
                _token  :   _token
            },
            type:'post',
            success: function(data){
                
                var home = data.home;
                $('#home_name').text("Home Team : " +home.name);
                $('#home_id').val(home.id);
                $('#home_odd').val(home.odd);
                var away = data.away;
                console.log(away.odd);
                $('#away_name').text("Away Team : " + away.name);
                $('#away_id').val(away.id);
                $('#away_odd').val(away.odd);
                $('#update_modal').modal();
            }
        })
    }
</script>
@endsection