@extends('layouts.app')
@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Accounts</h1>
</div>
@endif
@include('subscription._nav')
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
                    @if(empty($current_plan))
                    None, select a plan below to start sending!
                    @else
                        {{ $current_plan->name }} - ${{ $current_plan->price }} {{ $current_plan->frequency }}
                        <br />
                        <strong>Current Status: </strong>
                        @if( empty($main_sub->ends_at) )
                            <span class="label label-success">Active</span>
                        @else

                            @notusercanceled
                                <span class="label label-danger">Declined</span>
                            @else    
                                <span class="label label-danger">Canceled</span>
                            @endnotusercanceled

                        <br />
                        <small>
                        Expires: {{ $main_sub->ends_at->format('m/d/Y') }}
                        </small>
                        @endif
                        @if($main_sub->onTrial('main') )
                        <br />
                            <strong>On Trial: </strong><span class="label label-success">Yes</span>
                        <br />
                            <strong>Trial Ends: </strong> {{ $main_sub->trial_ends_at->format('m/d/Y') }}
                        @endif

                    @endif
                </p>
            </div>
        </div>      
        {{-- start pricing plan div --}} 
            <div class=" pl-0 pr-0">
                <div id="plans_app" class="row">
                    {{-- pro plan - if one website or less and level is pro or below, use this as best value  --}}
                    @if(count($websites) < 2 && strpos($current_plan->name ?? '', 'Deluxe') === false)
                    <div class="col-xl-6 best-plan pt-2 px-2 pb-1">
                        <h6 class="h6 text-uppercase text-center">Best Value</h6>
                        <div class="card mb-1">
                            <div class="card-block row">
                    @else
                    <div class="ordinary-plan col-xl-6 mt-3 mt-xl-0">
                        <div class="card border-0 border-xl border-secondary mb-1 h-100">
                            <div class="card-block row pt-5">
                    @endif

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
                                            <input checked v-on:change="pro_cart = true; monthly = true; plan_id = {{ $prices['monthly']['plans']['pro']['plan_id'] }}" type="radio" class="custom-control-input" id="pro_monthly_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="pro_monthly_billing"><strong>Monthly</strong></label>
                                        </div>
                                        <p class="pl-4 mb-1"><strong class="font-weight-bold">$19.95/month</strong></p>
                                        <small class="pl-4">Auto-renewing at $19.95 monthly</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio">
                                            <input v-on:change="pro_cart = true; monthly = false; plan_id = {{ $prices['annually']['plans']['pro']['plan_id'] }}" type="radio" class="custom-control-input" id="pro_annual_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="pro_annual_billing">
                                                <strong>Annual</strong>
                                                <span class="small text-uppercase text-danger" style="font-size: 10px;">best value</span>
                                            </label>
                                        </div>
                                        <p class="pl-4 mb-1"><del>$19.95</del><strong class="ml-1 font-weight-bold">$15.96/monthly</strong></p>
                                        <small class="pl-4">Auto-renewing at $191.52 annually</small>
                                    </div>
                                    @if(!isset($cc) || $cc == true)
                                        @if(empty($current_plan) || empty($active_sub) || $active_sub->onGracePeriod())
                                        <form v-bind:action="getFormAction('choose')" method="POST">
                                        {{  csrf_field() }}
                                            <button id="choose_pro" type="submit"
                                                class="btn btn-md btn-block btn-success"
                                                v-bind:disabled="isCurrentPlanSelected || !pro_cart">
                                                Choose
                                            </button>
                                        </form>
                                        @else
                                        <form v-bind:action="getFormAction('switch')" method="POST">
                                            {{  csrf_field() }}
                                            <button id="switch_pro" type="submit"
                                                class="btn btn-md btn-block btn-primary"
                                                v-bind:disabled="isCurrentPlanSelected || !pro_cart">
                                                Switch
                                            </button>
                                        </form>
                                        @endif
                                    @else
                                        <a :href="(pro_cart && monthly) ? '{{$pkgcds['pro']}}' : '{{$pkgcds['pro_annual']}}'" id="addtocart-pro" :class="[(pro_cart) ? '' : 'disabled']" class="btn btn-md btn-block btn-primary">Add to Cart</a>
                                    @endif

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
                                            <li>{{--<i class="fa fa-lock">--}}</i>Secure SSL (https://)</li>
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
                                <a class="btn btn-default btn-sm" href="{{ route('plans.table') }}">
                                    View More Billing Options
                                </a>
                            </div>                        
                        </div>
                    </div>
                    {{-- End Pro plan  --}}

                    {{-- Deluxe plan  --}}
                    @if(count($websites) > 1 or strpos($current_plan->name ?? '', 'Deluxe') !== false)
                    <div class="col-xl-6 best-plan pt-2 px-2 pb-1">
                        <h6 class="h6 text-uppercase text-center">Best Value</h6>
                        <div class="card mb-1">
                            <div class="card-block row">
                    @else
                    <div class="ordinary-plan col-xl-6 mt-3 mt-xl-0">
                        <div class="card border-0 border-xl border-secondary mb-1 h-100">
                            <div class="card-block row pt-5">
                    @endif
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
                                            <input v-on:change="pro_cart = false; monthly = true; plan_id = {{ $prices['monthly']['plans']['deluxe']['plan_id'] }}" type="radio" class="custom-control-input" id="deluxe_monthly_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="deluxe_monthly_billing"><strong>Monthly</strong></label>
                                        </div>
                                        <p class="pl-4 mb-1"><strong class="font-weight-bold">$39.95/month</strong></p>
                                        <small class="pl-4">Auto-renewing at $39.95 monthly</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio">
                                            <input v-on:change="pro_cart = false; monthly = false; plan_id = {{ $prices['annually']['plans']['deluxe']['plan_id'] }}" type="radio" class="custom-control-input" id="deluxe_annual_billing" name="billing_plan">
                                            <label class="custom-control-label h5 mb-1" for="deluxe_annual_billing">
                                                <strong>Annual</strong>
                                                <span class="small text-uppercase text-danger" style="font-size: 10px;">best value</span>
                                            </label>
                                        </div>
                                        <p class="pl-4 mb-1"><del>$39.95</del><strong class="ml-1 font-weight-bold">$31.96/monthly</strong></p>
                                        <small class="pl-4">Auto-renewing at $383.52 annually</small>
                                    </div>
                                    @if(!isset($cc) || $cc == true)
                                        @if(empty($current_plan) || empty($active_sub) || $active_sub->onGracePeriod())
                                        <form v-bind:action="getFormAction('choose')" method="POST">
                                            {{  csrf_field() }}
                                            <button id="choose_deluxe" type="submit"
                                                class="btn btn-md btn-block btn-success"
                                                v-bind:disabled="isCurrentPlanSelected || pro_cart">
                                                Choose
                                            </button>
                                        </form>
                                        @else
                                        <form v-bind:action="getFormAction('switch')" method="POST">
                                        {{  csrf_field() }}
                                            <button id="switch_deluxe" type="submit"
                                                class="btn btn-md btn-block btn-primary"
                                                v-bind:disabled="isCurrentPlanSelected || pro_cart">
                                                Switch
                                            </button>
                                        </form>
                                        @endif
                                    @else
                                        <a :href="(!pro_cart && monthly) ? '{{$pkgcds['deluxe']}}' : '{{$pkgcds['deluxe_annual']}}'" id="addtocart-deluxe" :class="[(!pro_cart) ? '' : 'disabled']" class="btn btn-md btn-block btn-primary">Add to Cart</a>
                                    @endif
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
                                <a class="btn btn-default btn-sm" href="{{ route('plans.table') }}">
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
                        'pro': '{{ route('plans.add', [ 'id' => $prices["monthly"]["plans"]["pro"]["plan_id"] ]) }}',
                        'deluxe': '{{ route('plans.add', [ 'id' => $prices["monthly"]["plans"]["deluxe"]["plan_id"] ]) }}',
                    },
                    'annually': {
                        'pro': '{{ route('plans.add', [ 'id' => $prices["annually"]["plans"]["pro"]["plan_id"] ]) }}',
                        'deluxe': '{{ route('plans.add', [ 'id' => $prices["annually"]["plans"]["deluxe"]["plan_id"] ]) }}',
                    },
                },
                'switch': {
                    'monthly': {
                        'pro': '{{ route('plans.swap', [ 'id' => $prices["monthly"]["plans"]["pro"]["plan_id"] ]) }}',
                        'deluxe': '{{ route('plans.swap', [ 'id' => $prices["monthly"]["plans"]["deluxe"]["plan_id"] ]) }}',
                    },
                    'annually': {
                        'pro': '{{ route('plans.swap', [ 'id' => $prices["annually"]["plans"]["pro"]["plan_id"] ]) }}',
                        'deluxe': '{{ route('plans.swap', [ 'id' => $prices["annually"]["plans"]["deluxe"]["plan_id"] ]) }}',
                    },
                },
            },
        }
    },
    computed: {
        currentPlanId: function() {
            return {{ !empty($active_sub) && !empty($current_plan) ? $current_plan->id : 'false' }};
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
        if(this.isCurrentPlan({{ $prices["monthly"]["plans"]["pro"]["plan_id"] }})) {
            $('#pro_monthly_billing').prop('checked',true);
            this.plan_id = {{ $prices["monthly"]["plans"]["pro"]["plan_id"] }};
        }
        if(this.isCurrentPlan({{ $prices["annually"]["plans"]["pro"]["plan_id"] }})) {
            $('#pro_annual_billing').prop('checked',true);
            this.plan_id = {{ $prices["annually"]["plans"]["pro"]["plan_id"] }};
        }
        if(this.isCurrentPlan({{ $prices["monthly"]["plans"]["deluxe"]["plan_id"] }})) {
            $('#deluxe_monthly_billing').prop('checked',true);
            this.plan_id = {{ $prices["monthly"]["plans"]["deluxe"]["plan_id"] }};
        }
        if(this.isCurrentPlan({{ $prices["annually"]["plans"]["deluxe"]["plan_id"] }})) {
            $('#deluxe_annual_billing').prop('checked',true);
            this.plan_id = {{ $prices["annually"]["plans"]["deluxe"]["plan_id"] }};
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