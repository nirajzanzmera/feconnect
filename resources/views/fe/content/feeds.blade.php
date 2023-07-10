@extends('fe.layouts.app')
@section('content')

    @include('fe.content._nav')

    <div class="row-fluid">
        <div class="col-md-12">

            @if ($errors->any())
                <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                           {{ $error }}
                        @endforeach

                </div>
            @endif

            <div class="card">

                <div class="card-header">
                    Create New External feed
                </div>
                <div class="card-block">
                    <form method="post" action="{{ url('content/feeds') }}">
                        {{ csrf_field() }}
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">Url</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="url" value="">
                                <span class="help-block">
                                @foreach ($errors->all() as $error)
                                        <strong>{{ $error }}</strong>
                                    @endforeach
                            </span>
                            </div>
                            @if ($errors->any())

                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-save"></i> Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="col-md-12">
            <div class="card">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>Url / Name</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($feeds as $feed)
                    <tr id="feed_3671">
                        <td>
                           {{ $feed->url }}
                        </td>
                        <td>
                            {{ $feed->type }}
                        </td>
                        <td>

                            <div class="btn-group pull-right">
                                <a href="{{ route('content.feeds.show',['id' => $feed->id]) }}" class="btn btn-sm btn-info loading" title="Preview">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('content.feeds.edit',['id' => $feed->id]) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <div class="btn-group">
                                    <div class="dropdown show">
                                        <a class="btn btn-sm btn-default dropdown-toggle" href="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a href="{{ route('content.feeds.show',['id' => $feed->id]) }}" class="dropdown-item" title="Preview">
                                                <i class="fa fa-eye"></i> Preview
                                            </a>
                                            <a href="{{ route('content.feeds.edit',['id' => $feed->id]) }}" class="dropdown-item" title="Edit">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>

                                            <a href="#" class="dropdown-item feed-delete" data-id="3671" data-url="{{ route('content.feeds.show',['id' => $feed->id]) }}"><i class="fa fa-trash-o"></i>
                                                Delete...
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div>
        </div>
    </div>


@endsection

@section('css')
    <style type="text/css">
    </style>
@endsection

@section('js')
    @include('fe.layouts._popover')
@endsection