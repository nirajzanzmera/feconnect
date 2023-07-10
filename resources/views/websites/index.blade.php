@extends('layouts.app')
@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">
        Website
        @if(auth()->user()->teams->count() > 1)
        - {{ auth()->user()->currentTeam->name }}
        @endif
    </h1>
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


<div class="row-fluid">

    <div class="col-lg-12">
        @if ($websites->count() > 1)
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Websites</h4>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Domain</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach($websites as $website)
                <tr id="news_{{ $website->id }}">
                    <td>
                        {{ $website->name }}
                        @if($website->id == $defaultWebsiteId) 
                        &nbsp;&nbsp;
                        <div class="label label-success">
                            Default
                        </div>
                        @endif
                    </td>
                    <td>
                        <a href="https://dzr.io/{{  $website->token }}"
                            target="_blank">https://dzr.io/{{ $website->token }}</a>
                    </td>
                    <td>
                        @if( !empty($website->domain) ) @if(!empty($website->domain->cloudfront_id) &&
                        $website->domain->cf_status != 'Deployed')
                        <strong>Website is deploying: </strong>
                        <i class="fa fa-spinner fa-pulse"></i> @else

                        <a href="{{ $website->url }}" @if($dark)style="color:white" @endif
                            target="_blank">{{ $website->url }}</a> @endif @else no domain yet @endif
                    </td>
                    <td>
                        <div class="btn-group pull-right">
                            <a href="{{ route('websites.posts.index', $website) }}" class="btn btn-sm btn-primary"
                                title="Manage">
                                <i class="fa fa-cog"></i> Manage
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif

        <div class="card-columns">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Quick Links
                    </h4>
                </div>
                <div class="list-group">
                    @if (!empty($website) )
                    <a class="list-group-item" id="view_link" href="{{ $website->url ?? '' }}" target="_blank">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="media-body media-middle">
                                View Your Website
                            </div>
                            <div class="media-right">
                                <i class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                    <a class="list-group-item" href="{{ route('websites.posts.index', $defaultWebsiteId) }}">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-edit"></i>
                            </div>
                            <div class="media-body media-middle">
                                Add New Post to Website
                            </div>
                            <div class="media-right">
                                <i class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                    <a class="list-group-item" href="{{ route('websites.pages.index', $defaultWebsiteId) }}">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-bookmark"></i>
                            </div>
                            <div class="media-body media-middle">
                                Add New Page to Website
                            </div>
                            <div class="media-right">
                                <i class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                    @endif

                </div>
            </div>

            @if (!empty($user_chart))
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Views</h4>
                </div>
                <br /> {!! $user_chart->container() !!}
            </div>
            <hr>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ count($behavior) == 1 ? key($behavior) : '' }} Top Pages
                    </h4>
                </div>
                <table class="table table-striped table-bordered table-hover table-responsive">
                    @foreach ($behavior as $name => $site) @if(count($behavior) > 1)
                    <thead>
                        <tr>
                            <th colspan="4">{{ $name }}</th>
                        </tr>
                    </thead>
                    @endif
                    <thead>
                        <tr>
                            @if(count($behavior) > 1)
                            <th></th>@endif
                            <th>Page</th>
                            <th>Views</th>
                            <th>Visitors</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($site as $page)
                        <tr>
                            @if(count($behavior) > 1)
                            <td></td>@endif
                            <td>{{ $page['page'] }}</td>
                            <td>{{ $page['views'] }}</td>
                            <td>{{ $page['users'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endforeach
                </table>
            </div>
            @endif
        </div>

    </div> {{-- end col --}}
</div> {{-- end row --}}

@endsection

@section('js')
<link rel="stylesheet" type="text/css"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
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
    });

</script>

@if (!empty($user_chart))
@include('layouts.partials._highcharts')
{!! $user_chart->script() !!}
@endif
@endsection