@extends('layouts.app')

@section('css')
	<style type="text/css">
	/**
	* The CSS shown here will not be introduced in the Quickstart guide, but shows
	* how you can use CSS to style your Element's container.
	*/
	.StripeElement {
		background-color: white;
		padding: 8px 12px;
		border-radius: 4px;
		border: 1px solid transparent;
		box-shadow: 0 1px 3px 0 #e6ebf1;
		-webkit-transition: box-shadow 150ms ease;
		transition: box-shadow 150ms ease;
	}

	.StripeElement--focus {
		box-shadow: 0 1px 3px 0 #cfd7df;
	}

	.StripeElement--invalid {
		border-color: #fa755a;
	}

	.StripeElement--webkit-autofill {
		background-color: #fefde5 !important;
	}
	</style>
@endsection

@section('content')

<div>
	<a href="{{route('teams.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
		<i class="fa fa-arrow-left"></i> Back
	</a>
	<h1 class="page-heading">Accounts</h1>
</div>

<div class="row-fluid">
	<div class="col-md-6 col-md-offset-3">
		<div class="card card-primary">
		    <div class="card-block">
					<legend>
						Update Payment Method 
					</legend>
					
					<form action="{{ route('teams.payments.update', $account) }}" method="post" id="payment-form">
						{!! csrf_field() !!}
						{{ method_field('PUT') }}
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
						<button type="submit" class="btn btn-success">Update Card</button>
					</form>

			</div>
		</div>
		
	</div>
</div>

@endsection

@section('js')
    @include('layouts.partials._stripejs')
@endsection
