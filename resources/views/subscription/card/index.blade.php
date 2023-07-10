@extends('layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Accounts</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('teams.index') }}">Accounts</a></li>
    <li>{{ auth()->user()->currentTeam->hasCardOnFile() ? 'Update Card' : 'Add Card' }}</li>
</ol>
@include('subscription._nav')
<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">{{ auth()->user()->currentTeam->hasCardOnFile() ? 'Update Card' : 'Add Card' }}</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                        

                    </div>
                </div>
            </div>
            @if( auth()->user()->currentTeam->hasCardOnFile() && !empty( auth()->user()->currentTeam->defaultCard() )) 
            <div class="card-block">
                
                    <strong>Current Card:</strong> {{ auth()->user()->currentTeam->defaultCard()->brand }} 
                    ***********{{ auth()->user()->currentTeam->defaultCard()->last4 }} 
                    <strong>Expiring:</strong> {{ auth()->user()->currentTeam->defaultCard()->exp_month }}/{{ auth()->user()->currentTeam->defaultCard()->exp_year }}

                    @if($bad_debt == true)
                        <a href="{{ route('billing.retry') }}" class="btn btn-primary btn-sm pull-right">
                            <i class="fa fa-credit-card"></i>
                            Retry Card
                        </a>
                    @endif
                    <hr>
            </div>
            @endif
            <div class="card-block">

                    @if( auth()->user()->currentTeam->hasCardOnFile() )
                     <form action="{{ route('plans.card_update') }}" method="post" id="payment-form">
                        {{ method_field('PUT') }}
                    @else 
                     <form action="{{ route('teams.payments.store', auth()->user()->currentTeam) }}?redir=plans.index" method="post" id="payment-form">

                    @endif
                        {!! csrf_field() !!}
                        <div class="row form-group">
                            <label class="col-md-12 form-control-label">Credit or debit card</label>
                            <div class="col-md-12">
                                <div id="card-element" class="form-control">
                                    <!-- a Stripe Element will be inserted here. -->
                                </div>
                                <span class="help-block">
                                    <div id="card-errors" role="alert"></div>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit_btn"> {{ auth()->user()->currentTeam->hasCardOnFile() ? 'Update Card' : 'Add Card' }}</button>

                    </form>
                </form> 
                
            </div>
            

        </div>
    </div>
</div>

@endsection


@section('js')
    @include('layouts.partials._stripejs')
@endsection
