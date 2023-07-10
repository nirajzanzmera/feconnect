@extends('fe.layouts.app')
@section('content')

    <style>
        li.list-group-item.unread {
            border: 1px dashed #789;
            background: #d3d3d3;
            font-weight: 700;
            cursor: pointer;
        }
    </style>
    <div>
        <h1 class="page-heading">
            Notifications
            - {{$g_user->name}}
        </h1>
    </div>

    <div class="row-fluid">
        <div class="col-md-12">

            <div id="inbox">
                <div class="card">
                    <div class="card-header">

                        <div class="card-header">
                            <div class="card-title">
                                Notifications
                                <div class="pull-right">
                                    <a href="" class="btn btn-sm btn-primary">Mark All Read</a>
                                </div>
                            </div>
                        </div>

                         <ul class="list-group">
                             <?php $cnt = 0; ?>
                             @foreach($notifications as $notification)
                             <div>
                                 @if($notification->isStatus!="archived")
                                     <?php $cnt++; ?>
                                 <li id="list_{{ $notification->id }}" class="list-group-item @if($notification->isStatus == 'unread') unread @endif">
                                     <div class="row">
                                         <div class="col-xl-2 col-lg-2">{{ date('m/d/Y',strtotime($notification->created_at)) }}</div>
                                         <div class="col-xl-9 col-lg-9">
                                             <a href="{{ route('notification.get',
                                             ['id'=>$notification->id])}}" style="color: black"><strong>{{ $notification->data->title ?? '' }}</strong>
                                             </a>
                                                 <br>
                                             <small>
                                                 {{--{{ $notification->data->msg }}--}}
                                                 @if(strlen($notification->data->msg ?? '')<=320)
                                                     {{ $notification->data->msg ?? '' }}
                                                 @else
                                                     {{ substr($notification->data->msg ?? '',0,320)." ..." }}
                                                 @endif
                                             </small>


                                             @if(($notification->data->route ?? '') != "")
                                             <br>
                                             <a href="{{ ($notification->data->route ?? '') }}" target="_blank">View</a>
                                             @endif
                                         </div>
                                         <div class="col-xl-1 col-lg-1">
                                             <button class="btn btn-primary" id="archive_{{ $notification->id }}" onclick="archive('{{ $notification->id }}')">Archive</button>
                                         </div>
                                     </div>
                                 </li>

                                 @endif
                             </div>
                             @endforeach

                             @if($cnt==0)
                                     <div><li class="list-group-item">{{ "No unread notification" }}</li></div>
                             @endif
                         </ul>

                        <div class="card-header">
                            <div class="card-title">
                                Archived Notifications
                            </div>
                        </div>

                        <ul class="list-group">
                            @foreach($notifications as $notification)
                                <div>
                                    @if($notification->isStatus=="archived")
                                    <li id="list_{{ $notification->id }}" class="list-group-item @if($notification->isStatus == 'unread') unread @endif">
                                        <div class="row">
                                            <div class="col-xl-2 col-lg-2">{{ date('m/d/Y',strtotime($notification->created_at)) }}</div>
                                            <div class="col-xl-10 col-lg-10">
                                                <a href="{{ route('notification.get',
                                             ['id'=>$notification->id])}}" style="color: black"><strong>{{ $notification->data->title ?? '' }}</strong></a>
                                                <br>
                                                <small>
                                                    {{--{{ $notification->data->msg }}--}}
                                                    @if(strlen($notification->data->msg ?? '')<=320)
                                                        {{ $notification->data->msg ?? '' }}
                                                    @else
                                                        {{ substr($notification->data->msg ?? '',0,320)." ..." }}
                                                    @endif
                                                </small>


                                                @if(($notification->data->route ?? '') != "")
                                                    <br>
                                                    <a href="{{ ($notification->data->route ?? '') }}" target="_blank">View</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                </div>
                            @endforeach
                        </ul>
                    </div>
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

    <script>
        function archive(id){
            $.ajax(
                {
                    url: "{{ url('/notification/archive/') }}/"+id,
                    success: function(result)
                    {
                        location.reload();
                    }
                }
            );
        }
    </script>
@endsection