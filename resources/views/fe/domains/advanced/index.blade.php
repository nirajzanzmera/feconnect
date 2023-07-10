@extends('fe.layouts.app')

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

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $domain->domain }}
                </h4>
            </div>
            <div class="card-block">
                @include('domains.partials._advanced_nav')

                <div id="nameservers" v-cloak>
                    <legend>Name Servers</legend>
                    <div class="alert alert-info">
                        <i class="fa fa-exclamation-triangle"></i>
                        Making changes to your domains nameservers will break your websites, emails, and other internet
                        links currently using your domain. If you are not sure if you want to do this, please contact us for help.
                    </div>

                    <div class="card-block">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Select DNS</label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" v-model="dns_template">
                                    <option value="dataczar">Dataczar DNS</option>
                                    <option value="other">Other...</option>
                                </select>
                            </div>
                            <div class="col-md-2" v-if="dns_template == 'dataczar' && custom == true" v-cloak> 
                                <button class="btn btn-danger" v-on:click.prevent="UpdateDNS()">
                                    Update DNS
                                    <span v-if="dns_template == 'dataczar' && working == true">
                                        <i class="fa fa-spinner fa-pulse"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-if="show_edit == true" v-cloak>
                        <a href="" v-if="edit == false" v-on:click.prevent="editServers()">Edit Nameservers</a>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="(nameserver, index) in nameservers">
                                <div v-if="edit == true">

                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="nameservers[index]">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="button"
                                                v-on:click.prevent="deleteServer(index)">Delete</button>
                                        </span>
                                    </div>

                                </div>
                                <div v-if="edit == false">
                                    @{{ nameserver }}
                                </div>
                            </li>
                            <li class="list-group-item" v-if="edit == true">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="add_nameserver"
                                        placeholder="ns1.example.com">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button"
                                            v-on:click.prevent="addServer(this.add_nameserver)">
                                            <i class="fa fa-plus"></i>
                                            Add
                                        </button>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group" v-if="edit == true">
                        <a href="#" class="btn btn-primary" v-on:click.prevent="update()">
                            Update
                            <span v-if="dns_template == 'other' && working == true">
                                <i class="fa fa-spinner fa-pulse"></i>
                            </span>
                        </a>
                        <a href="#" class="btn btn-default" v-on:click.prevent="cancel()">
                            <i class="fa fa-times"></i>
                            Cancel
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script>
    var nameservers_url = '{{ route('domains.nameservers.index', $domain->id) }}';
</script>
<script src="{{ mix('/stuff/nameservers.js') }}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
    
        $('#delete').on('click', function(e){
            e.preventDefault();

        swal({
            title: "Are you sure? You can never get it back.",
            text: "Are you sure you want to delete your domain {{ $domain->domain }}? Deleting your domain is irreversible and will prevent you from using your website and any emails that use your domain. It also will allow someone else to register your domain and use it for their website. You will not be able to get it back.",
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