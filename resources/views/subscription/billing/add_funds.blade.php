@extends('layouts.app')
@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Add Funds</h1>
</div>
@endif
@include('subscription._nav')
@if(auth()->user()->currentTeam->status == 'decline')
<div class="row-fluid">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">
                    Fix your billing issue
                </h1>
            </div>
            <div class="card-block">
                <a href="{{ route('billing.retry') }}" class="btn btn-primary">
                    <i class="fa fa-credit-card"></i>
                    Retry Card
                </a>

                <hr>

                <a class="btn btn-default" href="{{ route('plans.card') }}">
                    <i class="fa fa-credit-card"></i>
                    {{ auth()->user()->currentTeam->hasCardOnFile() ? 'Update Card' : 'Add Card' }}
                </a>




            </div>
        </div>
    </div>
</div>
@else
<div class="row-fluid">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Add Funds (Balance: @money($balance))</h1>
            </div>
            <div class="card-block">
                <form action="{{ route('billing.funds') }}" method="POST" id="funds">
                    {{ csrf_field() }}
                    <div class="card-block card-block-light ml-3">
                        <label>How much would you like to add?</label>
                        <fieldset class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-2 form-control-label" style="text-align:right;"
                                title="Amount">Amount</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <input name="amount" type="text" class="form-control" value="" autocomplete="off"
                                        placeholder="25.00">
                                </div>
                                @if ($errors->has('amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </fieldset>
                        @if( auth()->user()->currentTeam->hasCardOnFile() && !empty(
                        auth()->user()->currentTeam->defaultCard()
                        ))
                        <fieldset class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-2 form-control-label" style="text-align:right;">Payment
                                Method</label>
                            <div class="col-md-8">
                                <select name="card" class="form-control">
                                    @foreach($cards as $card)
                                    <option value="{{ $card->id }}" {{ $card->fingerprint === $default->fingerprint ?
                                        'selected' : '' }}>
                                        {{ $card->card_brand }}
                                        ****
                                        {{ $card->card_last_four }}
                                        exp. {{ $card->exp_month }}/{{ $card->exp_year }}
                                        {{ $card->fingerprint === $default->fingerprint ? ' (Default)' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('plans.card') }}">Add New Payment Method...</a>
                            </div>
                        </fieldset>
                        <button class="btn btn-success" type="button" id="submit_btn">
                            <i class="fa fa-plus"></i>
                            Add Funds
                        </button>
                        @else
                        <a href="{{ route('plans.card') }}">Add New Payment Method...</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Checks</h2>
            </div>
            <div class="card-block card-block-light ml-3">
                <h0>You can also send a check. How to send a check:</h0>
                <span class="small d-block">Please send to:</span>
                <span class="small d-block">Dataczar Corporation</span>
                <span class="small d-block">2292 Faraday Ave Ste 100</span>
                <span class="small d-block">Carlsbad, CA 92008</span>
                <span class="small d-block mb-3">In the memo of the check please include: Account
                    #{{auth()->user()->currentTeam->id}}</span>
                <p><i>Note there is a fee for returned checks.</i></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Other</h2>
            </div>
            <div class="card-block card-block-light ml-3">
                <h0>Other ways to add funds to your account:</h0>
                <div id="smart-button-container">
                    <div style="">
                        <label for="amount">Amount </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-dollar"></i>
                            </span>
                            <input name="amountInput" type="number" id="amount" class="form-control" value=""
                                autocomplete="off" placeholder="25.00">
                        </div>
                        <p id="priceLabelError" style="visibility: hidden; color:red; text-align: center;">Please enter
                            a price</p>
                    </div>
                    <input name="invoiceid" maxlength="127" type="hidden" id="invoiceid"
                        value="{{ $paypal_invoice_id }}">
                    <div style="text-align: center; margin-top: 0.625rem;" id="paypal-button-container"></div>
                </div>
                <script src="{{ env('PAYPAL_SDK') }}" data-sdk-integration-source="button-factory"></script>

            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Current Account Balance: {{ $balance }}
            </div>
            <ul class="list-group">
                <li class="list-group-item text-center">
                    Transactions
                </li>
                @foreach($balances as $bal)
                <li class="list-group-item">
                    {{ $bal->created_at->format('m/d/Y') }}
                    <div class="float-right">
                        + {{ $bal->amount }}
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

<div class="row-fluid">
    <div class="col-md-12">




    </div>
</div>

@endif {{-- end decline check --}}


@endsection
@section('js')

<script type="text/javascript">
    $(document).ready(function(){
    $('#submit_btn').on('click', function(e){
        e.preventDefault();
        $('#submit_btn').attr("disabled", true);
        $('#funds').submit();
    });

/* 
    paypal stuff
*/
    function initPayPalButton() {
        var amount = document.querySelector('#smart-button-container #amount');
        var priceError = document.querySelector('#smart-button-container #priceLabelError');
        var invoiceid = document.querySelector('#smart-button-container #invoiceid');
        
        var elArr = [amount];

        var purchase_units = [];
        purchase_units[0] = {};
        purchase_units[0].amount = {};

        function validate(event) {
            return event.value.length > 0;
        }

        paypal.Buttons({
            style: {
            color: 'silver',
            shape: 'pill',
            label: 'paypal',
            layout: 'vertical',
            
            },

            onInit: function (data, actions) {
            actions.disable();

            elArr.forEach(function (item) {
                item.addEventListener('keyup', function (event) {
                var result = elArr.every(validate);
                if (result) {
                    actions.enable();
                } else {
                    actions.disable();
                }
                });
            });
            },

            onClick: function () {

            if (amount.value.length < 1) {
                priceError.style.visibility = "visible";
            } else {
                priceError.style.visibility = "hidden";
            }

            purchase_units[0].amount.value = amount.value;

            if(invoiceid.value !== '') {
                purchase_units[0].invoice_id = invoiceid.value;
            }
            },

            createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: purchase_units,
            });
            },
            onApprove: function(data) {
            return fetch('{{ route('paypay.capture_order2') }}', {
                method: 'POST',
                headers: {
                    'content-type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    orderID: data.orderID
                })
            }).then(function(res) {
                return res.json();
            }).then(function(details) {
                if(details.status == 'success') {
                    window.location = '{{ route("billing.funds.paypal_success") }}';
                } else {
                    alert('Something went wrong, please contact support.');
                }
            })
        },


            onError: function (err) {
            console.log(err);
            }
        }).render('#paypal-button-container');
        }
        initPayPalButton();
});
</script>

@endsection