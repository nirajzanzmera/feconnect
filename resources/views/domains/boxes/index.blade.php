@extends('layouts.app')
@section('content')

@if( strpos(Route::currentRouteName(), "new") === 0 )
    @include('domains.partials._nav')
@else
    @include('domains._nav')
@endif

<div class="row-fluid">
    <div class="col-xl-10">

        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title pull-left">
                            Emails: <span class="text-primary">{{ $domain->domain ?? '' }}</span>
                        </h4>
                    </div>
                </div>
            </div>

            <ul class="list-group">
                @foreach($boxes as $box)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Email:</strong> {{ $box->mailbox }}{{ '@' . $domain->domain }}
                        </div>
                        <div class="col-md-6">
                            @rowmenu(['items' => $box->btns])@endrowmenu
                        </div>
                    </div>
                    <strong>Aliases:</strong> {{ $box->aliases }}
                    <br />
                    <strong>API Status:</strong> {{ $box->provider_status }}
                    <strong>Status:</strong> {{ $box->status }}
                </li>
                @endforeach
            </ul>

            <div class="card-block">
                <legend>Add New</legend>
                <form action="{{ route('domains.email_boxes.store', $domain) }}" method="POST" id="box_form">
                    {{ csrf_field() }}
                    @include('domains.boxes._form')
                    <button class="btn btn-success" id="submit_btn">
                        <i class="fa fa-plus"></i>
                        New Email Box
                    </button>
                </form>
            </div>

        </div>
    </div>
   

</div>

</div>
@endsection
@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submit_btn').on('click', function(e){
            e.preventDefault();
            $('#submit_btn').attr("disabled", true);
            $('#box_form').submit();
        });
        $('.delete').on('click', function(e){
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to request the deletion of this email box.",
                icon: "warning",
                dangerMode: true,
                buttons: [true, 'DELETE'],
            })
            .then(willDelete => {
                if (willDelete) {
                    var url = $(this).data('url');
                    var id = $(this).data('id');
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(result) {
                            window.location.reload(true);
                        }
                    });
                }
            });
        });
    });
</script>
@endsection