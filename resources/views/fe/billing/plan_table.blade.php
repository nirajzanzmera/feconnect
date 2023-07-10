@extends('fe.layouts.app')
@section('content')
    {{-- @if($headless != true and $hidetitle != true) --}}
    <div>
        <h1 class="page-heading">
            Accounts
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
                            <h4 class="card-title">Plans</h4>
                            <p class="card-subtitle"></p>
                        </div>
                        <div class="media-right media-middle">

                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <p>
                        <strong>Current Plan: </strong>
                        None, select a plan below to start sending!
                    </p>
                </div>
                <style type="text/css">
                    .active-plan {
                        font-weight: bold;
                        border: 2px solid #ddd;
                    }

                    .table-matrix th,
                    .table-matrix td {
                        text-align: center;
                    }
                    .table-matrix td:first-child {
                        text-align: right;
                    }
                    @media  only screen and (max-width: 992px) {
                        .table-matrix td, .table-matrix th {
                            font-size: 90%;
                        }
                    }
                    /*
                    .table-matrix td:nth-child(4),
                    .table-matrix th:nth-child(4) {
                        font-weight: bold;
                        background-color: #eee;
                        border-left: 1px solid #ccc;
                        border-right: 1px solid #ccc;
                    } */

                </style>
                <div class="card-block" style="background:lightgray;">
                    <div class="input-group ">
                        <label class="form-control-label" for="billing_option_select"><strong>Billing Option:</strong></label>
                        <select class="form-control" onchange="function_billing_frequency(value);" id="billing_option_select">
                            <?php $cnt = 1; ?>
                            @foreach($prices as $price)
                                <option value="{{ $price->value }}">
                                    {{ $price->name }}
                                </option>
                                <?php $cnt++; ?>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="card-body table-sm table table-striped table-matrix">
                        <thead class="thead-dark">
                        <tr>
                            <th>
                            </th>
                            <th>
                                Basic
                            </th>
                            <th>
                                Pro
                            </th>
                            <th>
                                Deluxe
                            </th>
                        </tr>
                        </thead>
                        <tbody>


                        <tr id="bill-option-month" class="">
                            <td>Monthly</td>
                            @foreach($prices->monthly->plans as $k => $plans)
                                <td>
                                    {{ $plans->reg_price }}
                                    <br>
                                    <a href="{{ $plans->buyurl }}" id="addtocart-{{ $k }}-month" class="btn btn-sm btn-primary">Add to Cart</a>
                                </td>
                            @endforeach
                        </tr>

                        <tr id="bill-option-3month" class="hide">
                            <td>Quarterly (10% off)</td>
                            @foreach($prices->quarterly->plans as $k => $plans)
                                <td>
                                    <del>{{ $plans->reg_price }}</del>   <br>
                                    {{ $plans->mo_cost }}<br>
                                    <div class="font-italic">{{ $plans->bill_rate }}</div>
                                    <a href="{{ $plans->buyurl }}" id="addtocart-{{ $k }}-3month" class="btn btn-sm btn-primary">Add to Cart</a>
                                </td>
                            @endforeach
                        </tr>

                        <tr id="bill-option-6month" class="hide">
                            <td>Semi-Annual (15% off)</td>
                            @foreach($prices->semiannually->plans as $k => $plans)
                                <td>
                                    <del>{{ $plans->reg_price }}</del>   <br>
                                    {{ $plans->mo_cost }}<br>
                                    <div class="font-italic">{{ $plans->bill_rate }}</div>
                                    <a href="{{ $plans->buyurl }}" id="addtocart-{{ $k }}-6month" class="btn btn-sm btn-primary">Add to Cart</a>
                                </td>
                            @endforeach
                        </tr>

                        <tr id="bill-option-year" class="hide">
                            <td>Annual (20% off)</td>
                            @foreach($prices->annually->plans as $k => $plans)
                                <td>
                                    <del>{{ $plans->reg_price }}</del>   <br>
                                    {{ $plans->mo_cost }}<br>
                                    <div class="font-italic">{{ $plans->bill_rate }}</div>
                                    <a href="{{ $plans->buyurl }}" id="addtocart-{{ $k }}-year" class="btn btn-sm btn-primary">Add to Cart</a>
                                </td>

                            @endforeach
                        </tr>

                        <tr>
                            <td>Send emails per month from your website</td>
                            <td>2000</td>
                            <td>5000</td>
                            <td>25,000</td>
                        </tr>
                        <tr>
                            <td>Web traffic included</td>
                            <td>50 GB</td>
                            <td>100 GB</td>
                            <td>200 GB</td>
                        </tr>
                        <tr>
                            <td>Hosting Included (Website Accounts)</td>
                            <td>1</td>
                            <td>5</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td>Mailboxes Included</td>
                            <td>1</td>
                            <td>2</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Automatic newsletter generation, scheduling and optimization</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Email-subscription form with list management and monitoring</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Track email performance in real-time</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Preview Website Builder</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Build your own fast and responsive website</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Custom Domain Name</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Domain Hosting and Domain Renewals </td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Private Domain Registration</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Create personal email addresses with each domain</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Content Delivery Network</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Secure SSL (https://)</td>
                            <td>X</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Unlimited Storage</td>
                            <td>&nbsp;</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Dedicated Account Rep</td>
                            <td>&nbsp;</td>
                            <td>X</td>
                            <td>X</td>
                        </tr>

                        </tbody>
                    </table>
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
    <script type="text/javascript">
        function function_billing_frequency($i) {
            var liHide = document.querySelectorAll("[id^=bill-option-]");
            for(var i=0; i<liHide.length; i++){
                if(liHide[i].id=="bill-option-"+$i){
                    liHide[i].classList.remove('hide');
                }
                else {
                    liHide[i].classList.add('hide');
                }
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#switch_free').on('click', function(e){
                e.preventDefault();

                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to lose access to your custom domain name?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'Confirm'],
                })
                        .then(willSwitchFree => {
                    if (willSwitchFree) {
                        $('#switch_free_form').submit()
                    }
                });
            });
        });

    </script>
@endsection