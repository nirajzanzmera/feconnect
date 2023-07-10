@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<style>
    .daterangepicker {
        left: 20px!important;
    }
</style>

@endsection

@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Website - Analytics</h1>
</div>
@endif
@include('websites._nav')
@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="media">
                    <div class="media-body">
                        <strong class="text-muted">Date Range</strong>
                        <p class="h2 m-b-0">
                            <strong>
                                <a id="daterange">
                                    <span></span>
                                    <i class="material-icons md-48 text-muted-light">date_range</i>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                            </strong>
                        </p>
                    </div>
                    {{--
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="Date Range" data-content="
                        <ul>
                            <li>Start Date must be on or after Page creation date</li>
                        </ul>">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                    --}}
                </div>
            </div>
        </div>
    </div>
</div>
@if (!$user_chart->empty)
<div class="row">
    @foreach ($stats as $label => $data)
    @if (!empty($data['count']))
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-block">
                <div class="media">
                    <div class="media-body media-middle">
                        <h2 class=" m-b-0">{{ $data['count'] }}</h2>
                        <span class="text-muted">{{ $label }}</span>
                    </div>
                    @if (!empty($data['icon']))
                    <div class="media-right media-middle">
                        <i class="material-icons md-48 text-muted-light pull-right {{ $data['icon-class'] ?? '' }}">{{ $data['icon'] }}</i>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
<div class="card-columns">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Views</h4>
        </div>
        <br /> {!! $user_chart->container() !!}
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Average Session Length</h4>
        </div>
        <br /> {!! $session_chart->container() !!}
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Acquisition - Top Channels</h4>
        </div>
        <br /> {!! $referer_chart->container() !!}
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Top Devices</h4>
        </div>
        <br /> {!! $device_chart->container() !!}
    </div>

</div>
@endif
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ count($behavior) == 1 ? key($behavior) : '' }} Top Pages</h4>
    </div>
    <div class="card-block">
        @foreach ($behavior as $name => $site) 
            @if(count($behavior) > 1)
                <label><strong>{{$name}}</strong></label>
            @endif
            <ul class="list-group">
                <li class="list-group-item row hidden-lg-down">
                    <div class="col-lg-7"><strong>Page</strong></div>
                    <div class="col-lg-2"><strong>Views</strong></div>
                    <div class="col-lg-2"><strong>Visitors</strong></div>
                    <div class="col-lg-1">
                        <a class="btn btn-sm btn-secondary" title="Website Analytics" href="{{ route('websites.analytics', ['website' => $website]) }}">
                            <i class="fa fa-bar-chart"></i>
                        </a>
                    </div>

                </li>
                @foreach ($site as $page)
                    <li class="list-group-item row ">
                        <div class="col-lg-7 ">
                            <label class="hidden-xl-up"><strong>Page: </strong></label>
                            {{ $page['page'] }}
                        </div>
                        <div class="col-lg-2 ">
                            <label class="hidden-xl-up"><strong>Views: </strong></label>
                            {{ $page['views'] }}
                        </div>
                        <div class="col-lg-2 ">
                            <label class="hidden-xl-up"><strong>Visitors: </strong></label>
                            {{ $page['users'] }}
                        </div>
                        <div class="col-lg-1">
                            @if (!empty($page['post_id']) || !empty($page['page_id']))
                                @if (!empty($page['post_id']))
                                <a class="btn btn-sm btn-secondary" title="Post Analytics" href="{{ route('post.analytics', ['post' => $page['post_id']]) }}">
                                @elseif (!empty($page['page_id']))
                                <a class="btn btn-sm btn-secondary" title="Page Analytics" href="{{ route('page.analytics', ['page' => $page['page_id']]) }}">
                                @endif
                                <i class="fa fa-bar-chart"></i>
                                </a>
                            @endif

                        </div>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/bootstrap-daterangepicker-plus@2.1.25/daterangepicker.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.loading').click(function(e) {
            $(this).html('<i class="fa fa-spinner fa-pulse"></i> loading...');
            $(this).addClass('disabled');
        });

        $('.news-delete').on('click', function() {
            var url = $(this).data('url');
            var id = $(this).data('id');
            swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to DELETE this Website?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'DELETE'],
                })
                .then(willDelete => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'PATCH',
                            success: function(result) {
                                $('#news_' + id).remove();
                            }
                        });
                    }
                });
        });
        $('[data-toggle="popover"]').popover({
        trigger: 'focus', 
        html: true,
        });
        
        $(".daterangepicker ").appendTo(".layout-content");
    });
    $('#daterange').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },

            "startDate": '{{ $start }}',
            "endDate": '{{ $end }}',
            "minDate": moment().subtract(1, 'years'),
            "maxDate": moment(),
            "opens": 'right',
            "alwaysShowCalendars": true,

            "ranges": {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        }, cb)
        .on('click', function(e) {
            e.preventDefault();
        });
    $('#daterange span').html('{{ $start->format("M d") }} - {{ $end->format("M d") }}');

    function cb(start, end) {
        window.location = '{{ route("websites.analytics", $website) }}?sd=' + start.format('YYYY-MM-DD') + '&ed=' + end.format('YYYY-MM-DD');
    }
</script>

@if (!empty($user_chart))
@include('layouts.partials._highcharts')
{!! $user_chart->script() !!}
{!! $session_chart->script() !!}
{!! $referer_chart->script() !!}
{!! $device_chart->script() !!}
@endif
@endsection