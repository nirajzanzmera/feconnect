@extends('layouts.app')
@section('content')
@include('domains._nav')
<style>
    label {
        font-weight: bold;
    }

    [v-cloak] {
        display: none;
    }

    .has-error input {
        border-color: red;
    }
</style>
<div id="app">


    <div class="card">
        <div class="card-header">
            <div class="media">
                <div class="media-body">
                    <h4 class="card-title">Domain URL Forwarding</h4>
                </div>
                <div class="media-right media-middle">
                    <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left"
                        data-original-title="Domain URL Forwarding" data-content="
                                <strong>Host</strong><br />
                                This can be a wildcard (*) or the specific subdomain you wish to forward. Example: test.original.com. Usually, you want to leave this blank, in which case it will forward both the bare and all subdomains. <br />
                                <br />
                                <strong>Forwards To</strong><br />
                                This is the destination you'd like to forward traffic to for the specific subdomain. We've placed the https:// specifier in the field for you by default, but you should make sure this is present for your URL forward to function properly.<br />
                               ">
                        <i class="fa fa-btn fa-question-circle"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-block">
            <form action="{{ route('domains.urls.store', $domain) }}" method="POST" ref="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-sm-12 col-lg-5">
                        <strong>Host:</strong><br />
                        <div class="form-group {{ $errors->has('host') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <input type="text" name="host" class="form-control"
                                    placeholder="leave blank for wildcard">
                                <span class="input-group-addon">
                                    {{ '.'.$domain->domain }}
                                </span>
                            </div>
                            @if ($errors->has('host'))
                            <span class="help-block">
                                <strong>{{ $errors->first('host') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-5">
                        <strong>Forwards To:</strong><br />
                        <div class="form-group {{ $errors->has('forwards_to') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="forwards_to" value="https://">
                            @if ($errors->has('forwards_to'))
                            <span class="help-block">
                                <strong>{{ $errors->first('forwards_to') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-2">
                        <br />
                        <a @click.prevent="createForward()" class="btn btn-success">
                            <i class="fa fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="media">
                <div class="media-body">
                    <h4 class="card-title">Existing</h4>
                </div>
            </div>
        </div>
        <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
            <ul class="list-group">
                <li class="list-group-item row hidden-md-down">
                    <div class="col-lg-5"><strong>Host:</strong></div>
                    <div class="col-lg-5"><strong>Forwards To:</strong></div>
                    {{--<div class="col-lg-3"><strong>Type:</strong></div>--}}
                    <div class="col-lg-2"></div>
                </li>
                <li class="list-group-item row" v-for="url in records">
                    <div class="col-lg-5">
                        <label class="hidden-lg-up">Host:</label>
                        @{{ url.host }}{{ '.'.$domain->domain }}
                    </div>
                    <div class="col-lg-3">
                        <label class="hidden-lg-up">Forwards To:</label>
                        <template v-if="editing.id === url.id">
                            <input class="form-control" type="text" name="forwards_to" v-model="url.forwards_to">
                        </template>
                        <template v-else>
                            @{{ url.forwards_to }}
                        </template>
                    </div>

                    <div class="col-lg-3">
                        <template v-if="editing.id === url.id">
                            <div id="_btns" class="btn-group" style="padding-top:10px;">
                                <a href="#" @click.prevent="update()" class="btn btn-sm btn-primary">Update</a>
                                <a href="#" @click.prevent="deleteModal(url)"
                                    class="btn btn-sm btn-danger">Delete...</a>
                                <a href="#" @click.prevent="cancel()" class="btn btn-sm btn-default">Cancel</a>
                            </div>
                        </template>
                        <template v-else>
                            <a href="#" @click.prevent="edit(url)" class="edit btn btn-sm btn-primary">edit</a>
                        </template>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@section('js')
@include('layouts.partials._popover')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    var app = new Vue({
    el: '#app',
    data () {
        return {
            extra: 'redirect',
            message: '',
            records: [],
            editing: {
                id: null, 
                form: {},
                errors: []
            },
        }
    },
    methods: {
        createForward() {
            swal({
                title: "Are you sure?",
                text: "Adding a domain forward will unlink domain from your website \n",
                icon: "warning",
                dangerMode: true,
                buttons: [true, 'Create'],
            })
            .then(willCreate => {
                if (willCreate) {
                    this.$refs.form.submit();
                }
            });
        },
        getRecords() {
            return axios.get('{{ route('domains.urls.list', $domain) }}').then((response) => {
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
        deleteModal(url) {
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to DELETE: \n" + url.host + '.' + '{{ $domain->domain }} > ' +  url.forwards_to ,
                icon: "warning",
                dangerMode: true,
                buttons: [true, 'DELETE'],
            })
            .then(willDelete => {
                if (willDelete) {
                    axios.delete('{{ route('domains.urls.delete', $domain) }}/'+url.id, this.editing.form).then(() => {
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
            axios.patch('{{ route('domains.urls.update', $domain) }}', this.editing.form).then(() => {
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
