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
    <h1 class="page-heading">Key Edit</h1>
</div>

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
    <div class="row-fluid">
    <div class="col-md-12">
        <form method="post" action="{{route('key.update',$id)}}" id="editor_form">
            {!! csrf_field() !!}
            <div class="card">
                <div class="card-block">
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">Nickname</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="nickname" value="{{ $nickname }}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">Status</label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control">

                                <option value="hide" @if($status=='hide') selected @endif>Hide</option>
                                <option value="active" @if($status=='active') selected @endif>Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-save"></i> Update
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </form>

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