@extends('layouts.user')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Withdraw Payment</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    <div class="col-lg-6 offset-lg-3">
                        <div style="width:100%;padding:30px">
                            
                            <form method="POST" class="validation" id="payment-form" role="form" action="/user/payment/withdraw" data-cc-on-file="false"    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"    id="payment-form">
                                <div class="row">
                                    <div class="col-md-4"><h4>Total Balance : </h4></div>
                                    <div class="col-md-4"><h4 id="total_balance">{{Auth::user()->balance}}</h4></div>
                                </div>
                                
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Amount <span class="text-danger">*</span></label>
                                            <input autocomplete='off' class="form-control amount"  size='20' type='text' id="amount" name="amount">
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
                                        <button type="button" onclick="javascript:withdraw()" class="btn btn-primary submit-btn" id="btn_deposit">Make a Deposit</button>
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
<script type="text/javascript">
    function withdraw(){
        
        var form  = document.getElementById("payment-form");
        var total =  document.getElementById("total_balance").innerText ;
        var withdraw =   document.getElementById("amount").value ;
        
        if(total < withdraw){
            alert("Withdraw amount is very large");
            return;
        }else{
            form.submit();
        }
    }
    
</script>
@endsection