@extends('layout.frontend.payment_header') @section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="main_heding">
                <p>{{_i('Payment Details')}}</p>
            </div>
        </div>
    </div>
</div>

<div class="payment_wide mar_tp_40">
    <div class="row">
        <p class='heding_pay'>
            {{_i('Starter Plan')}}
        </p>

        <p class='heding_pay'>
            {{_i('Pay')}} $7 {{_i('initially to get access to 7 videos. You can ask for refund in 14 days.')}}
        </p>
    </div>
    <form class="form-horizontal" id="payments" action="{{route('first-payment')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <?php if(Session::has('add_message')){ ?>
            <span class="error">
         {!! session('add_message') !!} 
        </span>
            <?php }?>
                <div class="row">
                    <h4>{{_i('Payment Details')}}</h4>
                    <div class="input-group">
                        <input type="radio" name="paymentType" class="choosePayment" value="paypal" id="payment-method-card" checked="true" />
                        <label for="payment-method-card">
                            <span><i class="fa fa-cc-visa"></i>Paypal</span>
                        </label>
                        <input type="radio" name="paymentType" class="choosePayment" value="stripe" id="payment-method-paypal" />
                        <label for="payment-method-paypal"> <span><i class="fa fa-cc-paypal"></i>Stripe</span></label>
                    </div>
                    <div class="input-wrapped full" id="validateCard">
                        <input type="text" size="20" name="cardNumber" maxlength="16" id="cardnumber" class="form-control" placeholder="{{_i('Card Number')}}" data-creditcard="true" value="{{ old('cardNumber') }}">
                        <i class="icon-ok"></i>
                        <!-- <i class="icon-ok"></i> -->
                        <!-- <span class="icon-ok"></span> -->
                    </div>
                    <div class="col-half">
                        <div class="input-group input-group-icon">
                            <input type="text" name="CVV2" id="CVV2" value="" placeholder="CVV" class="form-control" value="{{ old('CVV2') }}" required/>
                            <div class="input-icon"><i class="fa fa-user"></i></div>
                        </div>
                    </div>
                    <div class="col-half">
                        <div class="input-group">
                            <select id="month" name="month" value="{{ old('month') }}">
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="10">9</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select id="year" name="year" value="{{ old('year') }}">
                                <?php
              for ($i=date("Y"); $i < 2100 ; $i++) { ?>
                                    <option value="<?php echo $i;?>">
                                        <?php echo $i;?>
                                    </option>
                                    <?php } ?>
                            </select>

                        </div>
                    </div>
                    <div class="input-group input-group-icon">
                        <input type="text" name="BILLTOFIRSTNAME" id="BILLTOFIRSTNAME" placeholder="{{_i('First Name')}}" value="{{ old('BILLTOFIRSTNAME') }}" />
                        <div class="input-icon"><i class="fa fa-user"></i></div>
                    </div>
                    <div class="input-group input-group-icon">
                        <input type="text" name="BILLTOLASTNAME" id="BILLTOLASTNAME" placeholder="{{_i('Last Name')}}" value="{{ old('BILLTOLASTNAME') }}" />
                        <div class="input-icon"><i class="fa fa-user"></i></div>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="btn btn-info submit" type="submit">{{_i('Pay Now')}}</button>
                </div>
    </form>
</div>

<div class="col-sm-12" id="stripe-form" style="display:none">
    <form class="form-horizontal" id="payments-stripe" action="{{route('first-payment')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="hidden" name="paymentType" id="paymentType" value="stripe">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                        Payment Details
                    </h3>
            </div>
            <div class="panel-body">

                <form action="your-server-side-code" method="POST">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?php echo $publishable_key;?>" data-amount="700" data-name="Digitalkheops" data-description="Starter plan charges" data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto" data-zip-code="true" data-email="<?php echo $email; ?>">
                    </script>
                </form>
            </div>
        </div>

        <br/>
    </form>
</div>
@endsection