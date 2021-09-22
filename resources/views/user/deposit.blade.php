@extends('layouts.user')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">My Friends</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    <div class="col-lg-6 offset-lg-3">
                        <div style="width:100%;padding:30px">
                            
                            <form method="POST" class="validation" id="payment-form" role="form" action="/user/payment/pay" data-cc-on-file="false"    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"    id="payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Amount <span class="text-danger">*</span></label>
                                            <input autocomplete='off' class="form-control amount"  size='20' type='text' name="amount">
                                            @if ($errors->has('amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary submit-btn">Make a Deposit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection