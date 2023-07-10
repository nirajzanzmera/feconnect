@extends('fe.layouts.app')
@section('content')

@if( strpos(Route::currentRouteName(), "new")  === 0 )
    @include('domains.partials._nav')
@else 
    @include('domains._nav')
@endif

<style>
    label {
        font-weight: bold;
    }
</style>

<div class="row-fluid">
    <div class="col-md-12">
        
        @if(!$custom)
        <div class="card" id="app">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Emails: <span class="text-primary">{{ $domain->domain }}</span>
                            {{-- {{ $domain->email_provider }} --}}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                @if($custom)
                    <div class="alert alert-info">
                        Your domain is using custom DNS email records (MX). <br />
                        Please contact support if you would like to remove the custom records.
                    </div>
                @else 

                <ul class="list-group">
                    <li class="list-group-item row hidden-md-down">
                        <div class="col-lg-5"><strong>Email User:</strong></div>
                        <div class="col-lg-5"><strong>Forwards To:</strong></div>
                        <div class="col-lg-2"></div>
                    </li>
                    @foreach($boxes as $box)
                        <li class="list-group-item row">
                            <div class="col-lg-5">
                                <label class="hidden-lg-up">Email:</label> 
                                {{ $box->mailbox }}{{ '@' . $domain->domain }}
                            </div>
                            <div class="col-lg-5">
                                <strong>Email Box</strong>
                                    <a class="btn btn-xs q-mark " tabindex="0" data-toggle="popover" data-placement="bottom" 
                                        title="How do I use my email box?" 
                                        data-content="
                                            <P>
                                                You can connect to your Dataczar email box at mail.dataczar.com via the IMAP, POP, SMTP protocols, 
                                                or via the web at <a href='https://mail.dataczar.com' target='_blank'>https://mail.dataczar.com</a>. 
                                            </P>
                                            <P>
                                                You can also use your email on your computer, phone or tablet. 
                                                <a href='https://help.dataczar.com/40277/configuring-your-email-client/index.html' target='_blank'>
                                                    Click here for instructions for some popular email clients.
                                                </a>
                                            </P>
                                        ">
                                        <i class="fa fa-btn fa-question-circle"></i>
                                    </a>
                                    <br />
                                {{--
                                <strong>Aliases:</strong> {{ $box->aliases }}<br />
                                <strong>Status:</strong> {{ $box->provider_status }} {{ $box->status }}
                                --}}
                            </div>
                            <div class="col-lg-2">
                                <div class="btn-group pull-right">
                                    <a href="https://mail.dataczar.com" title="Webmail" target="_blank" class="btn btn-sm btn-info "><i class="fa fa-envelope"></i>
                                    </a> 
                                    <div class="btn-group"><div class="dropdown show">
                                        <a href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-sm btn-default dropdown-toggle">
                                            <i class="fa fa-bars"></i>
                                        </a> 
                                        <div aria-labelledby="dropdownMenuLink" class="dropdown-menu dropdown-menu-right">
                                            <a href="https://mail.dataczar.com" title="Webmail" target="_blank" class="dropdown-item ">
                                                <i class="fa fa-envelope"></i>
                                                Webmail
                                            </a> 
                                            <a href="{{route('domains.change_password', ['domain' => $domain->id, 'email'=> $box->id])}}" title="Reset Password" class="dropdown-item ">
                                                <i class="fa fa-refresh"></i>
                                                Reset Password
                                            </a> 
                                            <a href="" title="Request Delete..." data-url="{{route('domains.delete', ['domain' => $domain->id, 'email'=> $box->id])}}" data-id="{{$box->id}}" class="dropdown-item delete">
                                                <i class="fa fa-trash-o"></i>
                                                Request Delete...
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {{-- @rowmenu(['items' => $box->btns])@endrowmenu --}}
                            </div>
                        </li>
                    @endforeach
                    <li class="list-group-item row" v-for="email in records">
                        <div class="col-lg-5">
                            <label class="hidden-lg-up">Email User:</label>
                            <template>
                                @{{ email.email_box }}{{ '@'.$domain->domain }}
                            </template>
                        </div>
                        <div class="col-lg-5 form-group">
                            <label class="hidden-lg-up">Forwards To: </label>
                            <template v-if="editing.id === email.id">
                                <label>Current: </label>
                                @{{ email.email_to }}
                                <div class="form-group" id="change_to_select">
                                    <label for="new_email_select_item">Change To: </label>
                                    <select style="margin-bottom: 10px;" name="new_email_select_item" class="form-control" onchange="
                                        if(value=='new_email'){
                                            document.getElementById('new_email_pwd_block_item').classList.remove('hide');
                                            document.getElementById('other_email_fwd_item').classList.add('hide');
                                        } else if(value=='other') {
                                            document.getElementById('new_email_pwd_block_item').classList.add('hide');
                                            document.getElementById('other_email_fwd_item').classList.remove('hide');
                                        } else {
                                            document.getElementById('new_email_pwd_block_item').classList.add('hide');
                                            document.getElementById('other_email_fwd_item').classList.add('hide');
                                        }">
                                        <option selected value='unselected'></option>
                                        <option>Email Box: test1@test.com</option>
                                        <option>User: Test User</option>
                                        <option>Forward: test1@gmail.com</option>
                                        <option value='new_email'>New Email Box...</option>
                                        <option value='other'>Other email</option>
                                    </select>
                                </div>
                                <div  class="form-group hide" id='new_email_pwd_block_item'>
                                    <label for="password" >Enter the password for your new email box:</label>
                                    <input type="password" class="form-control" id="pwd1" name="password" placeholder="enter password">
                                    {{--<i class="fa fa-check btn-success pull-right"></i>                          
                                    <i class="fa fa-exclamation-triangle btn-danger pull-right"></i>--}}
                                    <label for="password_confirm">Confirm Password:</label>
                                    <input type="password" class="form-control" id="pwd2" name="password_confirm" placeholder="enter password again">
                                </div>
                                <div class="form-group hide" id='other_email_fwd_item'>
                                    <label for="email_to">Forward to this email:</label>
                                    <input type="text" class="form-control" id="email_to" name="email_to" placeholder="your@email.com">
                                </div>

                                <input class="form-control" type="hidden" name="emailTo" v-model="email.email_to">
                            </template>
                            <template v-else>
                                @{{ email.email_to }}
                            </template>
                        </div>

                        <div class="col-lg-2 pull-right">
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
                @endif
            </div>
        </div> <!-- end col-md-6 -->
        @endif

        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Create Email</h4>
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
                <form action="{{ route('domains.forwards.store', $domain->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 col-xl-5">
                            <label for="email_box">Email User</label>

                            <input type="text" name="email_box" class="form-control" placeholder="email user">
                            <small class="form-text text-muted">
                                {{ '@'.$domain->domain }}
                            </small>

                        </div>
                        <div class="col-md-12 col-xl-5 form-group">
                            <label for="new_email_select">Forwards To</label>
                            <select style="margin-bottom: 10px;" name="new_email_select" class="form-control" onchange="
                                if(value=='new_email'){
                                    document.getElementById('new_email_pwd_block').classList.remove('hide');
                                    document.getElementById('other_email_fwd').classList.add('hide');
                                } else if(value=='other') {
                                    document.getElementById('new_email_pwd_block').classList.add('hide');
                                    document.getElementById('other_email_fwd').classList.remove('hide');
                                } else {
                                    document.getElementById('new_email_pwd_block').classList.add('hide');
                                    document.getElementById('other_email_fwd').classList.add('hide');
                                }">
                                <option selected value='unselected'></option>
                                <option>Email Box: test1@test.com</option>
                                <option>User: Test User</option>
                                <option>Forward: test1@gmail.com</option>
                                <option value='new_email'>New Email Box...</option>
                                <option value='other'>Other email</option>
                            </select>
                            <div  class="form-group hide" id='new_email_pwd_block'>
                                <label for="password" >Enter the password for your new email box:</label>
                                <input type="password" class="form-control" id="pwd1" name="password" placeholder="enter password">
                                {{--<i class="fa fa-check btn-success pull-right"></i>                          
                                <i class="fa fa-exclamation-triangle btn-danger pull-right"></i>--}}
                                <label for="password_confirm">Confirm Password:</label>
                                <input type="password" class="form-control" id="pwd2" name="password_confirm" placeholder="enter password again">
                            </div>
                            <div class="form-group hide" id='other_email_fwd'>
                                <label for="email_to">Forward to this email:</label>
                                <input type="text" class="form-control" id="email_to" name="email_to" placeholder="your@email.com">
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <br />
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                Add Email
                            </button>
                        </div>
                    </div>{{-- end row --}}
                </form>
                @endif
            </div>
        </div>{{-- end card --}}

    </div>
    @endsection

    @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>

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
            return axios.get('{{ route('domains.forwards.list', $domain->id) }}').then((response) => {
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
                    axios.delete('{{ route('domains.forwards.delete', $domain->id) }}/'+email.id, this.editing.form).then(() => {
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
            axios.patch('{{ route('domains.forwards.update', $domain->id) }}', this.editing.form).then(() => {
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
});
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            trigger: 'focus', 
            html: true,
        });

        $('.copy').on('click', function(e) {
            e.preventDefault();
            var link = $(this).data('link');
            clipboard.writeText(link);
            alert('Copied to Clipboard');
        });

    });
    </script>
    @endsection
