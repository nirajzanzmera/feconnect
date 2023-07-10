@extends('fe.layouts.app')

@section('content')
<div>
    <h1 class="page-heading">Analytics</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('lists.index') }}">Lists</a></li>
    <li class="active">{{ $list->name }}</li>
</ol>

@include('lists._nav')

<div class="row-fluid">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">Subscriber Status</h4>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="Subscriber Status" data-content="
This report is a breakdown of the current total list composition (including both active and unsubscribed emails). <br /><br />
<strong>Active</strong> - Subscribers eligible to receive emails. <br /><br />
<strong>Unsubscribed</strong> - the subscriber directly unsubscribed from receiving future emails.<br /><br />
<strong>Complaint</strong> - the subscriber complained that a message that you send previously was spam.  Once a subscriber does this they are automatically marked as a complaint and do not receive further messages.<br /><br />
<strong>Bounced</strong> - the subscriber’s email has “bounced” indicating that it has become or always has been a bad email or the user inbox is full.

                        ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br />
            {!! $subscriberStatus->container() !!}
        </div>
    </div>
    <div class="col-xl-6"> 
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">Subscribers</h4>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="Subscribers by time" data-content="Shows total active subscribers at end of day each day for recent time period. Excludes emails that are not eligible to send such as unsubscribes, complaints, and bounces.">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br />
            {!! $activeSubscribers->container() !!}
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="col-xl-6"> 
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">Recent Engagements by Domain</h4>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="Recent Engagements by Domain" data-content="Shows engagement counts by day by popular mail providers.
">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br />
            {!! $recentEngagements->container() !!}
        </div>
    </div>
    <div class="col-xl-6"> 
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">Engagement Breakdown</h4>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="Engagement Breakdown Report" data-content="
<strong>Added</strong> - Persons engaged in previous 12 months but not engaged prior. <br /><br />
<strong>Lost</strong> - Persons not engaged in previous 12 month, but engaged in 12 months prior. <br /><br />
<strong>Retained</strong> - Persons engaged in both previous 12 month, and 12 months prior. <br /><br />
<strong>Unengaged</strong> - Persons who did not engaged in past 24 months. <br /><br />
">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br />
            {!! $engagementBreakdown->container() !!}
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-xl-6"> 
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">Last Engagement</h4>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="Last Engagement Report" data-content="
This is a pie chart of all subscribers by the age of the last engagement.  The time periods indicate how many subscribers have engaged within that many days.  So 7 days means within 7 days, 30 days means within 30 days (but not 7), Ever means that the subscriber has not engaged in 1 year, but has engaged prior to that.  Never means that the subscriber has never engaged. Etc.
">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br />
            {!! $lastEngagement->container() !!}
        </div>
    </div>
    <div class="col-xl-6"> 
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">Recent 90 Days Engagement Breakdown</h4>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="Recent 90 Days Engagement Breakdown" data-content="
This is a pie chart indicating the number of subscribers who have clicked, opened (but didn’t click), or have not opened or clicked an email in the past 90 days.  Each active subscriber is counted once.
">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <br />
            {!! $recentEngagementStatus->container() !!}
        </div>
    </div>
</div>

	
@endsection

@section('js')
@include('layouts.partials._popover')
@include('layouts.partials._highcharts')

{!! $subscriberStatus->script() !!}
{!! $activeSubscribers->script() !!}

{{-- 
{!! $emailSentDomainBreakdown->script() !!}
{!! $engagementbyDomain->script() !!}
 --}}

{!! $recentEngagements->script() !!}
{!! $engagementBreakdown->script() !!}
{!! $lastEngagement->script() !!}
{!! $recentEngagementStatus->script() !!}
@endsection
