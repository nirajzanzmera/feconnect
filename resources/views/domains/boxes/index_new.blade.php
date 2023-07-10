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

<style>
    label {
        font-weight: bold;
    }
</style>
<div class="row-fluid">
    <div class="col-md-12" id="app">
        @if($custom != true)
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Emails: <span class="text-primary">{{ $domain->domain }}</span>
                            {{-- {{ $domain->email_provider }} --}}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light" style="margin: 0px 0.625rem 0.625rem; padding: 0px;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-md-down">
                        <div class="col-lg-5"><strong>Email User:</strong></div>
                        <div class="col-lg-5"><strong>Forwards To:</strong></div>
                        <div class="col-lg-2"></div>
                    </li>
                    @if(!empty($boxes))
                    @foreach($boxes as $box)
                    <li class="list-group-item row">

                            <div class="col-md-5">
                                <label class="hidden-lg-up">Email:</label>
                                {{ $box->mailbox }}{{ '@' . $domain->domain }}
                            </div>
                            <div class="col-lg-5">
                                <strong>Email Box</strong>
                                <a class="btn btn-xs q-mark " tabindex="0" data-toggle="popover" data-placement="bottom"
                                    title="How do I use my email box?" data-content="
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
                            </div>
                            <div class="col-md-2">
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
                    @endif
                    <li class="list-group-item row" v-for="email in forwards">
 
                            <div class="col-lg-5">
                                <label class="hidden-lg-up">Email User:</label>
                                @{{ email.email_box }}{{ '@'.$domain->domain }}
                            </div>
                            <div class="col-lg-5">
                                <label class="hidden-lg-up">Forwards To:</label>
                                @{{ email.email_to }}
                                <template v-if="editing.id === email.id">
                                    <br />
                                    <label for="">Change To:</label>
                                    <emails-drop :options="emails" :errors="editing.errors" v-model="email.formData"></emails-drop>
                                </template>

                            </div>

                            <div class="col-lg-2">
                                <template v-if="editing.id === email.id">

                                    <div id="_btns" class="btn-group pull-right" style="padding-top:10px;">
                                        <template
                                            v-if="email.formData !== undefined && email.formData.selected == 'new_email' &&
                                        (email.formData.password !== email.formData.password2 || email.formData.password === '')">
                                            <a href="#" class="btn btn-sm btn-primary disabled">Update</a>
                                        </template>
                                        <template v-else>
                                            <a href="#" @click.prevent="update(email)"
                                                class="btn btn-sm btn-primary">Update</a>
                                        </template>
                                        <a href="#" @click.prevent="deleteModal(email)"
                                            class="btn btn-sm btn-danger">Delete...</a>
                                        <a href="#" @click.prevent="cancel()" class="btn btn-sm btn-default">Cancel</a>
                                    </div>
                                </template>
                                <template v-else>
                                    <a href="#" @click.prevent="edit(email)"
                                        class="edit btn btn-sm btn-primary pull-right">edit</a>
                                </template>
                            </div>
                    </li>
                </ul>
            </div>
        </div> <!-- end emails card -->

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

                <div class="row">
                        <div class="col-xl-5 form-group" v-bind:class="{ 'text-danger': editing.errors.email_box !== undefined || editing.errors.mailbox !== undefined || 
                        editing.errors.emailbox_dupe !== undefined }">
                            <label for="email_box">Email User:</label>
                            <input type="text" v-model="new_user" name="new_user" class="form-control" placeholder="email user">
                            <small class="form-text text-muted">
                                {{ '@'.$domain->domain }}
                            </small>
                            <span class="help-block" v-if="editing.errors.email_box !== undefined || editing.errors.mailbox !== undefined || editing.errors.emailbox_dupe !== undefined">
                                <strong>@{{ editing.errors.email_box !== undefined || editing.errors.mailbox !== undefined ? 'The email user may only contain letters, numbers, and dashes' : '' }}</strong>
                                <strong>@{{ editing.errors.emailbox_dupe !== undefined ? editing.errors.emailbox_dupe[0] : '' }}</strong>
                            </span>
                        </div>
                        <div class="col-xl-5 form-group">
                            <label for="email_to">Forwards To</label>
                            <emails-drop :options="emails" :errors="editing.errors" v-model="create_email"></emails-drop>
                        </div>
                        <div class="col-xl-2">
                            <br />

                            <template
                                v-if="create_email.selected !== undefined && create_email.selected == 'new_email' &&
                                      (create_email.password !== create_email.password2 || create_email.password === '')">
                                <a href="#" class="btn btn-sm btn-success disabled"><i class="fa fa-plus"></i> Add
                                    Email</a>
                            </template>
                            <template v-else>
                                <a href="#" @click.prevent="addEmail()" class="btn btn-sm btn-success" dusk="add-email"><i
                                        class="fa fa-plus"></i> Add Email</a>
                            </template>

                        </div>
                    
                    <br />
                </div>{{-- end row --}}
                @endif
            </div>
        </div>{{-- end card --}}
        @endif
    </div>
    @endsection

    @section('js')
    <script>
        var data_url = '{{ route('domains.emails.data', $domain->id) }}';
    </script>
    <script src="{{ mix('/stuff/emails.js') }}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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