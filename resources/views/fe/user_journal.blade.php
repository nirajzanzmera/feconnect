@extends('fe.layouts.app')
@section('css')
<style>
    @media (max-width:1024px) {
        #posts .media {
            flex-direction: column;
        }
        .list-group li{ 
            margin: 2px 2px
        }
    }
</style>
@endsection
@section('content')
    <div>
        <h1 class="page-heading"> User Journal - {{$g_user->name}}</h1>
    </div>

    @include('fe.teamwork._nav')

    <div class="row">
        <div class="col-xl-12">
            <div class="card" style="background-color: #F2F2F2">
                <ul class="list-group">
                    @foreach ($journals as $key => $row)
                        <li class="list-group-item">
                            <div class="media">
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-xs-2 col-sm-2 col-md-1 text-center">
                                            <h2 class="{{$row['icon-color'] ?? ''}}"><i class="fa {{$row['icon']}}"></i></h2>
                                        </div>
                                        <div class="col-xs-10 col-sm-10 col-md-5">
                                            {{$row['title']}}<br>
                                            {{$row['date']}}
                                        </div>

                                        @if (!empty($row['addition']))
                                            <div class="col-xs-2 col-sm-2 col-md-1 text-center">
                                                <h2 class="{{$row['addition']['icon-color'] ?? ''}}"><i class="fa {{$row['addition']['icon']}}"></i></h2>
                                            </div>
                                            <div class="col-xs-10 col-sm-10 col-md-5">
                                                @foreach ($row['addition']['items'] as $item)
                                                    + {{$item}}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>



@endsection

@section('js')
<script src="{{ mix('/stuff/standalone.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#saveAvatar').hide();
        $('#featured_image').on('change', function(){
            $('#saveAvatar').show();
        });
        if($('#featured_image').val() != '') {
            $('#saveAvatar').show();
        }

    });
</script>
@endsection