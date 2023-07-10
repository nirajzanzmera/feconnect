@extends('layouts.app')

@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Websites - Shopping Cart</h1>
</div>
@endif
@include('websites._nav_sc')

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row-fluid" id="shopping_cart_website_plan">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">Shopping Cart - Settings</h4>
                    </div>

                </div>
            </div>
            <div class="card-block">

                @if(empty($store_id))
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('shopping_cart.create',$website['id'] ?? '') }}" method="POST"
                                id="shopping_cart_create">
                                {{ csrf_field() }}

                                <fieldset class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="user_name" class="col-md-4 form-control-label"
                                        style="text-align:right">Name</label>
                                    <div class="col-md-8">
                                        <input id="user_name" class='form-control' name="user_name" type="text"
                                            value="{{ old('user_name', !empty($website->name) ? $website->name : NULL ) }}" />
                                    </div>
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                                <fieldset class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="user_email" class="col-md-4 form-control-label"
                                        style="text-align:right">Email</label>
                                    <div class="col-md-8">
                                        <input id="user_email" class='form-control' name="user_email" type="email"
                                            value="{{ old('user_email', !empty($scart->email) ? $scart->email : NULL ) }}" />
                                    </div>
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                                <fieldset class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="user_password" class="col-md-4 form-control-label"
                                        style="text-align:right">Password</label>
                                    <div class="col-md-8">
                                        <input id="user_password" type="password" class='form-control'
                                            name="user_password" />
                                    </div>
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>

                                <div class="row form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button class="btn btn-success" type="submit" id="submit_btn">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="card-block">

                    <div class="row">
                        @if(!empty($ssolink))
                        <a class="btn btn-sm btn-info" href="{{$ssolink}}" target="_blank"><i
                                class="fa fa-shopping-cart"> Shopping Cart Control Panel</i></a>
                        @endif
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4 col-md-3">
                            <p><strong>Store URL: </strong></p>
                        </div>
                        <div class="col-sm-6 col-md-8">
                            <span><a href="{{$previewurl}}" target="_blank">{{$previewurl}}</a></span>
                            <a class="btn btn-default border border-secondary btn-sm copy pull-right" href="#"
                                data-link="{{$previewurl}}">copy link</a>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-4 col-md-3">
                            <strong>Current plan:</strong>
                        </div>
                        <div class="col-sm-6 col-md-8">
                            <span class="pl-1">{{ $store_data->{'result'}{'account-type'}{'oldPlanName'} ?? 'unknown'
                                }}</span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4 col-md-3">
                            <label for="plan_options"><strong>Plan Options:</strong></label>
                        </div>
                        <div class="col-sm-6 col-md-8">
                            <select class="custom-select" v-on:change="getValue($event)" name="" id="plan_options">
                                <option selected>Select one</option>
                                <option value="DATACZAR_FREEDEMO">5 Products, $0/mo</option>
                                <option value="DATACZAR_VENTURE_GOLD">100 Products, $15/mo</option>
                                <option value="DATACZAR_BUSINESS_GOLD">2500 Products, $35/mo</option>
                                <option value="DATACZAR_UNLIMITED_GOLD">Unlimited, $99/mo</option>
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <em>
                            <strong> Note:</strong> Your plan level will not be changed until you click Activate.
                        </em>
                    </div>

                    <div class="card-block ">
                        <button type="button" name="" id="" class="btn btn-success btn-md">Activate <span
                                class="ml-2">@{{selected_plan}} </span></button>
                        {{--<button type="button" name="" id="" class="btn btn-info btn-md">Update</button>--}}
                        @if( isset($storeactive) && $storeactive == false )
                        <button type="button" name="" id="" class="btn btn-primary btn-md"><i class="fa fa-play"></i>
                            Resume</button>
                        @elseif ( $store_id )
                        <button type="button" name="" id="" class="btn btn-primary btn-md"><i class="fa fa-pause"></i>
                            Pause</button>
                        <a class="btn btn-xs q-mark pull-right" tabindex="0" data-toggle="popover" data-placement="left"
                            data-content="
                                        <p>
                                            Pausing your store will temporarily make your store not public and will pause future billing. <br/>
                                            Once paused, you can resume your store again by clicking Resume.
                                        </p>
                                        ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                @isAdmin
                <strong>Admin Only debug</strong>
                <pre>Website info: {{ json_encode($website,JSON_PRETTY_PRINT) }} <br />
                    Input Store_id: {{ $store_id }}<br />
                    New Store_id: {{ $newstoreid }}<br />
                    Output: {{ $output }}<br />
                    Store Profile: {{ json_encode($store_profile,JSON_PRETTY_PRINT) }}
                    Access Token: {{ $accesstoken }} - {{json_encode($access_result ??'',JSON_PRETTY_PRINT)}}
                </pre>
                @endisAdmin
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>

<script>
    var app = new Vue({
    el: '#shopping_cart_website_plan',
    data () {
        return {
            'onUpdate': false,
            'website_name': 'Test Website',
            'selected_plan': '',
            'plans': [
                {
                    id: 'DATACZAR_FREEDEMO',
                    name: '5 Products, $0/mo',
                    amount: '$0',
                },
                {
                    id: 'DATACZAR_VENTURE_GOLD',
                    name: '100 Products, $15/mo',
                    amount: '$15',
                },
                {
                    id: 'DATACZAR_BUSINESS_GOLD',
                    name: '2500 Products, $35/mo',
                    amount: '$35',
                },
                {
                    id: 'DATACZAR_UNLIMITED_GOLD',
                    name: 'Unlimited, $99/mo',
                    amount: '$99',
                }
            ],  
        }
    },
    methods: {
        getValue(event) {
            let id = event.target.value;
            this.plans.forEach(plan => {
                if (plan.id == id) {
                    this.selected_plan = plan.amount;
                }
            });
        }
    },
    mounted() {

    },
});
</script>

<script type="text/javascript">
    $(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        trigger: 'focus', 
        html: true,
    });
    $('.copy').on('click', function(e) {
            e.preventDefault();
            var link = $(this).data('link');
            clipboard.writeText(link);
            alert('Copied to Clipboard');
        });

});

</script>


@endsection