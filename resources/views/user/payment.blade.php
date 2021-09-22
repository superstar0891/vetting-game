@extends('layouts.user')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Payment</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="card-title">Payment Type</h4>
                <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                    <li class="nav-item"><a class="nav-link active" href="#solid-justified-tab1" data-toggle="tab">Deposit</a></li>
                    <li class="nav-item"><a class="nav-link" href="#solid-justified-tab2" data-toggle="tab">Widthraw</a></li>
                   
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="solid-justified-tab1">
                        <div class="row">
                            
                            <div class="col-lg-8 offset-lg-2">
                                <div style="width:100%;padding:30px">
                                   
                                    <form method="POST" class="validation" id="payment-form" role="form" action="/user/deposit" data-cc-on-file="false"    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"    id="payment-form">
                                        <h3 class="page-title">Deposit</h3>
                                        @csrf
                                        @if(session('message') == 'success')
                                        <div class='form-row row'>
                                            <div class='col-md-12 hide error form-group'>
                                                <div class='alert-success alert'>Payment Successed!!!</div>
                                            </div>
                                        </div>
                                        @endif
                                        @if(session('message') == 'failure')
                                        <div class='form-row row'>
                                            <div class='col-md-12 hide error form-group'>
                                                <div class='alert-danger alert'>Payment Failured!!!</div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Amount <span class="text-danger">*</span></label>
                                                    <input autocomplete='off' class="form-control amount"  size='20' type='text' name="card_amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Card Number <span class="text-danger">*</span></label>
                                                    <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_number">
                                                </div>
                                            </div>
                                        </div>
  
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>CVV</label>
                                                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Expire Month</label>
                                                    <input class='form-control card-expiry-month' placeholder='MM' size='4' type='text' name="ccExpiryMonth">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Expire Year</label>
                                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
                                                </div>
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12 text-center m-t-20">
                                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="solid-justified-tab2">
                    <div class="row">   
                            <div class="col-lg-8 offset-lg-2">
                                <div style="width:100%;padding:30px">
                                    <input id="cardholder-name" type="text">
                                    <!-- placeholder for Elements -->
                                    <div id="card-element"></div>
                                    <div id="card-result"></div>
                                    <button id="card-button">Save Card</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    var stripe = Stripe("{{ env('STRIPE_KEY') }}");
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');
    var cardholderName = document.getElementById('cardholder-name');
    var cardButton = document.getElementById('card-button');
    var resultContainer = document.getElementById('card-result');

    cardButton.addEventListener('click', function(ev) {

        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
            name: cardholderName.value,
            },
        }
        ).then(function(result) {
        if (result.error) {
            // Display error.message in your UI
            resultContainer.textContent = result.error.message;
        } else {
            // You have successfully created a new PaymentMethod
            resultContainer.textContent = "Created payment method: " + result.paymentMethod.id;
        }
        });
    });





    var $form  = $(".validation");
    $('form.validation').bind('submit', function(e) {
        var $form         = $(".validation"),
        inputVal  = ['input[type=email]', 'input[type=password]',
                            'input[type=text]', 'input[type=file]',
                            'textarea'].join(', '),
            $inputs       = $form.find('.required').find(inputVal),
            $errorStatus  = $form.find('div.error'),
            valid         = true;
            $errorStatus.addClass('hide');
    
            $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorStatus.removeClass('hide');
                e.preventDefault();
            }
        });
    
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            var key = $form.data('stripe-publishable-key');
            Stripe.setPublishableKey(key);
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    
    });
  
    function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
  
});
</script>
@endsection