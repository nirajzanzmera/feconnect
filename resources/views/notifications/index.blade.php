@extends('layouts.app')
@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">
        Notifications
        @if(auth()->user()->teams->count() > 1)
         - {{ auth()->user()->currentTeam->name }}
        @endif
    </h1>
</div>
@endif

<div class="row-fluid">
    <div class="col-md-12">
        
        <div id="inbox">
            <nots nots_url="{{ route('notifications.data', ['data' => 'all']) }}" mark_all="{{ route('notifications.markAll') }}"></nots>
        </div>           

    </div>
    
</div> {{-- end row --}}
@endsection

@section('js')
    <script>
        var nots_url="{{ route('notifications.data', ['data' => 'all']) }}";
    </script>
    <script src="{{ mix('/stuff/notification_inbox.js') }}"></script>
@endsection