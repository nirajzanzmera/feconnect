@extends('fe.layouts.app')
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    label {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div>
    <h1 class="page-heading">
        Settings
    </h1>
</div>
{{-- <ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
<li class="active">Email Blasts</li>
</ol> --}}
@include('campaigns._nav')
@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div id="app" class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Senders</h4>
                        <p class="card-subtitle">
                            These are the details that will appear to the recipient of your email blast.
                        </p>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-success btn-sm pull-right" href="#" v-if="create_form==false"
                            @click.prevent="create_form = true">
                            <i class="fa fa-plus"></i> Create sender
                        </a>
                        <a class="btn btn-default btn-sm pull-right" href="#" v-if="create_form==true"
                            @click.prevent="create_form = false" v-cloak>
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-block" v-if="!records.length">
                <div class="alert alert-info">
                    <i class="fa fa-info" style="padding: 15px;"></i>
                    Email blasts are required to include your contact information. Please Create a sender template to
                    make it easier to include at the bottom of your emails.
                </div>
            </div>
            <div class="card-block card-block-light" style="margin: 0px 0.625rem 0.625rem; padding: 0px;">
                <ul class="list-group">

                    <li class="list-group-item row" v-cloak v-if="create_form == true">
                        <div class="card">
                            <div class="card-header">
                                Add New Sender
                            </div>
                            <div class="card-block">
                                <form action="{{ route('senders.store') }}" method="POST">
                                    {{ csrf_field() }}
                                    @include('fe.campaigns.senders._form2', ['namespace'=>'create_data',
                                    'error_namespace'=>'create_data'])
                                    <a @click.prevent="create()" href="#" class="btn btn-success">
                                        <i class="fa fa-plus"></i> Add Sender
                                    </a>
                                    <a class="btn btn-default " href="#" v-if="create_form==true"
                                        @click.prevent="create_form = false" v-cloak>
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </form>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item row" style="background: lightgray none repeat scroll 0% 0%;">
                        <strong>Current Senders</strong>
                    </li>


                    <li class="list-group-item row hidden-md-down">
                        <div class="col-lg-5">
                            <strong>Send From:</strong></div>
                        <div class="col-lg-5">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-lg-2"></div>
                    </li>
                    <li class="list-group-item row" v-for="sender in records" v-cloak>
                        <div class="col-lg-5">
                            <label class="hidden-lg-up">Send From:</label>
                            <i class="fa fa-envelope-o"></i>
                            @{{ sender.email }}
                        </div>
                        <div class="col-lg-4">
                            <label class="hidden-lg-up">Status:</label>
                            @{{ sender.status }}
                        </div>
                        <div class="col-lg-3">
                            <template v-if="editing.id === sender.id">
                                <a href="#" @click="cancel()" class="btn btn-sm btn-default">
                                    <i class="fa fa-times"></i>
                                    Cancel
                                </a>
                            </template>
                            <template v-else>
                                <div class="btn-group">
                                    <a @click.prevent="sendConf(sender)" v-if="sender.status === 'pending'" href="#"
                                        class="btn btn-sm btn-info" title="Re-Send Confirmation Email">
                                        <template v-if="senderConf.id === sender.id && senderConf.status !== 'done'">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </template>
                                        <template v-else>
                                            <i class="fa fa-send"></i>
                                        </template>
                                        Send Conf
                                    </a>
                                    <a @click.prevent="edit(sender)" href="#" class="btn btn-sm btn-primary"
                                        title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                </div>
                                <div class="alert alert-info"
                                    v-if="senderConf.id === sender.id && senderConf.msg.length">
                                    @{{ senderConf.msg }}
                                    <button type="button" class="close" aria-label="Close" @click="senderConf.id = 0">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <div class="col-md-12">
                            <template v-if="editing.id !== sender.id">
                                <span v-if="sender.address !== ''">
                                    @{{ sender.address }} <br />
                                </span>
                                <span v-if="sender.address_2 !== ''">
                                    @{{ sender.address_2 }} <br />
                                </span>
                                <span v-if="sender.city !== ''">
                                    @{{ sender.city }}, @{{ sender.state }} @{{ sender.zip }} <br />
                                    @{{ sender.country }}
                                </span>
                            </template>
                            <template v-else>

                                @include('fe.campaigns.senders._form2', ['namespace'=>'editing.form', 'error_namespace'=>'editing'])

                                <div class="btn-group pull-right">
                                    <a href="#" @click.prevent="update()" class="btn btn-sm btn-primary">Update</a>
                                    <a href="#" @click.prevent="deleteModal(sender)"
                                        class="btn btn-sm btn-danger">Delete...</a>
                                    <a href="#" @click="cancel()" class="btn btn-sm btn-default">
                                        <i class="fa fa-times"></i>
                                        Cancel
                                    </a>
                                </div>
                            </template>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<link rel="stylesheet" type="text/css"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Access-Control-Allow-Origin': '*'
            }
        });
    });

    function sendconf(id){
        $.ajax(
        {url: "{{ url('emails/sendConf/') }}"+'/'+id,
            success: function(result)
            {
                document.getElementById(id).innerHTML = result+'<button type="button" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>';
                document.getElementById(id).style.display = 'block';
            }}
        );
    }
</script>
<script>
    var app = new Vue({
        el: '#app',
        data () {
            return {
                create_form: false,
                create_data: {
                    errors:{}
                },
                message: '',
                records: [],
                editing: {
                    id: null, 
                    form: {},
                    errors: [],
                },
                senderConf: {
                    id: null,
                    status: 'done',
                    msg: '',
                }
            }
        },
        methods: {
            create() {
                axios.post('{{ route('senders.store') }}', this.create_data).then(() => {
                    this.getRecords().then(() => {
                        this.create_form = false;
                        this.editing.id = null;
                        this.create_data = {errors:{}};
                    });
                }).catch((error) => {
                    if(error.response.status === 422) {
                        this.create_data.errors = error.response.data.errors;
                    }
                });
            },
            sendConf(sender) {
                this.senderConf.status = 'sending';
                this.senderConf.id = sender.id;
                return axios.get('{{ url('emails/sendConf/') }}/'+sender.id).then((response) => {
                    this.senderConf.status = 'done';
                    this.response = response.data;
                    this.senderConf.msg = response.data.msg;
                });
            },
            getRecords() {
                return axios.get('{{ route('senders.list') }}').then((response) => {
                    this.response = response.data;
                    this.records = this.response;
                });
            },
            edit(url) {
                this.editing.errors = []
                this.editing.id = url.id
                this.editing.form = url
            },
            cancel() {
                this.editing.errors = []
                this.editing.id = null
                this.editing.form = {}
            },
            deleteModal(sender) {
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to DELETE: " + sender.email,
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'DELETE'],
                })
                .then(willDelete => {
                    if (willDelete) {
                        axios.delete('{{ route('senders.destroy') }}/'+sender.id, this.editing.form).then(() => {
                            this.getRecords().then(() => {
                                this.editing.id = null
                                this.editing.form = {}                    
                            });
                        }).catch((error) => {
                            if(error.response.status === 422) {
                                this.editing.errors = error.response.data.errors
                            }
                        });
                    }
                });
            },
            update() {
                axios.patch('{{ route('senders.update') }}/' + this.editing.id, this.editing.form).then(() => {
                    this.getRecords().then(() => {
                        this.editing.id = null
                        this.editing.form = {}                    
                    });
                }).catch((error) => {
                    if(error.response.status === 422) {
                        this.editing.errors = error.response.data.errors
                    }
                });
            },
        },
        mounted() {
        this.getRecords();
        },
    })
</script>
@endsection
