@extends('fe.layouts.app')
@section('content')
    {{-- @if($headless != true and $hidetitle != true) --}}
    <div>
        <h1 class="page-heading">
            Payment Methods
        </h1>
    </div>
    {{-- @endif --}}
    @include('fe.billing._nav')

    @if($errors->count() > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif


    <div class="row-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title">
                                Payment Methods
                            </h4>
                            <p class="card-subtitle"></p>
                        </div>
                        <div class="media-right media-middle">

                        </div>
                    </div>
                </div>
                <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                    <ul class="list-group">
                        <li class="list-group-item row hidden-lg-down row ">
                            <div class="col-lg-2"><strong>Type</strong></div>
                            <div class="col-lg-3"><strong>Account Ending</strong></div>
                            <div class="col-lg-3"><strong>Expiration</strong></div>
                            <div class="col-lg-4"><strong></strong></div>
                        </li>
                    </ul>
                </div>        </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title">
                                Add Card
                            </h4>
                            <p class="card-subtitle"></p>
                        </div>
                        <div class="media-right media-middle">

                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <form action="https://connect.dataczar.com/accounts/payments/12353?redir=plans.index" method="post" id="payment-form">
                        @csrf
                        <div class="row form-group">
                            <label class="col-md-12 form-control-label">Credit or debit card</label>
                            <div class="col-md-12">
                                <div id="card-element" class="form-control StripeElement StripeElement--empty">
                                    <div class="__PrivateStripeElement" style="margin: 0px !important; padding: 0px !important; border: medium none !important; display: block !important; background: transparent none repeat scroll 0% 0% !important; position: relative !important; opacity: 1 !important;">
                                        <iframe name="__privateStripeFrame3105" allowtransparency="true" scrolling="no" allow="payment *"
                                                src="https://js.stripe.com/v3/elements-inner-card-c92453e99ee2138c5b0319670780154e.html#wait=false&amp;mids[guid]=NA&amp;mids[muid]=5919dc76-9817-4567-a562-9df351578540fc6d94&amp;mids[sid]=6829c852-ec85-4d63-8c57-9aff97840b9a71bec2&amp;style[base][color]=%2332325d&amp;style[base][lineHeight]=24px&amp;style[base][fontFamily]=%22Helvetica+Neue%22%2C+Helvetica%2C+sans-serif&amp;style[base][fontSmoothing]=antialiased&amp;style[base][fontSize]=16px&amp;style[base][::placeholder][color]=%23aab7c4&amp;style[invalid][color]=%23fa755a&amp;style[invalid][iconColor]=%23fa755a&amp;rtl=false&amp;componentName=card&amp;keyMode=live&amp;apiKey=pk_live_EIGPcQmmXF8TVahM7JJB4mG0&amp;referrer=https%3A%2F%2Fconnect.dataczar.com%2Fbilling%2Fplans%2Fcard&amp;controllerId=__privateStripeController3101" title="Secure card payment input frame" style="border: medium none !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; user-select: none !important; transform: translate(0px) !important; height: 24px;" frameborder="0"></iframe><input class="__PrivateStripeElement-input" aria-hidden="true" aria-label=" " autocomplete="false" maxlength="1" style="border: medium none !important; display: block !important; position: absolute !important; height: 1px !important; top: -1px !important; left: 0px !important; padding: 0px !important; margin: 0px !important; width: 100% !important; opacity: 0 !important; background: transparent none repeat scroll 0% 0% !important; pointer-events: none !important; font-size: 16px !important;">
                                    </div>
                                </div>
                                <span class="help-block">
                                    <div id="card-errors" role="alert"></div>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit_btn">
                            Add Card</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <link rel="stylesheet" type="text/css"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.delete').on('click', function(e){
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to request the deletion of this payment method?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'DELETE'],
                })
                        .then(willDelete => {
                    if (willDelete) {
                        var url = $(this).data('url');
                        var id = $(this).data('id');
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(result) {
                                window.location.reload(true);
                            }
                        });
                    }
                });
            });

        });
    </script>

@endsection