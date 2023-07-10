@extends('layouts.app')
@section('content')

@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">
        Website: {{ $website->name ?? '' }}
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
        <div class="card">
            <div class="card-header">
                <div class="container " style="max-width: 100%">
                    <div class="pull-left">
                        <h4 class="card-title">Websites</h4>
                    </div>
                    <div class="media-right pull-right ">
                        <div class="btn-group pull-right">

                            <div class="btn-group">
                                <div class="dropdown show d-block">
                                    <a class="btn btn-sm btn-default dropdown-toggle" id="dropdownMenuLink" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{ $default_website_id ? route('websites.pages.index', $default_website_id) : '' }}" title="Create New Page on Default Website">
                                            <i class="fa fa-bookmark"></i>
                                            @if ($websites->count() > 1)
                                                Create Page on Default Website
                                            @else
                                                Create New Website Page
                                            @endif
                                        </a>
                                        <a class="dropdown-item" href="{{ $default_website_id ? route('websites.posts.index', $default_website_id) : '' }}" title="Create New Post on Default Website">
                                            <i class="fa fa-list"></i>
                                            @if ($websites->count() > 1)
                                                Create Post on Default Website
                                            @else
                                                Add New Post to Website
                                            @endif
                                        </a>
                                        <a class="dropdown-item" href="{{ route('websites.create') }}" title="Create New Website">
                                            <i class="fa fa-globe"></i>
                                            Create New Website
                                        </a>
                                        @if(Auth::user()->admin == true )
                                        <a class="dropdown-item" href="{{ route('websites.create_sc') }}" title="Create Shopping Cart Website">
                                            <i class="fa fa-shopping-cart"></i>
                                            Create Shopping Cart Website (beta)
                                        </a>
                                        <a class="dropdown-item" href="https://sell.amazon.com/" title="Create Amazon Store >>" target="_blank">
                                            <i class="fa fa-amazon"></i>
                                            Create Amazon Store >> (beta)
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($websites->count() > 1)
            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-lg-down row ">
                        <div class="col-lg-6"><strong>Name:</strong></div>
                        <div class="col-lg-3"><strong>Domain:</strong></div>
                        <div class="col-lg-3"></div>
                    </li>
                    @foreach($websites as $website)
                    <li class="list-group-item row" id="website_{{ $website->id }}">
                    <div class="col-xl-6">
                        <label class="hidden-xl-up">Name:</label>
                        {{ $website->name }}
                        @if($website->id == $default_website_id)
                        &nbsp;
                        &nbsp;
                        <div class="label label-success">
                            Default
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-3">
                        <label class="hidden-xl-up">Domain:</label>
                        @if( !empty($website->domain) || !empty($website->subdomain)) 
                            @if(!empty($website->domain->cloudfront_id) &&
                                $website->domain->cf_status != 'Deployed')
                                <strong>Website is deploying: </strong>
                                <i class="fa fa-spinner fa-pulse"></i> 
                            @else
                                <a href="{{ $website->url }}"
                                    target="_blank">{{ $website->url }}</a> 
                            @endif 
                        @else 
                            no domain yet 
                        @endif
                    </div>
                    <div class="col-xl-3">                    
                        @if(empty($website->settings->ecwid_store_id) && (($website->settings->is_ecwid_store ?? false) == false))
                            @rowmenu(['items' => $website->btns])@endrowmenu
                        @else
                            <div class="btn-group pull-right">
                                <a class="btn btn-sm btn-primary" href="{{ route('shopping_cart.index',$website['id']) }}" title="Settings">
                                    <i class="fa fa-cog"></i>
                                </a>
                                <a class="btn btn-sm btn-secondary" href="{{ route('shopping_cart.sso',$website['id']) }}" title="Control Panel">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>

                                <div class="btn-group">
                                    <div class="dropdown show">
                                        <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                <a href="{{ $website->settings->ecwid_store_url ?? '' }}" title="Preview" class="dropdown-item " target="_blank">
                                                                        <i class="fa fa-eye"></i>
                                                                        Preview
                                                                </a>
                                                                <a href="#" title="Copy Link" class="dropdown-item copy" data-link="{{ $website->settings->ecwid_store_url ?? '' }}">
                                                                        <i class="fa fa-share"></i>
                                                                        Copy Link
                                                                </a>
                                                                <a href="{{ route('shopping_cart.index',$website['id']) }}" title="Edit" class="dropdown-item ">   
                                                                        <i class="fa fa-cog"></i>
                                                                        Settings
                                                                </a>
                                                                <a href="{{ route('shopping_cart.sso',$website['id']) }}" title="Control Panel" class="dropdown-item " target="_blank">   
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                        Control Panel
                                                                </a>
                                                                 {{--TODO: requires a special method to handle cart billing and winding down store. Should probably not be this easy. At least 2 steps--}}
                                                                    <a href="" title="Delete..." class="dropdown-item delete" data-id="{{$website['id']}}" data-url="{{route('websites.destroy',$website['id'])}}"> 
                                                                        <i class="fa fa-trash-o"></i>
                                                                        Delete...
                                                                </a>
                                                                
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="card-columns">
            @if(!(!empty($websites) && $websites->count() > 1))
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Quick Links
                    </h4>
                </div>
                <div class="list-group">
               
                    <a class="list-group-item{{ $default_website_id ? '' : ' disabled' }}" id="view_link"
                        href="{{ $website->url ?? '' }}" target="_blank">
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
                    <a class="list-group-item{{ $default_website_id ? '' : ' disabled' }}" href="{{ $default_website_id ? route('websites.posts.index', $default_website_id) : '' }}">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-list"></i>
                            </div>
                            <div class="media-body media-middle">
                                Add New Post to Website
                            </div>
                            <div class="media-right">
                                <i class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
                    <a class="list-group-item{{ $default_website_id ? '' : ' disabled' }}" href="{{ $default_website_id ? route('websites.pages.index', $default_website_id) : ''}}">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-bookmark"></i>
                            </div>
                            <div class="media-body media-middle">
                                Edit Website Pages
                            </div>
                            <div class="media-right">
                                <i class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>
           
                </div>
            </div>
            @endif
            @if (!empty($user_chart))
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Visitors</h4>
                </div>
                <br /> {!! $user_chart->container() !!}
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ count($behavior) == 1 ? key($behavior) : '' }} Top Pages
                    </h4>
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
            @endif
        </div>

    </div> {{-- end col --}}
</div> {{-- end row --}}

@endsection

@section('js')
<link rel="stylesheet" type="text/css"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.copy').on('click', function(e) {
            e.preventDefault();
            var link = $(this).data('link');
            clipboard.writeText(link);
            alert('Copied to Clipboard');
        });


        $('.loading').click(function(e) {
            $(this).html('<i class="fa fa-spinner fa-pulse"></i> loading...');
            $(this).addClass('disabled');
        });
    });


    $('.delete').on('click', function (e) {
        e.preventDefault();
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
                    type: 'DELETE',
                    success: function (result) {
                        $('#website_' + id).remove();
                    }
                });
            }
        });
    });

</script>

@if (!empty($user_chart))
@include('layouts.partials._highcharts')
{!! $user_chart->script() !!}
@endif
@endsection
