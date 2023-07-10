@extends('layouts.app')
@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Cancel Subscription</h1>
</div>
@endif
@include('subscription._nav')
<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Cancel</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">


                    </div>
                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('plans.cancel_confirm') }}" method="GET" id="cancel_form">

                    <p>Please confirm Subscription Cancellation</p>
                    <button class="btn btn-primary" type="submit" id="cancel">Cancel</button>
                </form>

            </div>


        </div>
    </div>
</div>

@endsection


@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
    
        $('#cancel').on('click', function(e){
            e.preventDefault();

        swal({
            title: "Are you sure?",
            text: "Are you sure you want to lose access to: {{ auth()->user()->currentTeam->display_name }}",
            icon: "warning",
            dangerMode: true,
            buttons: [true, 'Confirm'],
        })
        .then(willCancel => {
            if (willCancel) {
                $('#cancel_form').submit()
            }
        }); 
    
       
    });
    });

</script>


@endsection
