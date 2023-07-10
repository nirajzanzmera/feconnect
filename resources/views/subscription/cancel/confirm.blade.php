@extends('layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Accounts</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('teams.index') }}">Accounts</a></li>
    <li>Cancel</li>
</ol>
@include('subscription._nav')
<div class="row-fluid">
    <div class="col-md-12">
    <div class="card py-3">
            <div class="card-block">
                <div class="mx-auto w-75 text-center">
                    <img class="w-50 mb-3" src="https://dataczar-public.s3.us-west-2.amazonaws.com/photos/675/g9c903efcf88b951c9c58118c8697b27a1035e8dce56f4f7ec35bd57f8fde03818afd9d58237b1ba074f6408b034d4690_1280.png" alt="stop">

                    <p class="font-weight-bolder mb-3 h5"><strong>WAIT! Don’t cancel your account!</strong></p>
                </div>
            </div>

            <p class="mx-3 text-justify">At Dataczar we want all of our customers to succeed.  That’s why we provide the lowest cost hosting options available.  With your account you get access to discounted domains and automatic web hosting and so much more.  Plus with our annual plan you can pay pay as little as $7.96/mo.  Don’t give up now!
            </p>

            <div class="card-block text-center">
                <a href="{{route('plans.table')}}" class="btn btn-primary btn-lg">Review all billing options</a>
            </div>
            <div class="card-block text-center">
                <a href="{{route('plans.cancel')}}" class="btn btn-default btn-lg"><i class="fa fa-arrow-left"></i> Go back</a>
            </div>
           
            <div class="card-block text-center">
                <form action="{{ route('plans.cancel') }}" method="POST" id="cancel_form">
                    {{ csrf_field() }}

                    <button class="btn btn-default" type="submit" id="cancel">Confirm Subscription Cancellation</button>
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
            title: "Last chance!",
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
