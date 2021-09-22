@extends('layouts.user')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Wage History</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    <h6 class="card-title text-bold">Wage Tables</h6>
                    <div class="table-responsive">
                        <table class="datatable table table-stripped ">
                        <thead>
                            <tr>
                                <th>Game Name</th>
                                <th>Seasons</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Home Team</th>
                                <th>Away Team</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wages as $wage)
                            <tr>
                                <td>{{ $wage->league_name }}</td>
                                <td>{{ $wage->seasons }}</td>
                                <td>{{ $wage->date_time }}</td>
                                <td>{{ $wage->time }}</td>
                                <td>{{ $wage->home_team_name }}</td>
                                <td>{{ $wage->away_team_name }}</td>
                                <td>
                               
                                    @if($wage->status == 0)
                                    Pending
                                    @elseif ($wage->status == 1)
                                    Accept
                                    @elseif ($wage->status == 2)
                                    Deny
                                    @else
                                    Complete
                                    @endif
                                
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection