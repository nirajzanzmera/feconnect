@extends('fe.layouts.app')
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    label {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div>
    <div class="btn-group pull-right" role="group" style="margin-top: 22px;">
        <a id="btn_campaigns_create" class="btn btn-success btn-sm" href="{{ route('campaigns.create') }}">
            <i class="fa fa-plus"></i> Create Blank Email
        </a>
        <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-default  dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bars"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <!-- "New Blank Email...", -->
                <a href="{{ route('campaigns.create') }}" class="dropdown-item" title="Create">
                    <i class="fa fa-envelope"></i> Create Blank Email
                </a>
                <!-- "New Email from Template...",  -->
                <!-- "New Blank Email...", -->
                <a href="{{ route('emails.templates.index') }}" class="dropdown-item" title="Create">
                    <i class="fa fa-envelope"></i> Create Email from Template
                </a>
                <!-- "New Newsletter from Feed...". -->
                <a href="{{ route('newsletters.index') }}" class="dropdown-item" title="Create">
                    <i class="fa fa-envelope"></i> Create Newsletter from Feed
                </a>
            </div>
        </div>
    </div>
    <h1 class="page-heading">
        Email Dashboard
        @if(count($teams) > 1)
         - {{ $team->name }}    
        @endif
    </h1>
</div>
{{-- <ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
<li class="active">Email Blasts</li>
</ol> --}}
@include('campaigns._nav')
@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="card-columns">


        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Quick Links {{--$quicklinks['quicklink_cnt']--}}
                    </h4>
                </div>
                <div class="list-group">

                        <a class="list-group-item" id="" href="{{ route('campaigns.create') }}">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-plus"></i>
                                </div>
                                <div class="media-body media-middle">
                                    Add an email
                                </div>
                                <div class="media-right">
                                    <i class="fa fa-chevron-right"></i>
                                </div>
                            </div>
                        </a>

                    <a class="list-group-item" id="" href="{{ route('newsletters.create') }}">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="media-body media-middle">
                                Create a newsletter
                            </div>
                            <div class="media-right">
                                <i class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                    <a class="list-group-item" id="" href="{{ route('reports.overview') }}">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="media-body media-middle">
                                View Report
                            </div>
                            <div class="media-right">
                                <i class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title row">

                <div class="col-6 col-sm-4 col-md-5 px-0 px-xl-2">
                    Recent Emails
                </div>
                <div class="col-6 col-sm-8 col-md-7 pr-0">
                    <a class="btn btn-sm btn-secondary pull-right hidden-xs" title="Add Post" href="{{ route('campaigns.create') }}">
                        <i class="fa fa-plus"></i>
                        Quick Add Email
                    </a>
                </div>
            </h4>

        </div>

        <ul id="posts" class="list-group" style="margin: 0;margin-top: 0;padding: 0;">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="spinner-border"></div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    @if(! empty($user_chart2))


            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col"><h4 class="card-title">Reports</h4></div>
                        <div class="col text-right">
                            <a class="btn btn-sm btn-secondary float-right" title="Email Analytics" href="{{ route('reports.overview') }}"
                               id="chart_analytics_link">
                               <i class="fa fa-bar-chart"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <br />
                {!! $user_chart2->container() !!}
            </div>

    @endif


    </div>
</div>

@endsection

@section('js')
    <script src="https://connect.dataczar.com/assets/vendor/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://connect.dataczar.com/assets/vendor/tether.min.js"></script>
    <script src="https://connect.dataczar.com/assets/vendor/bootstrap.min.js"></script>
    <!-- AdminPlus -->
    <script src="https://connect.dataczar.com/assets/vendor/adminplus.js"></script>
    <!-- App JS -->
    <script src="https://connect.dataczar.com/assets/js/main.min.js"></script>
    <!-- Theme Colors -->
    <script src="https://connect.dataczar.com/assets/js/colors.js"></script>

    <script src="https://connect.dataczar.com/assets/js/jquery-ui.js"></script>
    <script src="https://connect.dataczar.com/assets/js/bootstrap-datetimepicker.js"></script>

    <!-- Start of dataczar Zendesk Widget script -->


    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-daterangepicker-plus@2.1.25/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#updateReport').on('click', function(){
                var start = $('#startDate').val();
                var end = $('#endDate').val();
                window.location = '{{ url('emails/analytics') }}/emails/analytics/?start='+start+'&end='+end;
            });
            $('#today').on('click', function(){
                var start = '{{ $today }}';
                var end = '{{ $today }}';
                window.location = '{{ url('emails/analytics') }}/emails/analytics/?start='+start+'&end='+end;
            });
            $('#seven').on('click', function(){
                var start = '{{ $seven }}';
                var end = '{{ date('Y-m-d', strtotime($seven. ' + 7 days')) }}';
                window.location = '{{ url('emails/analytics') }}/emails/analytics/?start='+start+'&end='+end;
            });
            $('#thirty').on('click', function(){
                var start = '{{ $thirty }}';
                var end = '{{ date('Y-m-d', strtotime($seven. ' + '.$range.' days')); }}';
                window.location = '{{ url('emails/analytics') }}/emails/analytics/?start='+start+'&end='+end;
            });

            $('#daterange').daterangepicker({
                        locale: {
                            format: 'YYYY-MM-DD'
                        },
                        "startDate": '{{ $start }}'+ ' 00:00:00',
                        "endDate": '{{ $end }}'+ ' 00:00:00',

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
        });
        $('#daterange span').html('{{ $start }} - {{ $end }}');

        function cb(start, end) {
            window.location = '{{ url('emails/analytics') }}?start='+start.format('YYYY-MM-DD') +'&end='+end.format('YYYY-MM-DD');
        }

        $.ajax(
                {url: "{{ route('email.data') }}",
                    success: function(result)
                    {
                        var data = "";
                        var tot = 1;
                        result.forEach(function(val, index) {

                            var url = '{{ url('emails/:campaign/edit') }}';
                            url = url.replace(':campaign', encodeURIComponent(val['id']));

                            var description;

                            if(Object.is(val['description'], null)) {
                                description = '';
                            }
                            else{
                                var description = val['description'];
                            }

                            if(tot<=3){
                                data +='<li class="list-group-item">'+
                                        '<div class="row">'+
                                        '<div class="col-lg-10">'+
                                        '<h4>'+
                                        '<a href="'+url+'">'+val['subject']+
                                        '</a>'+
                                        '</h4>'+
                                        '<p class=""><small>'+ description +'</small></p>'+
                                        '<p class="mb-0"><small><i>Posted '+val['created_at']+'</i></small></p>'+
                                        '</div>'+

                                        '<div class="col-lg-2">'+
                                        '<div class="btn-group pull-right">'+
                                        '<a href="'+url+'" title="Edit" class="btn btn-sm btn-primary ">'+
                                        '<i class="fa fa-angle-right"></i>'+
                                        '</a>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>'+
                                        '</li>';
                            }

                            tot++;
                        });

                        data +='<li class="list-group-item center">'+
                            '<a type="submit" href="{{ route('campaigns.create') }}" class="btn btn-default" title="See More">See More'+
                            '</a>'+
                        '</li>';

                        $("#posts").html(data);
                    }}
        );

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus',
                html: true,
            });

            // Major fix for mobile compatibility
            $(".daterangepicker ").appendTo(".layout-content");
        });
    </script>


    @if(isset($user_chart))
        @include('fe.layouts._highcharts')
        {!! $user_chart->script() !!}
    @endif

    @if(isset($user_chart2))
        @include('fe.layouts._highcharts')
        {!! $user_chart2->script() !!}
    @endif
@endsection
