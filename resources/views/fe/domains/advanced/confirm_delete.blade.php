@extends('layouts.app')

@section('css')
<style>
    .swal-modal {
        /*   background-color: #fceaea;
    border-color: #fceaea; */
    }

    .swal-text,
    .swal-title {
        color: #bf1c19;
    }

    .swal-icon--warning__body,
    .swal-icon--warning__dot {
        background-color: #bf1c19;
    }
</style>
@endsection

@section('content')

@include('domains.partials._nav')

<div class="row-fluid" id="lock">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $domain->domain }}
                </h4>
            </div>
            <div class="card-block">

                    <legend>
                        Delete Domain : {{ $domain->domain }}
                    </legend>

                    <div class="form-group">
                        
                        <div class="card-block">
                            <div class="mx-auto w-75 text-center">
                                <img class="w-50 mb-3" src="https://dataczar-public.s3.us-west-2.amazonaws.com/photos/675/g9c903efcf88b951c9c58118c8697b27a1035e8dce56f4f7ec35bd57f8fde03818afd9d58237b1ba074f6408b034d4690_1280.png" alt="stop">
            
                                <p class="font-weight-bolder mb-3 h4"><strong>WAIT! You don’t need to delete your domain!</strong></p>
                            </div>
                        </div>
                
                        <p class="mx-3 text-justify">
                            A domain name <strong>gives your business instant credibility.</strong> It says that you mean business and helps your visitors see you as a reputable company that is conveniently accessible online.
                        </p>
                        <p class="mx-3 text-justify">
                            Domain names are like real estate: no one is making them anymore and each is unique! There’s no better way to invest in your business.
                        </p>
                        <p class="mx-3 text-justify">
                            Did you misspell your domain?  So might your customers and visitors! It pays to keep your mispellings forwarding to your preferred domain.
                        </p>
                        <p class="mx-3 text-justify">
                            If you delete your domain now, YOUR DOMAIN WILL NO LONGER BE AVAILABLE FOR REGISTRATION.
                        </p>
                        <p class="mx-3 text-justify">
                            You only pay for a domain once per year so you won’t need to pay again for another year.  Don’t give it up now! For the money, there’s no better way to secure your brand. Wait until you’ve had a chance to see what your domain does for you this year.
                        </p>
                    
                        <div class="card-block text-center">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Keep my domain for now</a>
                        </div>
                        <div class="card-block text-center">
                            <a href="{{ route('domains.advanced.lock',$domain) }}" class="btn btn-default btn-lg"><i class="fa fa-arrow-left"></i> Go back</a>
                        </div>

                        <div class="card-block text-center">

                            <form action="{{ route('domains.destroy', $domain) }}" method="POST" id="delete_form">
                                {{ method_field('DELETE') }}
                                {!! csrf_field() !!}
                            </form>

                            <button id="delete" class="btn btn-default" >Delete</buttom>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>var info_url = '{{ route('domains.advanced.info', $domain) }}';</script>
    <script type="text/javascript">
    $(document).ready(function(){
    
        $('#delete').on('click', function(e){
            e.preventDefault();

        swal({
            title: "Last chance!",
            text: "Are you sure you want to lose access to delete your domain ({{ $domain->domain }}) forever? ",
            icon: "warning",
            dangerMode: true,
            buttons: [true, 'Confirm'],
        })
        .then(willCancel => {
            if (willCancel) {
                $('#delete_form').submit()
            }
        }); 
    
       
    });
    });

</script>
@endsection