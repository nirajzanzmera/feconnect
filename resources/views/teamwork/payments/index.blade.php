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
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Billing</h1>
</div>
@endif
@include('subscription._nav')

<div class="row-fluid">
    <div class="col-md-12">

        <div class="card card-default">
            <div class="card-header">
                Subscriptions
            </div>
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Start</th>
                        <th>Renewal Date</th>
                        <th>Trial End</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($account->subscription('main'))
                    <tr>
                        <td>{{ $account->subscription('main')->plan->name ?? 'Main' }}</td>
                        <td>
                            {{ $account->subscription('main')->asStripeSubscription()->coupon ?? ''}}
                            @if( !empty($account->subscription('main')->asStripeSubscription()->discount) )
                                <s>${{ $account->subscription('main')->plan->price ?? '' }}</s>
                                ${{ round(
                                    $account->subscription('main')->plan->price - (
                                        $account->subscription('main')->plan->price * ($account->subscription('main')->asStripeSubscription()->discount->coupon->percent_off / 100)
                                    ) ?? ''
                                , 2)
                             }} {{ $account->subscription('main')->plan->frequency ?? 'monthly' }}
                            @else
                                ${{ $account->subscription('main')->plan->price ?? '' }} {{ $account->subscription('main')->plan->frequency ?? 'monthly' }}
                            @endif

                        </td>
                        <td>{{ $account->subscription('main')->created_at->format('m/d/Y') }}</td>
                        <td>{{ empty($account->subscription('main')->renewal_time) ? '' : $account->subscription('main')->renewal_time->format('m/d/Y') }}</td>
                        <td>{{ $account->subscription('main')->onTrial() ? $account->subscription('main')->trial_ends_at->format('m/d/Y') : '' }}</td>
                        <td>{{ $account->subscription('main')->active() ? 'Active' : 'Canceled' }}</td>
                    </tr>
                    @endif

                    @if($domains->count())
                    <tr id="domains-header" class="header">
                        <td colspan="6">
                            <i id="domains-header-exp" class="fa fa-minus"></i>
                            <strong> Domains:</strong>
                            <span id="domains-header-price-summary"></span>
                        </td>
                    </tr>
                    @foreach ($domains as $domain)
                    <tr id="domain-detail-{{ $domain->id }}" class="domain-detail">
                        <td>
                            {{ $domain->domain }}
                        </td>
                        <td>
                            {{ empty($domain->currentSubscription()) ? 'FREE' : '$' . $domain->currentSubscription()->plan->price . ' / year' }}
                        </td>
                        <td>
                            {{ $domain->created_at->format('m/d/Y') }}
                        </td>
                        <td>
                            {{ empty($domain->currentSubscription()) && empty($domain->currentSubscription()->renewal_time) ? '' : $domain->currentSubscription()->renewal_time->format('m/d/Y') }}
                            {{ $domain->expiring == 1 ? 'Disabled' : '' }}
                        </td>
                        <td>
                            {{ !empty($domain->currentSubscription()) && $domain->currentSubscription()->ontrial() ? $domain->currentSubscription()->trial_ends_at->format('m/d/Y') : '' }}
                        </td>
                        <td>
                            {{( !empty($domain->currentSubscription()) && !$domain->currentSubscription()->cancelled()) || empty($domain->currentSubscription()) ? 'Active' : 'Canceled' }}
                        </td>
                    </tr>
                    @endforeach
                    @endif

                    @if($email_boxes->count())
                    <tr id="email_boxes-header" class="header">
                        <td colspan="6">
                            <i id="email_boxes-header-exp" class="fa fa-minus"></i>
                            <strong> Emails:</strong>
                            <span id="email_boxes-header-price-summary"></span>
                        </td>
                    </tr>
                    @foreach ($email_boxes as $email_box)
                    <tr id="email_box-detail-{{ $email_box->id }}" class="email_box-detail">
                        <td>
                            {{ $email_box->email }}
                        </td>
                        <td>
                            {{ empty($email_box->price) ? 'FREE' : '$' . $email_box->price . ' / month' }}
                        </td>
                        <td>
                            {{ $email_box->created_at->format('m/d/Y') }}
                        </td>
                        <td>
                            {{ empty($cursub = $email_box->currentSubscription()) || empty($renewal_time = $cursub->renewal_time) ? '' : $renewal_time->format('m/d/Y') }}
                            {{ $email_box->expiring == 1 ? 'Disabled' : '' }}
                        </td>
                        <td>
                            {{ !empty($email_box->currentSubscription()) && $email_box->currentSubscription()->ontrial() ? $email_box->currentSubscription()->trial_ends_at->format('m/d/Y') : '' }}
                        </td>
                        <td>
                            {{( !empty($email_box->currentSubscription()) && !$email_box->currentSubscription()->cancelled()) || empty($email_box->currentSubscription()) ? 'Active' : 'Canceled' }}
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>


        <div class="card card-default">
            <div class="card-header">
                Invoices
            </div>

            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Invoice Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    @if($invoice->total > 0)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::createFromTimestampUTC($invoice->date)->format('m/d/Y') ?? '' }}
                        </td>
                        <td>
                            {{-- @foreach($invoice->subscriptions() as $sub)
                            {{ $sub->plan->nickname }}
                            @endforeach --}}
                            @foreach($invoice->lines->data as $line)
                            {{ $line->description }} <br />
                            @endforeach
                        </td>
                        <td>${{ $invoice->total / 100 }}</td>
                        <td>
                            <span class="label 
                                    {{ ($invoice->status == 'paid') ? 'label-success': '' }}
                                    {{ ($invoice->status == 'open') ? 'label-danger': '' }}
                                    {{ ($invoice->status == 'refunded' || $invoice->status == 'uncollectible') ? 'label-info': '' }}
                                ">
                                {{ ucwords($invoice->status) }}
                            </span>
                        </td>
                        <td>
                            {{-- <a href="{{ $invoice->hosted_invoice_url }}" target="_blank" class="btn
                            btn-default">View Invoice</a> --}}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td colspan="3" align="right">
                            Total Due: ${{ number_format($due, 2) }}
                        </td>
                    </tr>
                </tfoot> --}}
            </table>

        </div>
    </div>
</div>
@endsection

@section('js2')
<script type="text/javascript">
    function toggleDomainDetail(){
        $('#domains-header-exp').toggleClass("fa-minus fa-plus");
        $('#domains-header-price-summary').text(function(_, value) {
            return value == ''
            ? " {{ $domains->count().' - $'.number_format($domains->sum(function ($domain) { return $domain->currentSubscription()->plan->price ?? 0; }),2) }} / year"
            : '';
        });
        $('.domain-detail').toggle();
    };

    function toggleEmailBoxesDetail(){
        $('#email_boxes-header-exp').toggleClass("fa-minus fa-plus");
        $('#email_boxes-header-price-summary').text(function(_, value) {
            return value == ''
            ? " {{ $email_boxes->count().' - $'.number_format($email_boxes->sum(function ($email_box) { return $email_box->price ?? 0; }),2) }} / month"
            : '';
        });
        $('.email_box-detail').toggle();
    };

    $(document).ready(function() {
        @if($domains->count() > 5)
        toggleDomainDetail();
        @endif
        @if($email_boxes->count() > 5)
        toggleEmailBoxesDetail();
        @endif
        $('#domains-header').click(toggleDomainDetail);
        $('#email_boxes-header').click(toggleEmailBoxesDetail);
    });
</script>
@endsection