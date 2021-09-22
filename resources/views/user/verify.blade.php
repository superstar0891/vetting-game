@extends('layouts.user')

@section('content')
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Payment Verification</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                <div class="col-lg-6 offset-lg-3">
                        <div style="width:100%;padding:30px">
                            <form method="POST" class="validation" id="payment-form" role="form" action="/user/payment/checkout" data-cc-on-file="false"    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"    id="payment-form">
                                @if( Auth::user()->payment_verify == 1)
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <h4>You have already been done the Payment Verify</h4>
                                            <h5>{{Auth::user()->payment_email}}</h5>
                                        </div>
                                    </div>
                                
                                @endif    
                                    @if ($message = Session::get('error'))
                                    <h4>{!! $message !!}<h4>
                                    <?php Session::forget('error');?>
                                    @endif
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn btn-primary submit-btn">Verify with Paypal</button>
                                        </div>
                                    </div>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>

</script>
@endsection