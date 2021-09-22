@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg1"><i class="fa fa-user-o" aria-hidden="true"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$user_count}}</h3>
                    <span class="widget-title1">Users <i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg2"><i class="fa fa-money"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>${{$transaction_count}}</h3>
                    <span class="widget-title2">Balance <i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg3"><i class="fa fa-cube" aria-hidden="true"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$completed_count}}</h3>
                    <span class="widget-title3">Completed Wages <i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg4"><i class="fa fa-cube" aria-hidden="true"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{$pending_count}}</h3>
                    <span class="widget-title4">Pending Wages <i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-inline-block">Users</h4> <a href="/admin/users" class="btn btn-primary float-right">View all</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="d-none">
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Payment Verify</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <a class="avatar"></a>
                                    </td>    
                                    <td><h5>{{$user->first_name}} {{$user->last_name}}</h5></td>             
                                    <td>
                                        <h5 class="time-title p-0">{{$user->email}}</h5>
                                        
                                    </td>
                                    <td>
                                        @if($user->payment_verify == 1)
                                        Verified
                                        @else
                                        UnVerify
                                        @endif
                                    </td>
                                    <td>{{$user->created_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-inline-block">Transactions</h4> <a href="/admin/payments" class="btn btn-primary float-right">View all</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="d-none">
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Fee</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->first_name}}</td>
                                    <td>{{$transaction->last_name}}</td>
                                    <td>{{$transaction->email}}</td>
                                    <td>{{$transaction->fee}}</td>
                                    <td>
                                        @if($transaction->type == 3)
                                            Deposit
                                        @elseif($transaction->type == 4)
                                            Withdraw
                                        @else
                                            Verify
                                        @endif
                                    </td>
                                    <td>{{$transaction->created_at}}</td>
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
@endsection
