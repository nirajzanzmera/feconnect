@extends('fe.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <style type="text/css">
        .sortable {
            min-height: 15px;
        }

        .placeholder {
            height: 50px;
        }

        .drag:hover {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    {{-- @if($headless != true and $hidetitle != true) --}}
    <div>
        <h1 class="page-heading">Websites</h1>
    </div>
    {{-- @endif --}}

    @include('fe.websites._nav')

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
                <div class="card-header">
                    <div class="media">
                        <div class="media-left" style="width: 100%">
                            <h4 class="card-title">
                                Menu / Pages
                            </h4>
                            <p class="card-subtitle">Drag and drop to rearrange their order.</p>
                        </div>
                        <div class="media-right " style="width:100%;">


                            <div class="pull-right">
                                <a class="btn btn-xs q-mark pull-right " tabindex="0" data-toggle="popover" data-placement="left"
                                   title="What are Pages and Posts?"
                                   data-content="
                                            <ul>
                                                <li>
                                                    <strong>Pages</strong> are the permanent parts of your website. They appear in menus and can include a feed of posts on them.
                                                </li>
                                                <li>
                                                    <strong>Posts</strong> are like articles you write on your website, where the newest is the most relevant. Posts appear in a feed on pages that include them.
                                                </li>
                                                <li>
                                                    Use posts for content like news. Use pages for content you would like to display permanently in your menus.
                                                </li>
                                                <li>
                                                    <em><a  href='{{route('websites.posts.index', ['website'=>$website->id])}}'>Click here to edit posts</a></em>
                                                </li>
                                            </ul>
                                            ">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>

                                <a id="daterange" class="">
                                    <i class="fa fa-calendar"></i>&nbsp;Views&nbsp;
                                    <span></span>
                                    <i class="fa fa-caret-down"></i>
                                </a>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="card-block card-block-light">

                    @if(!empty($website->menus))
                        @foreach($website->menus as $menu)
                            <div class="card">
                                <div class="card-header">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $menu->name }} &nbsp; <small id="{{ $menu->id }}_status" style="color: green"></small></h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="pull-right" style="display: flex; align-items: center; ">
                                                <div class="btn-group">
                                                    <a href="{{ route('websites.pages.create', ['website'=>$website->id, 'menu'=>$menu->id]) }}"
                                                       class="btn btn-sm btn-success" title="Add New Page to {{ $menu->name }} menu">
                                                        <i class="fa fa-plus"></i>
                                                        Create Blank Page
                                                    </a>

                                                    <div class="btn-group">
                                                        <div class="dropdown show">
                                                            <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                                               aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-bars"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                <a href="{{ route('websites.pages.create', ['website'=>$website->id, 'menu'=>$menu->id]) }}"
                                                                   class="dropdown-item" title="Create New Page to {{ $menu->name }} menu">
                                                                    <i class="fa fa-plus"></i>
                                                                    Create Blank Page
                                                                </a>
                                                                <a href="{{ route('websites.templates.index', ['website'=>$website->id, 'menu'=>$menu->id]) }}"
                                                                   class="dropdown-item" title="Create New Page to {{ $menu->name }} menu from Template">
                                                                    <i class="fa fa-plus"></i>
                                                                    Create Page from Template
                                                                </a>
                                                                <a href="{{ route('websites.pages.create2', ['website'=>$website->id, 'menu'=>$menu->id, 'type'=>'link']) }}"
                                                                   data-menu_id="{{ $menu->id }}" class="show-link dropdown-item"
                                                                   title="Create new external link to {{ $menu->name }} menu">
                                                                    <i class="fa fa-plus"></i>
                                                                    Create Link in Menu
                                                                </a>
                                                                <a href="{{ route('websites.posts.index', ['website'=>$website->id]) }}"
                                                                   class="dropdown-item" title="Create New Page to {{ $menu->name }} menu">
                                                                    <i class="fa fa-list"></i>
                                                                    Create New Post
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <ul id="sortable{{ $menu->id }}" class="list-group sortable" data-menu_id="{{ $menu->id }}"
                                    data-url="{{ route('websites.menus.sort', ['website'=>$website->id, 'menu'=>$menu->id]) }}">
                                    @foreach($menu_pages as $page)
                                        @include('fe.websites.pages._page')
                                    @endforeach
                                </ul>
                            </div><!-- end card -->

                        @endforeach
                    @endif

                    {{-- Standalone --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title">Standalone ( not in a menu ) &nbsp; <small
                                                id="{{ $menu->id ?? '' }}_status" style="color: green"></small>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right" style="display: flex; align-items: center; ">
                                        <div class="btn-group">

                                            <a href="{{ route('websites.pages.create', ['website'=>$website->id]) }}"
                                               class="btn btn-sm btn-success" title="Create New Page not in a menu">
                                                <i class="fa fa-plus"></i>
                                                Create Blank Page
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <div class="dropdown show">
                                                <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                                   aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-bars"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                    <a href="{{ route('websites.pages.create', ['website'=>$website->id]) }}"
                                                       class="dropdown-item" title="Create New Page to {{ $menu->name ?? '' }} menu">
                                                        <i class="fa fa-plus"></i>
                                                        Create Blank Page
                                                    </a>
                                                    <a href="{{ route('websites.templates.index', ['website'=>$website->id]) }}"
                                                       class="dropdown-item" title="Create New Page to {{ $menu->name ?? '' }} menu from Template">
                                                        <i class="fa fa-plus"></i>
                                                        Create Page from Template
                                                    </a>
                                                    <a href="{{ route('websites.posts.index', $website->id) }}"
                                                       class="dropdown-item" title="Create New Page to {{ $menu->name ?? '' }} menu">
                                                        <i class="fa fa-list"></i>
                                                        Create New Post
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul id="sortable0" class="list-group sortable" data-menu_id="0"
                            data-url="{{ route('websites.menus.detach', ['website'=>$website->id]) }}">
                            @foreach($menu_pages as $page)
                                @if(empty($page->menus) && $page->status!='archived')
                                    @include('fe.websites.pages._page')
                                @endif
                            @endforeach
                        </ul>
                    </div><!-- end card -->

                    {{-- Archived --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title">Archived &nbsp; <small
                                                id="{{ $menu->id ?? '' }}_status" style="color: green"></small>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <ul id="sortable0" class="list-group sortable" data-menu_id="0"
                            data-url="{{ route('websites.menus.detach', ['website'=>$website->id]) }}">
                            @foreach($menu_pages as $page)
                                @if(empty($page->menus) && $page->status=='archived')
                                    @include('fe.websites.pages._page_archived')
                                @endif
                            @endforeach
                        </ul>
                    </div><!-- end card -->

                </div><!-- end card-block -->
            </div>
        </div>
    </div>
@endsection

@section('js2')
    @php
    $startdate = \Carbon\Carbon::parse($startdate->date);
    $enddate = \Carbon\Carbon::parse($enddate->date);
    @endphp
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
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
            $('.copy').on('click', function(e) {
                e.preventDefault();
                var link = $(this).data('link');
                clipboard.writeText(link);
                alert('Copied to Clipboard');
            });

            $('.delete').on('click', function (e) {
                e.preventDefault();
                var url = $(this).data('url');
                var id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to DELETE this Page?",
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
                                $('#' + id).remove();
                            }
                        });
                    }
                });
            });

            $('.archive').on('click', function (e) {
                e.preventDefault();
                var url = $(this).data('url');
                var id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to ARCHIVE this Page?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'ARCHIVE'],
                })
                        .then(willDelete => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            success: function (result) {
                                $('#' + id).remove();
                                window.location.reload();
                            }
                        });
                    }
                });
            });

            $('.unarchive').on('click', function (e) {
                e.preventDefault();
                var url = $(this).data('url');
                var id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to UNARCHIVE this Page?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'UNARCHIVE'],
                })
                        .then(willDelete => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            success: function (result) {
                                $('#' + id).remove();
                                window.location.reload();
                            }
                        });
                    }
                });
            });

            $('[data-toggle="popover"]').popover({
                trigger: 'focus',
                html: true,
            });
            $('ul[id^="sortable"]').each(function() {
                $(this).sortable({
                    connectWith: ".sortable",
                    placeholder: "placeholder list-group-item active",
                    handle: ".drag",
                    update: function(event, ui) {
                        var sort = $(this).sortable('toArray');
                        var url = $(this).data('url');
                        var menu_id = $(this).data('menu_id');
                        console.log('#' + menu_id + '_status');
                        $('#' + menu_id + '_status').html('<i class="fa fa-checkbox fa-spin"></i>');
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                'sort[]': sort
                            },
                            context: this,
                            success: function(data) {
                                var id = '#' + data.menu_id + '_status';
                                $(id).html('<i class="fa fa-check-square-o"></i> Updated');
                            }
                        });
                    }
                });
                $(this).disableSelection();
            });

            $('#daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },

                "startDate": '{{ $startdate->format("Y-m-d") }}',
                "endDate": '{{ $enddate->format("Y-m-d") }}',
                "minDate": moment().subtract(90, 'days'),
                "maxDate": moment(),
                "opens": 'left',
                "alwaysShowCalendars": true,

                "ranges": {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
            }, cb);
            $('#daterange span').html('{{ $startdate->format("Y-m-d") }} - {{ $enddate->format("Y-m-d") }}');

            function cb(start, end) {
                window.location = '{{ route("websites.pages.index", $website->id) }}?sd=' + start.format('YYYY-MM-DD') + '&ed=' + end.format('YYYY-MM-DD');
            }
            $(".daterangepicker ").appendTo(".layout-content");
        });
    </script>
@endsection