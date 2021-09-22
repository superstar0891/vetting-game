@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Transactions Tables</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    <h6 class="card-title text-bold">Total Admin Balance : ${{$total}}</h6>
                    
                    <div class="table-responsive">
                        <table class="datatable table table-stripped ">
                        <thead>
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
                                    @elseif($transaction->type == 1)
                                        Send
                                    @elseif($transaction->type == 2)
                                        Receive
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

@endsection