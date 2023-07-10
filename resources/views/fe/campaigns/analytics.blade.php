@extends('fe.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">
    <link type="text/css" href="https://connect.dataczar.com/assets/css/style.min.css" rel="stylesheet">
    <link type="text/css" href="https://connect.dataczar.com/assets/css/print.css" rel="stylesheet">
    <link type="text/css" href="https://connect.dataczar.com/assets/css/tiny.css" rel="stylesheet">
    <style>
        label {
            font-weight: bold;
        }
    </style>

@endsection

@section('content')

    <div>
        <h1 class="page-heading">Reports - Email Blasts</h1>
    </div>

    @include('campaigns._nav')

    @if($errors->count() > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body">
                            <strong class="text-muted">Date Range</strong>
                            <p class="h2 m-b-0">
                                <strong>
                                    <a id="daterange">
                                        <span>{{ $start }} - {{ $end }}</span>
                                        <i class="material-icons md-48 text-muted-light">date_range</i>
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                </strong>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->send }}</h2>
                            <span class="text-muted">Sends</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="material-icons md-48 text-muted-light">mail</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->open }}</h2>
                            <span class="text-muted">Opens</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="material-icons md-48 text-muted-light">pageview</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->link }}</h2>
                            <span class="text-muted">Clicks</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="material-icons md-48 text-muted-light">mouse</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->unsub }}</h2>
                            <span class="text-muted">Unsubscribes</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="material-icons md-48 text-muted-light">cancel</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->s2o }}</h2>
                            <span class="text-muted">Open Rate</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="fa fa-percent md-48 text-muted-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->s2c }}</h2>
                            <span class="text-muted">Click Rate</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="fa fa-percent md-48 text-muted-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->s2u }}</h2>
                            <span class="text-muted">Unsubscribe rate</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="fa fa-percent md-48 text-muted-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body media-middle">
                            <h2 class=" m-b-0">{{ $summary->o2c }}</h2>
                            <span class="text-muted">Open to Click</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="fa fa-percent md-48 text-muted-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(! empty($user_chart2))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ $user_chart2->display_name }}
                    </div>
                    <br />
                    {!! $user_chart2->container() !!}
                </div>
            </div>
        @endif

        @if(! empty($user_chart))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                           {{ $user_chart->display_name }}
                    </div>
                    <br />
                    {!! $user_chart->container() !!}
                </div>
            </div>
        @endif




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
