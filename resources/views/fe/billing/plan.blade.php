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
                <style>
                    .best-plan {
                        background-color: #7977c7b5;
                    }
                    @media (min-width: 1200px) {
                        .border-xl {
                            border: 1px solid!important;
                        }
                    }
                    @media (max-width: 1199px) {
                        .ordinary-plan {
                            background-color: #fff;
                        }
                        .ordinary-plan .card {
                            box-shadow: none!important;
                        }
                    }
                </style>
                <div class="card-block">
                    <p>
                        <strong>Current Plan: </strong>
                        None, select a plan below to start sending!
                    </p>
                </div>
            </div>

            <div class=" pl-0 pr-0">
                <div id="plans_app" class="row">

                    <div class="col-xl-6 best-plan pt-2 px-2 pb-1">
                        <h6 class="h6 text-uppercase text-center">Best Value</h6>
                        <div class="card mb-1">
                            <div class="card-block row">

                                <div class="col-sm-6">
                                    <h3 class="font-weight-bolder">PRO</h3>
                                    <div class="card-block pr-sm-0 pr-xl-1">
                                        <ul class="list-group">
                                            <li class="">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1">Hosting Included</p>
                                                    <small>5</small>
                                                </div>
                                            </li>
                                            <li class="">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1">Emails Included</p>
                                                    <small>5,000</small>
                                                </div>
                                            </li>
                                            <li class="">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1">Web Traffic Included</p>
                                                    <small>100 GB</small>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio">
                                            <input checked v-on:change="pro_cart = true; monthly = true; plan_id = {{ $prices->monthly->plans->pro->plan_id }}" type="radio" class="custom-control-input" id="pro_monthly_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="pro_monthly_billing"><strong>Monthly</strong></label>
                                        </div>
                                        <p class="pl-4 mb-1"><strong class="font-weight-bold">{{ substr($prices->monthly->plans->pro->reg_price, 0, strpos($prices->monthly->plans->pro->reg_price, "/")); }}/month</strong></p>
                                        <small class="pl-4">Auto-renewing at {{ substr($prices->monthly->plans->pro->reg_price, 0, strpos($prices->monthly->plans->pro->reg_price, "/")); }} monthly</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio">
                                            <input v-on:change="pro_cart = true; monthly = false; plan_id = {{ $prices->annually->plans->pro->plan_id }}" type="radio" class="custom-control-input" id="pro_annual_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="pro_annual_billing">
                                                <strong>Annual</strong>
                                                <span class="small text-uppercase text-danger" style="font-size: 10px;">best value</span>
                                            </label>
                                        </div>
                                        <p class="pl-4 mb-1"><del>{{ substr($prices->monthly->plans->pro->reg_price, 0, strpos($prices->monthly->plans->pro->reg_price, "/")); }}</del><strong class="ml-1 font-weight-bold">{{ substr($prices->annually->plans->pro->mo_cost, 0, strpos($prices->annually->plans->pro->mo_cost, "/")); }}/monthly</strong></p>
                                        <small class="pl-4">Auto-renewing at {{ substr($prices->annually->plans->pro->bill_rate, 0, strpos($prices->annually->plans->pro->bill_rate, "/"));}} annually</small>
                                    </div>
                                    <a :href="(pro_cart && monthly) ? '{{ $prices->monthly->plans->pro->buyurl }}' : '{{ $prices->annually->plans->pro->buyurl }}'" id="addtocart-pro" :class="[(pro_cart) ? '' : 'disabled']" class="btn btn-md btn-block btn-primary">Add to Cart</a>

                                </div>
                            </div>
                            <div class="card-block ">
                                <div class="row d-flex justify-content-center">
                                    <div class="row form-group justify-content-center">
                                        <a href="#" v-if="!more_options" @click.prevent="more_options = true" class="btn btn-default btn-sm">
                                            <i class="fa fa-plus"></i> more detail
                                        </a>
                                        <a href="#" v-if="more_options" @click.prevent="more_options = false" class="btn btn-default btn-sm">
                                            <i class="fa fa-minus"></i> less detail
                                        </a>
                                    </div>
                                </div>
                                <div class="row" v-if="more_options">
                                    <div class="card-block ">
                                        <label class="pl-2">This plan also includes:</label>
                                        <ul>
                                            <li>Automatic newsletter generation, scheduling and optimization</li>
                                            <li>Email-subscription form with list management and monitoring</li>
                                            <li>Track email performance in real-time</li>
                                            <li>Preview Website Builder</li>
                                            <li>Build your own fast and responsive website</li>
                                            <li>Custom Domain Name</li>
                                            <li>Domain Hosting and Domain Renewals </li>
                                            <li>Private Domain Registration</li>
                                            <li>Create personal email addresses with each domain</li>
                                            <li>Content Delivery Network</li>
                                            <li></i>Secure SSL (https://)</li>
                                            <li>Unlimited Storage</li>
                                            <li>Dedicated Account Rep</li>
                                            <li>And so much more!</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="card-block">
                                <hr>
                            </div>
                            <div class="card-block d-flex justify-content-center">
                                <a class="btn btn-default btn-sm" href="{{ route('billing.plans.table') }}">
                                    View More Billing Options
                                </a>
                            </div>
                        </div>
                    </div>



                    <div class="ordinary-plan col-xl-6 mt-3 mt-xl-0">
                        <div class="card border-0 border-xl border-secondary mb-1 h-100">
                            <div class="card-block row pt-5">
                                <div class="col-sm-6">
                                    <h3 class="font-weight-bolder">DELUXE</h3>
                                    <div class="card-block pr-sm-0 pr-xl-1">
                                        <ul class="list-group">
                                            <li class="">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1">Hosting Included</p>
                                                    <small>Unlimited</small>
                                                </div>
                                            </li>
                                            <li class="">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1">Emails Included</p>
                                                    <small>25,000</small>
                                                </div>
                                            </li>
                                            <li class="">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1">Web Traffic Included</p>
                                                    <small>200 GB</small>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio">
                                            <input v-on:change="pro_cart = false; monthly = true; plan_id = {{ $prices->monthly->plans->deluxe->plan_id }}" type="radio" class="custom-control-input" id="deluxe_monthly_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="deluxe_monthly_billing"><strong>Monthly</strong></label>
                                        </div>
                                        <p class="pl-4 mb-1"><strong class="font-weight-bold">{{ substr($prices->monthly->plans->deluxe->reg_price, 0, strpos($prices->monthly->plans->deluxe->reg_price, "/")); }}/month</strong></p>
                                        <small class="pl-4">Auto-renewing at {{ substr($prices->monthly->plans->deluxe->reg_price, 0, strpos($prices->monthly->plans->deluxe->reg_price, "/")); }} monthly</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio">
                                            <input v-on:change="pro_cart = false; monthly = false; plan_id = {{ $prices->annually->plans->deluxe->plan_id }}" type="radio" class="custom-control-input" id="deluxe_annual_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="deluxe_annual_billing">
                                                <strong>Annual</strong>
                                                <span class="small text-uppercase text-danger" style="font-size: 10px;">best value</span>
                                            </label>
                                        </div>
                                        <p class="pl-4 mb-1"><del>{{ substr($prices->annually->plans->deluxe->reg_price, 0, strpos($prices->annually->plans->deluxe->reg_price, "/")); }}</del><strong class="ml-1 font-weight-bold">{{ substr($prices->annually->plans->deluxe->mo_cost, 0, strpos($prices->annually->plans->deluxe->mo_cost, "/")); }}/monthly</strong></p>
                                        <small class="pl-4">Auto-renewing at {{ substr($prices->annually->plans->deluxe->bill_rate, 0, strpos($prices->annually->plans->deluxe->bill_rate, "/")); }} annually</small>
                                    </div>
                                    <a :href="(!pro_cart && monthly) ? '{{ $prices->monthly->plans->deluxe->buyurl }}' : '{{ $prices->annually->plans->deluxe->buyurl }}'" id="addtocart-deluxe" :class="[(!pro_cart) ? '' : 'disabled']" class="btn btn-md btn-block btn-primary">Add to Cart</a>
                                </div>
                            </div>
                            <div class="card-block ">
                                <div class="row d-flex justify-content-center">
                                    <div class="row form-group justify-content-center">
                                        <a href="#" v-if="!more_options" @click.prevent="more_options = true" class="btn btn-default btn-sm">
                                            <i class="fa fa-plus"></i> more detail
                                        </a>
                                        <a href="#" v-if="more_options" @click.prevent="more_options = false" class="btn btn-default btn-sm">
                                            <i class="fa fa-minus"></i> less detail
                                        </a>
                                    </div>
                                </div>
                                <div class="row" v-if="more_options">
                                    <div class="card-block ">
                                        <label class="pl-2">This plan also includes:</label>
                                        <ul>
                                            <li>Automatic newsletter generation, scheduling and optimization</li>
                                            <li>Email-subscription form with list management and monitoring</li>
                                            <li>Track email performance in real-time</li>
                                            <li>Preview Website Builder</li>
                                            <li>Build your own fast and responsive website</li>
                                            <li>Custom Domain Name</li>
                                            <li>Domain Hosting and Domain Renewals </li>
                                            <li>Private Domain Registration</li>
                                            <li>Create personal email addresses with each domain</li>
                                            <li>Content Delivery Network</li>
                                            <li>Secure SSL (https://)</li>
                                            <li>Unlimited Storage</li>
                                            <li>Dedicated Account Rep</li>
                                            <li>And so much more!</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="card-block">
                                <hr>
                            </div>
                            <div class="card-block d-flex justify-content-center">
                                <a class="btn btn-default btn-sm" href="{{ route('billing.plans.table') }}">
                                    View More Billing Options
                                </a>
                            </div>
                        </div>
                    </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.js"></script>

    <script type="text/javascript">
        var app = new Vue({
            el: '#plans_app',
            data () {
                return {
                    'more_options_pro': false,
                    'more_options_deluxe': false,
                    'more_options': false,
                    'pro_cart': true,
                    'monthly': true,
                    'plan_id': null,
                    'routes': {
                        'choose': {
                            'monthly': {
                                'pro': 'https://connect.dataczar.com/billing/plans/3/add',
                                'deluxe': 'https://connect.dataczar.com/billing/plans/4/add',
                            },
                            'annually': {
                                'pro': 'https://connect.dataczar.com/billing/plans/13/add',
                                'deluxe': 'https://connect.dataczar.com/billing/plans/16/add',
                            },
                        },
                        'switch': {
                            'monthly': {
                                'pro': 'https://connect.dataczar.com/billing/plans/3/swap',
                                'deluxe': 'https://connect.dataczar.com/billing/plans/4/swap',
                            },
                            'annually': {
                                'pro': 'https://connect.dataczar.com/billing/plans/13/swap',
                                'deluxe': 'https://connect.dataczar.com/billing/plans/16/swap',
                            },
                        },
                    },
                }
            },
            computed: {
                currentPlanId: function() {
                    return false;
                },

                isCurrentPlanSelected: function() {
                    return this.isCurrentPlan(this.plan_id);
                }
            },
            methods: {
                getFormAction(route_type) {
                    var frequency = this.monthly ? 'monthly' : 'annually';
                    var level = this.pro_cart ? 'pro' : 'deluxe';
                    return this.routes[route_type][frequency][level];
                },

                isCurrentPlan(plan_id) {
                    if (this.currentPlanId == plan_id) {
                        return true;
                    }
                    return false;
                }
            },
            mounted() {
                if(this.isCurrentPlan(3)) {
                    $('#pro_monthly_billing').prop('checked',true);
                    this.plan_id = 3;
                }
                if(this.isCurrentPlan(13)) {
                    $('#pro_annual_billing').prop('checked',true);
                    this.plan_id = 13;
                }
                if(this.isCurrentPlan(4)) {
                    $('#deluxe_monthly_billing').prop('checked',true);
                    this.plan_id = 4;
                }
                if(this.isCurrentPlan(16)) {
                    $('#deluxe_annual_billing').prop('checked',true);
                    this.plan_id = 16;
                }
            },
        })

        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus',
                html: true,
            });
        });

    </script>

@endsection