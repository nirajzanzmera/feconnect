@extends('layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Accounts</h1>
</div>
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
                            <span class="label label-danger">Canceled</span>
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
                    @media only screen and (max-width: 992px) {
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
                <div class="input-group " >
                    <label class="form-control-label" for="billing_option_select"><strong>Billing Option:</strong></label>
                    <select class="form-control" onchange="function_billing_frequency(value);" id="billing_option_select">
                        <?php $a = 1; ?>
                        @foreach ($prices as $price)
                            <option value="{{$price['value']}}" {{ ($a == 0) ? 'selected' : ''}}>
                                {{$price['name']}}
                            </option>
                        <?php $a++; ?>
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

                        {{-- plan pricing  --}}
                        @if ( !empty($prices) && is_array($prices))
                        @php $i = 0; @endphp                          
                        @foreach ($prices as $price) 
                        <tr id='bill-option-{{$price['value']}}'  class="{{ ($i > 0) ? 'hide' : '' }}">
                            <td>{{$price['name']}}</td>

                            {{-- Basic plan  --}}
                            <td>
                                @if( !empty($price['plans']['basic']['reg_price']) )
                                    @if( !empty($price['plans']['basic']['mo_cost']) )<del>@endif
                                    {{$price['plans']['basic']['reg_price']}}
                                    @if( !empty($price['plans']['basic']['mo_cost']) )</del> @endif  <br>
                                @endif
                                @if( !empty($price['plans']['basic']['mo_cost']) )
                                    {{$price['plans']['basic']['mo_cost']}}<br>
                                @endif
                                @if( !empty($price['plans']['basic']['bill_rate']) )
                                    <div class="font-italic">{{$price['plans']['basic']['bill_rate']}}</div>
                                @endif
                                @if(!isset($cc) || $cc == true)
                                    @if(empty($current_plan) || empty($active_sub) || $active_sub->onGracePeriod())
                                        <form action="{{ route('plans.add', ['id'=> $price['plans']['basic']['plan_id'] ]) }}" method="POST">
                                            {{  csrf_field() }}
                                            <button id="choose_basic-{{$price['value']}}" type="submit"
                                                class="btn btn-sm btn-success {{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == $price['plans']['basic']['plan_id']) ? ' disabled' : ''}}">
                                                Choose
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('plans.swap', ['plan'=> $price['plans']['basic']['plan_id'] ]) }}" method="POST">
                                            {{  csrf_field() }}
                                            <button id="switch_basic-{{$price['value']}}" type="submit"
                                                class="btn btn-sm btn-primary{{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == $price['plans']['basic']['plan_id'] ) ? ' disabled' : ''}}">
                                                Switch
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ $price['plans']['basic']['buyurl'] }}" id="addtocart-basic-{{$price['value']}}" class="btn btn-sm btn-primary">Add to Cart</a>
                                @endif
                            </td>
                            {{-- End Basic plan  --}}

                            {{-- Pro plan  --}}
                            <td>
                                @if( !empty($price['plans']['pro']['reg_price']) )
                                    @if( !empty($price['plans']['pro']['mo_cost']) )<del>@endif
                                    {{$price['plans']['pro']['reg_price']}}
                                    @if( !empty($price['plans']['pro']['mo_cost']) )</del> @endif <br>
                                @endif
                                @if( !empty($price['plans']['pro']['mo_cost']) )
                                    {{$price['plans']['pro']['mo_cost']}}<br>
                                @endif
                                @if( !empty($price['plans']['pro']['bill_rate']) )
                                    <div class="font-italic">{{$price['plans']['pro']['bill_rate']}}</div>
                                @endif
                                @if(!isset($cc) || $cc == true)
                                    @if(empty($current_plan) || empty($active_sub) || $active_sub->onGracePeriod())
                                    <form action="{{ route('plans.add', ['id'=> $price['plans']['pro']['plan_id'] ]) }}" method="POST">
                                        {{  csrf_field() }}
                                        <button id="choose_pro-{{$price['value']}}" type="submit"
                                            class="btn btn-sm btn-success {{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == $price['plans']['pro']['plan_id']) ? ' disabled' : ''}}">
                                            Choose
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('plans.swap', ['id'=> $price['plans']['pro']['plan_id'] ]) }}" method="POST">
                                        {{  csrf_field() }}
                                        <button id="switch_pro-{{$price['value']}}" type="submit"
                                            class="btn btn-sm btn-primary{{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == $price['plans']['pro']['plan_id'] ) ? ' disabled' : ''}}">
                                            Switch
                                        </button>
                                    </form>
                                    @endif
                                    @else
                                    <a href="{{ $price['plans']['pro']['buyurl'] }}" id="addtocart-pro-{{$price['value']}}" class="btn btn-sm btn-primary">Add to Cart</a>
                                @endif

                            </td>
                            {{-- End Pro plan  --}}

                            {{-- Deluxe plan  --}}
                            <td>
                                @if( !empty($price['plans']['deluxe']['reg_price']) )
                                    @if( !empty($price['plans']['deluxe']['mo_cost']) )<del>@endif
                                        {{$price['plans']['deluxe']['reg_price']}}
                                    @if( !empty($price['plans']['deluxe']['mo_cost']) )</del> @endif <br>
                                @endif
                                @if( !empty($price['plans']['deluxe']['mo_cost']) )
                                    {{$price['plans']['deluxe']['mo_cost']}}<br>
                                @endif
                                @if( !empty($price['plans']['deluxe']['bill_rate']) )
                                    <div class="font-italic">{{$price['plans']['deluxe']['bill_rate']}}</div>
                                @endif
                                @if(!isset($cc) || $cc == true)
                                    @if(empty($current_plan) || empty($active_sub) || $active_sub->onGracePeriod())
                                    <form action="{{ route('plans.add', ['id'=> $price['plans']['deluxe']['plan_id'] ]) }}" method="POST">
                                        {{  csrf_field() }}
                                        <button id="choose_deluxe-{{$price['value']}}" type="submit"
                                            class="btn btn-sm btn-success {{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == $price['plans']['deluxe']['plan_id']) ? ' disabled' : ''}}">
                                            Choose
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('plans.swap', ['id'=> $price['plans']['deluxe']['plan_id'] ]) }}" method="POST">
                                        {{  csrf_field() }}
                                        <button id="switch_deluxe-{{$price['value']}}" type="submit"
                                            class="btn btn-sm btn-primary{{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == $price['plans']['deluxe']['plan_id'] ) ? ' disabled' : ''}}">
                                            Switch
                                        </button>
                                    </form>
                                    @endif
                                    @else
                                    <a href="{{ $price['plans']['deluxe']['buyurl'] }}" id="addtocart-deluxe-{{$price['value']}}" class="btn btn-sm btn-primary">Add to Cart</a>
                                @endif

                            </td>
                            {{-- End Deluxe plan  --}}

                        </tr>
                        @php $i++; @endphp
                        @endforeach
                        @endif

                        {{-- plans details  --}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
      trigger: 'focus', 
      html: true,
    });
});

function function_billing_frequency($i) {
    var liHide = document.querySelectorAll("[id^=bill-option-]");
    for(var i=0; i<liHide.length; i++){
        // do someghing with liHide[i] like:
        if(liHide[i].id=="bill-option-"+$i){
            //liHide[i].style.visibility = "visible";
            liHide[i].classList.remove('hide');
        }
        else {
            //liHide[i].style.visibility = "hidden";
            liHide[i].classList.add('hide');

        }
    }

    //document.getElementById('bill-option-'+$i).style.visibility = 'visible';
    //alert("bill-option-"+$i);
}


</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

        $('#switch_free').on('click', function(e){
            e.preventDefault();

        swal({
            title: "Are you sure?",
            text: "Are you sure you want to lose access to {{ auth()->user()->currentTeam->domain ?? 'your custom domain name' }}?",
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
