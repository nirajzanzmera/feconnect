@extends('layouts.app')
@section('content')

@include('domains.partials._nav')

<style>
    label {
        font-weight: bold;
    }
</style>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Create Email Forward</h4>
                    </div>
                </div>
            </div>
            <div class="card-block">
                @if($custom)

                    <div class="alert alert-info">
                        Your domain is using custom DNS email records (MX). <br />
                        Please contact support if you would like to remove the custom records.
                    </div>

                @else 
                <form action="{{ route('domains.forwards.store', $domain) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 col-xl-5{{ $errors->has('email_box') ? ' has-error' : '' }}">
                            <label for="email_box">Email User</label>

                            <input type="text" name="email_box" class="form-control" placeholder="email user">
                            <small class="form-text text-muted">
                                {{ '@'.$domain->domain }}
                            </small>
                            @if ($errors->has('email_box'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email_box') }}</strong>
                            </span>
                            @endif

                        </div>
                        <div class="col-md-12 col-xl-5 form-group {{ $errors->has('email_to') ? ' has-error' : '' }}">
                            <label for="email_to">Forwards To</label>
                            <input type="text" class="form-control" name="email_to" placeholder="your@email.com" value="{{ old('email_to') }}">
                            @if ($errors->has('email_to'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email_to') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <br />
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                Add Forward
                            </button>
                        </div>
                    </div>{{-- end row --}}
                </form>
                @endif
            </div>
        </div>{{-- end card --}}

        @if(!$custom)
        <div class="card" id="app">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Email Forwards: <span class="text-primary">{{ $domain->domain }}</span>
                            {{-- {{ $domain->email_provider }} --}}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-md-down">
                        <div class="col-lg-5"><strong>Email User:</strong></div>
                        <div class="col-lg-5"><strong>Forwards To:</strong></div>
                        <div class="col-lg-2"></div>
                    </li>
                    <li class="list-group-item row" v-for="email in records">
                        <div class="col-lg-5">
                            <label class="hidden-lg-up">Email User:</label>
                                @{{ email.email_box }}{{ '@'.$domain->domain }}
                        </div>
                        <div class="col-lg-3">
                            <label class="hidden-lg-up">Forwards To:</label>
                            <template v-if="editing.id === email.id">
                                <input class="form-control" type="text" name="emailTo" v-model="email.email_to">
                            </template>
                            <template v-else>
                                @{{ email.email_to }}
                            </template>
                        </div>

                        <div class="col-lg-3">
                            <template v-if="editing.id === email.id">
                                <div id="_btns" class="btn-group" style="padding-top:10px;">
                                    <a href="#" @click.prevent="update()" class="btn btn-sm btn-primary">Update</a>
                                    <a href="#" @click.prevent="deleteModal(email)"
                                        class="btn btn-sm btn-danger">Delete...</a>
                                    <a href="#" @click.prevent="cancel()" class="btn btn-sm btn-default">Cancel</a>
                                </div>
                            </template>
                            <template v-else>
                                <a href="#" @click.prevent="edit(email)"
                                    class="edit btn btn-sm btn-primary">edit</a>
                            </template>
                        </div>
                    </li>
                </ul>
            </div>
        </div> <!-- end col-md-6 -->
        @endif
    </div>
    @endsection

    @section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var app = new Vue({
    el: '#app',
    data () {
        return {
            message: 'Hello Vue!',
            records: [],
            editing: {
                id: null, 
                form: {},
                errors: []
            },
        }
    },
    methods: {
        getRecords() {
            return axios.get('{{ route('domains.forwards.list', $domain) }}').then((response) => {
                this.response = response.data;
                this.records = this.response;
            });
        },
        edit(email) {
            this.editing.errors = []
            this.editing.id = email.id
            this.editing.form = email
        },
        cancel() {
            this.editing.errors = []
            this.editing.id = null
            this.editing.form = {}
        },
        deleteModal(email) {
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to DELETE: \n" + email.email_box + '@' + '{{ $domain->domain }} > ' +  email.email_to ,
                icon: "warning",
                dangerMode: true,
                buttons: [true, 'DELETE'],
            })
            .then(willDelete => {
                if (willDelete) {
                    axios.delete('{{ route('domains.forwards.delete', $domain) }}/'+email.id, this.editing.form).then(() => {
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
            axios.patch('{{ route('domains.forwards.update', $domain) }}', this.editing.form).then(() => {
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
