@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Subscribers</h1> 
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('lists.index') }}">Lists</a></li>
    <li class="active">{{ $list->name }}</li>
</ol>
@include('lists._nav')


<div class="row-fluid" id="quickAddSubs">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Quick Add Subscribers
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('lists.subscribers.quick_add', $list->id) }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="quickadd">Add up to 100 email address in the text area below. Separate them by comma or space or newline.</label>
                        <textarea class="form-control" id="quickadd" name="quickadd" ></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">+ Add Subscribers</button>
                    </div>
                </form>
            </div>
            <div class="card-header">
                Active Subscriber Count: <span class="count" data-list_id="{{ $list->id }}"></span>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-md-12">
        @if(session('successes')) 
            <div class="alert alert-success">
                <strong>Emails Subscribed:</strong><br />
                @foreach(session('successes') as $msg)
                    {{ $msg }} <br />
                @endforeach
            </div>
        @endif
        @if(session('messages')) 
            <div class="alert alert-warning">
                <strong>Emails with issues:</strong><br />
                @foreach(session('messages') as $msg)
                    {{ $msg }} <br />
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="row-fluid">
   @include('layouts.partials._datatable', ['route'=>'subscribers.index', 'parent'=>'list_id', 'parent_id'=>$list->id, 'limit'=>100])
</div>
@endsection


@section('js2')
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.count').each(function(){
        var list_id = $(this).data('list_id');
        updateListCount(this, list_id);
    });

    function updateListCount(target, list_id) {
        $(target).html('loading...');
        $.get('{{ route('list.get_count') }}?id=' + list_id, function(data) {
            $(target).html(data);
        });
    }
});
</script>
@endsection
