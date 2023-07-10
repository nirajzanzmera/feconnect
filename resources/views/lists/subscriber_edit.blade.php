@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Subscriber - Manage :  {{ $subscriber->email }}</h1>
    @include('lists._nav')
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('lists.index') }}">Lists</a></li>
    <li class="active">Subscriber</li>
</ol>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">{{ $subscriber->email }}</h4>
                        <p class="card-subtitle">Subscribed on {{ $subscriber->subscribe_stamp }}</p>
                    </div>
                    <div class="media-right media-middle">
                       <span class="label label-pill {{ ($subscriber->status == 'unsubscribe') ? 'label-danger' : 'label-success' }}">
                           {{ ucfirst($subscriber->status) }}
                       </span>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <form method="post" action="{{ route('lists.subscribers.update', $subscriber->id) }}">
                    {!! csrf_field() !!}
                    <div class="row form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-3">Email:</label>
                        <div class="col-md-9">
                            <h5>{{ $subscriber->email }}</h5>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3">Status:</label>
                        <div class="col-md-6">
                            <select name="status" class="form-control">
                                @if($subscriber->status == 'active')
                                    <option value="active" selected>Active</option>
                                @else
                                    <option value="active">Active</option>
                                @endif
                                @if($subscriber->status == 'unsubscribe')
                                    <option value="unsubscribe" selected>Unsubscribed</option>
                                @else
                                    <option value="unsubscribe">Unsubscribed</option>
                                @endif            
                                @if(($subscriber->status != 'active') && ($subscriber->status != 'unsubscribe'))
                                    <option value="" selected>Deliverability</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-save"></i> {{ empty($subscriber) ? 'Create' : 'Update' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container">
                
            <ul class="list-group list-group-flush ">
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: right">
                        Source: 
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->source ?? '' }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: right">
                        Subscribed On: 
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->subscribe_stamp }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: right">
                        Last Send: 
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->last_send_stamp }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: right">
                        Last Open:
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->last_open_stamp }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: right">
                        Last Click:
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->last_click_stamp }}
                    </div>
                </li>
            </ul>
            </div>
            
        </div>

        <div class="card">
            <div class="card-header">
                Subscriber Data
            </div>
            <div class="card-block">
                <form method="post" action="{{ route('lists.subscribers.update_data', $subscriber->id) }}">
                    {!! csrf_field() !!}
                    <div class="items">
                        @foreach ($subscriber->subscriberdata as $row)
                        <div class="row form-group">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="{{ $row->id }}_key" value="{{ $row->key }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="{{ $row->id }}_value" value="{{ $row->value }}">
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="{{ $row->id }}_delete" value="null">
                                        Delete
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <a href="" class="btn btn-primary item_add">Add</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-save"></i> {{ empty($subscriber) ? 'Create' : 'Update' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="col-md-6 ">

    {{-- <div class="card">
        <div class="card-header">
            <div class="media">
                <div class="media-body">
                    <h4 class="card-title">History</h4>
                    <p class="card-subtitle">All the actions taken by this subscriber</p>
                </div>
                <div class="media-right media-middle">
                    <a href="{{ route('lists.subscribers.download_history', $subscriber) }}" class="btn btn-sm btn-warning pull-right"><i class="fa fa-btn fa-download"></i>Download</a>
                </div>
            </div>
        </div>
        <div class="card-block">
            ...
        </div>
    </div> --}}

</div>

</div>
@endsection
@section('js')
<script>
$(document).ready(function(){
var item_count = 0;
$('.item_add').click(function(event){
item_count++;
$('.items').append('<div class="row form-group"><label class="col-md-1">Name:</label><div class="col-md-4"><input type="text" class="form-control" name="'+ item_count +'_newKey" value=""></div><label class="col-md-1">Value:</label><div class="col-md-4 col-md-offset-1"><input type="text" class="form-control" name="'+ item_count +'_newValue" value=""></div></div>');
$('.item_count').val(item_count);
event.preventDefault();
});
});
</script>
@endsection
