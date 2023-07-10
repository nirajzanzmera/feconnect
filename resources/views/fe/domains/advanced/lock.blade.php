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

<div class="row-fluid" id="lock">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $domain->domain }}
                </h4>
            </div>
            <div class="card-block">

                @include('domains.partials._advanced_nav')

                <legend>Domain Lock</legend>
                <div class="row form-group">
                    <div class="card-block">
                        <button class="btn btn-danger" v-on:click.prevent="toggle_advanced()" v-if="data.advanced_lock_status == true">
                            <i class="fa fa-unlock"></i> 
                            Unlock Domain
                        </button>
                        <button class="btn btn-success" v-on:click.prevent="toggle_advanced()" v-if="data.advanced_lock_status == false" v-cloak>
                            <i class="fa fa-lock"></i> 
                            Lock Domain
                        </button>
                    </div>
                </div>
                <hr>
                {{-- Locked by default. In order to edit nameservers or access any of the functions below, must unlock first. --}}
                <div v-if="data.advanced_lock_status == false" v-cloak>
                    @if(count($teams) > 1)
                    <legend>
                        Switch Account : {{ $domain->domain }}
                    </legend>
                    <div class="alert alert-info">
                        <i class="fa fa-exclamation-triangle"></i>
                        To move this domain to another Dataczar account, select which account you would like to move it
                        to.
                        Moving your domain will break your websites, emails, and other internet links currently using
                        your domain. If you
                        are not sure if you want to do this, please contact us for help.
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <select class="form-control" v-model="new_account">
                                <option selected=""></option>
                                @foreach($teams as $account)
                                    @if ($account->account_id != $team->id)
                                        <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button v-on:click.prevent="switchAccounts()" class="btn btn-danger">Move to account ...</button>
                        </div>
                    </div>
                    <hr>
                    @endif
                    <legend>
                        Obtain Auth Code
                    </legend>
                    <div class="alert alert-info" v-if="data.allow_transfer == false">
                        <i class="fa fa-exclamation-triangle"></i>
                        An Auth code cannot be issued until @{{ data.allow_transfer_date }} (60 days after registration). 
                        You can still change your nameservers and DNS records.
                    </div>

                    <div v-if="data.allow_transfer == true">
                        {{--<div class="alert alert-info">
                            <i class="fa fa-exclamation-triangle"></i>
                            Anyone with this code will be able to transfer this domain out of this account.
                        </div>--}}
                        <div class="card-block">
                            <button class="btn btn-danger" v-on:click.prevent="toggle_domain_lock()" v-if="data.transfer_locked == true">Unlock Auth Code</button>
                            <div v-if="data.transfer_locked == false" v-cloak>
                                <button class="btn btn-success" v-on:click.prevent="toggle_domain_lock()" v-cloak>Lock Auth Code</button>
                                <button class="btn btn-danger" v-on:click.prevent="request_auth_code()" v-if="data.auth_code == undefined" v-cloak>Request</button>
                                <button class="btn btn-danger disabled" v-if="data.auth_code !== undefined" v-cloak>Request Auth Code</button>
                                <div v-if="data.auth_code !== undefined" v-cloak>
                                    <strong>The auth code for this domain is: </strong>
                                    <pre>@{{ data.auth_code }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <legend>
                        Delete Domain : {{ $domain->domain }}
                    </legend>

                    <div class="alert alert-info">
                        <i class="fa fa-exclamation-triangle"></i>
                        Deleting your domain will break your websites, emails, and other internet links currently using
                        your domain. If you are not sure if you want to do this, please contact us for help.
                    </div>

                    <div class="row form-group">

                        <form action="{{ route('domains.advanced.confirm_delete', $domain->id) }}" method="GET" id="delete_form">
                        </form>

                        <button id="delete" class="btn btn-danger" v-on:click.prevent="tryDelete()">Delete ...</buttom>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
    <script>var info_url = '{{ route('domains.advanced.info', $domain->id) }}';</script>
    <script src="{{ mix('/stuff/lock.js') }}"></script>
@endsection