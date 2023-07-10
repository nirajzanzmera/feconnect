@extends('fe.layouts.app')
@section('content')

    <div>
        <h1 class="page-heading">
            Notifications
            - {{$g_user->name}}
        </h1>
    </div>

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Notification</h4>

                    </div>
                    <div class="col text-right">
                        <a class="btn btn-sm btn-secondary float-right" title="Website Analytics" href="{{ route('notifications.index') }}">
                            Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                @foreach($notifications as $notification)
                    @if($notification->id == $noti_id )
                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item row hide">
                            <div class="col-xs-2" style="text-align: right">
                                Type:
                            </div>
                            <div class="col-xs-10">
                                {{ $notification->type }}
                            </div>
                        </li>

                        {{--
                        <li class="list-group-item row">
                            <div class="col-xs-2" style="text-align: right">
                                Notifiable Type:
                            </div>
                            <div class="col-xs-10">
                                {{ $notification->notifiable_type }}
                            </div>
                        </li>
                        --}}
                        <li class="list-group-item row">
                            {{--
                            <div class="col-xs-2" style="text-align: right">
                                Title:
                            </div>
                            --}}
                            <div class="col-xs-12">
                                <B>{{ $notification->data->title }}</B>
                            </div>
                        </li>
                        <li class="list-group-item row">
                            {{--
                            <div class="col-xs-2" style="text-align: right">
                                Message:
                            </div>
                            --}}
                            <div class="col-xs-12">
                            {!! nl2br($notification->data->msg) !!}
                            </div>
                        </li>
                        {{--
                        <li class="list-group-item row">
                            <div class="col-xs-2" style="text-align: right">
                                Created At:
                            </div>
                            <div class="col-xs-10">
                                {{ $notification->created_at }}
                            </div>
                        </li>
                        --}}
                        <li class="list-group-item row">
                            {{--
                            <div class="col-xs-2" style="text-align: right">
                                Human:
                            </div>
                            --}}
                            <div class="col-xs-12">
                                <small>{{ $notification->human }}</small>
                            </div>
                        </li>
                        {{--
                        <li class="list-group-item row">
                            <div class="col-xs-2" style="text-align: right">
                                Status:
                            </div>
                            <div class="col-xs-10">
                                {{ $notification->isStatus }}
                            </div>
                        </li>
                        --}}
                    </ul>
                    @endif
                @endforeach
            </div>

        </div>

    </div>

</div>
@endsection

@section('js')
    <script>
        var nots_url="{{ route('notifications.data', ['data' => 'all']) }}";
    </script>
    <script src="{{ mix('/stuff/notification_inbox.js') }}"></script>
@endsection