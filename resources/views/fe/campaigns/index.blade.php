@extends('fe.layouts.app')
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    label {
        font-weight: bold;
    }
    .paginate-div nav {
        display: flex;
        justify-content: center;
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
        Email Blasts
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
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Emails
                </div>
            </div>
            @if(count($campaigns) == 0)
            <div class="card-block">
                <p>
                    <h2 class="text-muted"><i>Create your first Email Blast!</i></h2> <br />
                    <a class="btn btn-success" href="{{ route('campaigns.create') }}">+ Create</a>
                </p>
            </div>
            @endif

            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-lg-down row ">
                        <div class="col-lg-3"><strong>Subject:</strong></div>
                        <div class="col-lg-2"><strong>Schedule:</strong></div>
                        <div class="col-lg-1"><strong>Sends:</strong></div>
                        <div class="col-lg-1"><strong>Opens:</strong></div>
                        <div class="col-lg-1"><strong>Clicks:</strong></div>
                        <div class="col-lg-1"><strong>Status:</strong></div>
                        <div class="col-lg-3"></div>
                    </li>
                    @foreach($campaigns as $campaign)
                        <li class="list-group-item row" id="camp_{{ $campaign->id }}">
                            <div class="col-xl-3 ellipsis">
                                <a class="float-none" href="{{ route('campaigns.preview', ['campaign'=>$campaign->id]) }}">
                                    <img style="max-width:50px; padding-right:5px;" src="{{
                                            !empty($campaign->thumb) ?
                                            "https://dataczar-public.s3.us-west-2.amazonaws.com/$campaign->thumb" :
                                            'https://via.placeholder.com/100x100' }}?id={{ time() }}">
                                </a>
                                {{ $campaign->subject }}
                                @if(!empty($campaign->schid) && !empty($campaign->schid->item) && $campaign->schid->item->html == "")
                                    <div class="alert alert-danger">
                                        render error
                                    </div>
                                @endif
                                @if(empty($campaign->schid) || empty($campaign->schid->item) )
                                    <div class="alert alert-danger">
                                        system error
                                    </div>
                                @endif
                            </div>
                            <div class="col-xl-2">
                                <label class="hidden-xl-up">Schedule:</label>
                                {{ \Carbon\Carbon::parse($campaign->schedule->date, $campaign->schedule->timezone)->format('m/d/Y g:i A T') }} 
                            </div>
                            <div class="col-xl-1">
                                <label class="hidden-xl-up">Sends:</label>
                                {{ number_format(!empty($campaign->tracking->send) ? $campaign->tracking->send : 0) }}
                            </div>
                            <div class="col-xl-1">
                                <label class="hidden-xl-up">Opens:</label>
                                {{ number_format(!empty($campaign->tracking->open) ? $campaign->tracking->open : 0) }}
                            </div>
                            <div class="col-xl-1">
                                <label class="hidden-xl-up">Clicks:</label>
                                {{ number_format(!empty($campaign->tracking->link) ? $campaign->tracking->link : 0) }}
                            </div>
                            <div class="col-xl-1">
                                <label class="hidden-xl-up">Status:</label>
                                <div
                                    class="label {{ ( !empty($campaign->schid) && $campaign->schid->status == 'sent') ? 'label-success' : 'label-info'}}">
                                    {{ ($campaign->status == 'PUBLISHED') ? $campaign->schid->status : $campaign->status }}
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="btn-group" style="padding-top:10px;">
                                    <a href="{{ route('campaigns.preview', ['campaign'=>$campaign->id]) }}" class="btn btn-sm btn-info"
                                        title="Preview"><i class="fa fa-eye"></i></a>
                                    @if($campaign->status != 'PUBLISHED' && $campaign->status != 'locked')
                                    <a href="{{ route('campaigns.publish_preview', ['campaign'=>$campaign->id] ) }}"
                                        class="btn btn-sm btn-success" title="Schedule"><i
                                            class="fa fa-calendar"></i></a>
                                    @endif
                                    @if($campaign->status != 'PUBLISHED' && $campaign->status != 'locked')
                                    <a href="{{ route('campaigns.edit', ['campaign'=>$campaign->id]) }}"
                                        class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if( (!empty($campaign) && !empty($campaign->schid)) && $campaign->schid->status !=
                                    'sent'
                                    && $campaign->schid->status != 'processing' && $campaign->status == 'PUBLISHED')
                                    <a href="{{ route('campaigns.cancel', ['campaign'=>$campaign->id]) }}"
                                        class="btn btn-sm btn-warning" title="Cancel"><i class="fa fa-times"></i></a>
                                    @endif
                                    @if( (!empty($campaign) && !empty($campaign->schid)) && $campaign->schid->status ==
                                    'sent')
                                    {{-- <a href="{{ route('reports.blast_report', $campaign->id ) }}"
                                        class="btn btn-sm btn-secondary" title="Reporting">
                                        <i class="fa fa-bar-chart"></i>
                                    </a> --}}
                                    <a href="#"
                                        class="btn btn-sm btn-secondary" title="Reporting">
                                        <i class="fa fa-bar-chart"></i>
                                    </a>
                                    @endif
                                    <div class="btn-group">
                                        <div class="dropdown show">
                                            <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuLink">

                                                <a href="{{ route('campaigns.preview', ['campaign'=>$campaign->id]) }}" class="dropdown-item"
                                                    title="Preview"><i class="fa fa-eye"></i> Preview</a>
                                                @if($campaign->status != 'PUBLISHED')
                                                <a href="{{ route('campaigns.publish_preview', ['campaign'=>$campaign->id] ) }}"
                                                    class="dropdown-item" title="Schedule"><i
                                                        class="fa fa-calendar"></i> Schedule</a>
                                                @endif
                                                @if($campaign->status != 'PUBLISHED' && $campaign->status != 'locked')
                                                <a href="{{ route('campaigns.edit', ['campaign'=>$campaign->id]) }}"
                                                    class="dropdown-item" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                                @endif
                                                @if( (!empty($campaign) && !empty($campaign->schid)) &&
                                                $campaign->schid->status
                                                != 'sent' && $campaign->schid->status != 'processing' && $campaign->status
                                                ==
                                                'PUBLISHED')
                                                <a href="{{ route('campaigns.cancel', ['campaign'=>$campaign->id]) }}"
                                                    class="dropdown-item" title="Cancel"><i class="fa fa-times"></i>
                                                    Cancel</a>
                                                @endif
                                                @if( (!empty($campaign) && !empty($campaign->schid)) &&
                                                $campaign->schid->status
                                                == 'sent')
                                                {{-- <a href="{{ route('reports.blast_report', $campaign->id ) }}"
                                                    class="dropdown-item" title="Reporting"><i class="fa fa-bar-chart"></i>
                                                    Reporting
                                                </a> --}}
                                                <a href="#"
                                                    class="dropdown-item" title="Reporting"><i class="fa fa-bar-chart"></i>
                                                    Reporting
                                                </a>
                                                @endif
                                                
                                                <a href="{{ route('campaigns.saveAs', ['campaign'=>$campaign->id]) }}" class="dropdown-item">
                                                    <i class="fa fa-envelope fa-menu"></i> Save as Email
                                                </a>

                                                <a href="#" class="dropdown-item camp-delete" data-id="{{ $campaign->id }}"
                                                    data-url="{{route('campaigns.destroy', ['campaign'=>$campaign->id])}}"><i
                                                        class="fa fa-trash-o"></i> Delete....</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    <div class="paginate-div">
                        {{ $campaigns->links() }}
                    </div>
                </ul>
            </div>


        </div>
    </div>
</div>

@endsection
@section('js')
<link rel="stylesheet" type="text/css"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     $('.camp-publish').on('click', function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to Schedule this email blast?",
            icon: "warning",
            buttons: [true, 'Publish'],
        })
        .then(willPublish => {
            if (willPublish) {
                window.location = url;
            }
        });
    });
    $('.camp-delete').on('click', function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to DELETE this email blast?",
            icon: "warning",
            dangerMode: true,
            buttons: [true, 'DELETE'],
        })
        .then(willDelete => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(result) {
                        $('#camp_' + id).remove();
                    }
                });
            }
        });
    });
    
    $('.date').datepicker({
        multidate: true,
        format: 'yyyy-mm-dd',
    });
    //readonly!
    $('.datepicker-days').click(function(event) {
        event.preventDefault();
        event.stopPropagation();
    });
});
</script>
@endsection
