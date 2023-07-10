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
            <h1 class="page-heading">Reports - Email Blast - {{ $campaign->subject }}</h1>
        </div>

        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="active">Email Report</li>
        </ol>
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Email Info
                        </h4>
                    </div>
                    <div class="card-block">
                        <strong>Schedule:</strong> {{ date('m/d/Y H:i A', strtotime($campaign->schedule->date)) }} HST<br>
                        <strong>From :</strong>  <br>
                        <strong>To:</strong> default <br>
                        <strong>Subject:</strong> {{ $campaign->subject }} <br>
                        <strong>Status:</strong> <div class="label label-info">
                            {{ $campaign->status }}

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Preview
                        </h4>
                    </div>
                    <div class="card-block">
                        <a href="{{ route('campaigns.preview',['id',$campaign->id]) }}">
                            <img class="img-thumbnail" src="https://dataczar-public.s3.us-west-2.amazonaws.com/{{ $campaign->thumb }}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body media-middle">
                                <h2 class=" m-b-0">0</h2>
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
                                <h2 class=" m-b-0">0</h2>
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
                                <h2 class=" m-b-0">0</h2>
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
                                <h2 class=" m-b-0">0</h2>
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
                                <h2 class=" m-b-0">0.00%</h2>
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
                                <h2 class=" m-b-0">0.00%</h2>
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
                                <h2 class=" m-b-0">0.00%</h2>
                                <span class="text-muted">Unsub rate</span>
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
                                <h2 class=" m-b-0">0.00%</h2>
                                <span class="text-muted">Open to Click</span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-percent md-48 text-muted-light"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Links
                        </h4>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Url</th>
                            <th style="text-align: right;">Clicks</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            @if(! empty($user_chart))
                <div class="col-md-6">
                    <div class="card">
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



    @if(isset($user_chart))
        @include('fe.layouts._highcharts')
        {!! $user_chart->script() !!}
    @endif


@endsection
