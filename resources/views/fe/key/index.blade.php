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
<div>
    <h1 class="page-heading">Key</h1>
</div>

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row-fluid">
    @if(isset($key))
    <div class="alert alert-success" style="word-break: break-all!important;"> key: {{ $key }}
    </div>
    @endif
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">
                    Active Key List
                </h4>
            </div>
            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-lg-down row ">
                        <div class="col-lg-2"><strong>Nickname</strong></div>
                        <div class="col-lg-2"><strong>Access Type</strong></div>
                        <div class="col-lg-2"><strong>Status</strong></div>
                        <div class="col-lg-2"><strong>Created</strong></div>
                        <div class="col-lg-2"><strong>Expires</strong></div>
                        <div class="col-lg-2"><strong></strong></div>
                    </li>

                    @foreach($data as $list)
                    <li class="list-group-item row">
                        <div class="col-xl-2">
                            {{ $list->nickname }}
                        </div>

                        <div class="col-xl-2">
                            {{ $list->access_type }}
                        </div>

                        <div class="col-xl-2">
                            @if($list->status=="hide")
                                <label class="text-danger">{{ $list->status }}</label>
                            @else
                                <label class="text-success">{{ $list->status }}</label>
                            @endif
                        </div>

                        <div class="col-xl-2">
                            {{ $list->created_at }}
                        </div>
                        <div class="col-xl-2">
                            {{ $list->expires_at }}

                        </div>
                        <div class="col-xl-2">

                            <div class="btn-group pull-right">

                                <a href="{{route('key.edit', $list->id)}}" title="Key" class="btn btn-sm btn-secondary ">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <div class="btn-group">
                                    <div class="dropdown show">
                                        <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            
                                            <a href="{{route('key.delete', $list->id)}}" class="dropdown-item tmp_delete" data-id="{{$list->id}}" data-url="{{route('key.delete', $list->id)}}">
                                                <i class="fa fa-trash-o"></i>
                                                Delete....
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </li>
                    @endforeach
                </ul>
            </div></div>
    </div>
</div>

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Add Key
                </h4>
            </div>
            <div class="card-block">

                <form method="post" action="{{route('key.store')}}" id="editor_form">
                    {!! csrf_field() !!}
                    <div class="form-group row">
                        <label class="col-md-4 form-control-label" style="text-align: right">Nickname</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="nickname" id="nickname" value="" required>
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js2')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/bootstrap-daterangepicker-plus@2.1.25/daterangepicker.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection