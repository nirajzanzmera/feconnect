@extends('fe.layouts.app')
@section('content')

@include('domains.partials._nav')

<div class="row-fluid">
    @if(!empty($custom_nameservers) && $custom_nameservers == true)
        @include('domains.partials._nswarning')
    @else
    <div class="alert alert-info">
        <em>
           Changes made here can take up to 30 minutes to complete.
        </em>
    </div>
    <div class="col-md-12">
        <div class="card" id="hosting" v-cloak>
            <div class="card-header">
                <h4 class="card-title">
                    Hosting Summary
                </h4>
            </div>
            <div class="carb-block card-block-light">
                <ul class="list-group" style="margin: .625rem;margin-top: 0;padding: 0;">
                    <li class="list-group-item row hidden-lg-down row ">
                        <div class="col-lg-4"><strong>Domain Name</strong></div>
                        <div class="col-lg-4"><strong>Website</strong></div>
                        <div class="col-lg-4"><strong></strong></div>
                    </li>

                    <li class="list-group-item row" v-for="(host, index) in hosting" v-bind:key="index">
                        <div class="col-xl-4">
                            <label class="hidden-xl-up">Domain Name:</label>
                            <div class="form-group">
                                @{{ host.domain }}
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <label class="hidden-xl-up">Website:</label>
                            <div class="form-group">
                                <div v-if="edit != index">
                                    @{{ host.destination }}
                                </div>
                                <select name="" id="" class="form-control" v-cloak v-if="edit == index" v-model="destination">
                                    <option v-for="drop in dropdown" v-bind:value="drop.value">
                                        @{{ drop.display }}
                                    </option>
                                    <option value="new_url">
                                        Redirect to a new URL
                                    </option>
                                </select>
                                <input type="text" class="form-control" v-model="url" v-if="edit == index && destination == 'new_url'" placeholder="https://">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <a href="" class="btn btn-primary" v-on:click.prevent="editDomain(index)" v-if="edit != index">
                                    <i class="fa fa-edit"></i>
                                    Edit
                                </a>
                                <div class="btn-group" v-if="edit == index">
                                    <a href="" class="btn btn-success" v-on:click.prevent="update_domain(host);" v-if="host.domain_type == 'domain'">
                                        <i class="fa fa-save"></i>
                                        Update
                                    </a>
                                    <a href="" class="btn btn-success" v-on:click.prevent="update_subdomain(host);" v-if="host.domain_type == 'subdomain'">
                                        <i class="fa fa-save"></i>
                                        Update
                                    </a>
                                    <a href="" class="btn btn-danger" v-on:click.prevent="tryDelete(host);" v-if="host.domain_type == 'subdomain'">
                                        <i class="fa fa-trash-o"></i>
                                        Delete...
                                    </a>
                                    <a href="" class="btn btn-default" v-on:click.prevent="edit = -1;">
                                        <i class="fa fa-times"></i>
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item row" v-if="add == true">
                        <div class="col-xl-4">
                            <label class="hidden-xl-up">Domain Name:</label>
                            <div class="form-group">

                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="new_domain">
                                    <div class="input-group-addon">.{{ $domain->domain }}</div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-4">
                            <label class="hidden-xl-up">Website:</label>
                            <div class="form-group">
                                <select name="" id="" class="form-control" v-cloak v-model="new_destination">
                                    <option v-for="drop in dropdown" v-bind:value="drop.value">
                                        @{{ drop.display }}
                                    </option>
                                    <option value="new_url">
                                        Redirect to a new URL
                                    </option>
                                </select>
                                <input type="text" class="form-control" v-model="new_url" v-if="new_destination == 'new_url'"
                                    placeholder="https://">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <div class="btn-group">
                                    <a href="" class="btn btn-success" v-on:click.prevent="add_subdomain()">
                                        <i class="fa fa-plus"></i>
                                        Add Subdomain
                                    </a>
                                    <a href="" class="btn btn-default" v-on:click.prevent="add = false;">
                                        <i class="fa fa-times"></i>
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="card-block card-block-light">
                <a href="" class="btn btn-success" v-on:click.prevent="add = true;" v-if="add != true">Add Subdomain</a>
            </div>


        </div>
    </div>
    @endif
</div>

@endsection


@section('js')

<script>
    var get_url = '{{ route('domains.hosting.data', $domain->id) }}';
</script>
<script src="{{ mix('/stuff/hosting.js') }}"></script>

@endsection