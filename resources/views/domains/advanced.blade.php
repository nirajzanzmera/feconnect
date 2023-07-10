@extends('layouts.app')

@section('css')
<style>
.swal-modal {
  /*   background-color: #fceaea;
    border-color: #fceaea; */
}
.swal-text, .swal-title {
    color: #bf1c19;
}
.swal-icon--warning__body, .swal-icon--warning__dot {
    background-color: #bf1c19;
}
</style>
@endsection


@section('content')
@include('domains._nav')
<div class="row-fluid" id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $domain->domain }} - Advanced
                </h4>
            </div>
            <div class="card-block">
                    @include('domains._settings_nav')


                    @if(auth()->user()->admin ==1)
                    <em>ADMIN ONLY</em>
                    <div id="nameservers">
                        <legend>Name Servers</legend>
                        <div class="alert alert-info">
                            <i class="fa fa-exclamation-triangle"></i>
                            Making changes to your domains nameservers will break your websites, emails, and other internet links currently using your domain. If you
                            are not sure if you want to do this, please contact us for help.
                        </div>
                        <a href="" v-if="edit == false" v-on:click.prevent="editServers()">Edit Nameservers</a>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="(nameserver, index) in nameservers">
                                <div v-if="edit == true">

                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="nameservers[index]">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="button" v-on:click.prevent="deleteServer(index)">Delete</button>
                                        </span>
                                    </div>

                                </div>
                                <div v-if="edit == false">
                                @{{ nameserver }}
                                </div>
                            </li>
                            <li class="list-group-item" v-if="edit == true">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="add_nameserver" placeholder="ns1.example.com">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button" v-on:click.prevent="addServer(this.add_nameserver)">
                                            <i class="fa fa-plus"></i>
                                            Add
                                        </button>
                                    </span>
                                </div>
                            </li>
                        </ul>

                        <div class="btn-group" v-if="edit == true">
                            <a href="#" class="btn btn-primary" v-on:click.prevent="update()">
                                Update
                            </a>
                            <a href="#" class="btn btn-default" v-on:click.prevent="cancel()">
                                <i class="fa fa-times"></i>
                                Cancel 
                            </a>
                        </div>

                    </div>

                    <hr>
                    @endif


                    <legend>
                        Delete Domain : {{ $domain->domain }} 
                    </legend>
                    

                    <div class="alert alert-info">
                        <i class="fa fa-exclamation-triangle"></i>
                        Deleting your domain will break your websites, emails, and other internet links currently using your domain. If you
                        are not sure if you want to do this, please contact us for help.
                    </div>

                    <div class="row form-group">

                            <form action="{{ route('domains.destroy', $domain) }}" method="POST" id="cancel_form">
                                {{ method_field('DELETE') }}
                                {!! csrf_field() !!}
                            </form>

                            

                            <button id="delete" class="btn btn-danger">Delete ...</buttom>
                    
                        </div>
                    </div>
                   
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

@if(auth()->user()->admin == 1)
<script>var nameservers_url = '{{ route('domains.nameservers.index', $domain) }}';</script>
<script src="{{ mix('/stuff/nameservers.js') }}"></script>
@endif

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
    
        $('#delete').on('click', function(e){
            e.preventDefault();

        swal({
            title: "Are you sure? You can never get it back.",
            text: "Are you sure you want to delete your domain {{ $domain->domain }}? Deleting your domain is irreversible and will prevent you from using your website and any emails that use your domain. You will not be able to get it back.",
            icon: "warning",
            dangerMode: true,
            buttons: ['Keep My Domain', 'DELETE'],
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