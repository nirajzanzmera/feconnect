@if(count($team->websites) > 0)
@if(! empty($user_chart))
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col"><h4 class="card-title">{{ $user_chart->display_name }}</h4></div>
            <div class="col text-right">
                <a class="btn btn-sm btn-secondary float-right" title="Website Analytics" href="{{ route('websites.analytics', ['website' => $website->id]) }}" id="chart_analytics_link">
                    <i class="fa fa-bar-chart"></i>
                </a>
            </div>
        </div>
    </div>
    <br />
    {!! $user_chart->container() !!}
</div>
@endif
@endif
