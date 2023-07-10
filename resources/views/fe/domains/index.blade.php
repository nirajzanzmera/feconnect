@extends('fe.layouts.app')
@section('content')
@include('domains.partials._nav')
<div class="row-fluid">

    <div class="card">
        <div class="card-header">
            <div class="media">
                <div class="media-body">
                    <h4 class="card-title pull-left">Register Your Domain</h4>
                </div>
            </div>
        </div>
        <div class="card-block">
            <form action="{{ route('domains.search.index') }}" method="GET">
                <div class="row form-group">
                    <label class="col-md-2 form-control-label" style="text-align:right">Search</label>
                    <div class="col-md-8">
                        <input name="value" type="text" class="form-control" id="keyword"
                            placeholder="Find your domain name">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-success" id="search">
                            <i class="fa fa-btn fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if(count($bad_domains) > 0)
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Domains with issues</h4>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-lg-down">
                        <div class="col-xl-3"><strong>Domain:</strong></div>
                        <div class="col-xl-3"><strong>Website / Forward:</strong></div>
                        <div class="col-xl-2"><strong>Status:</strong></div>
                        <div class="col-xl-2"></div>
                    </li>
                    @foreach($bad_domains as $domain)
                    <li class="list-group-item row">
                        <div class="col-xl-3 ellipsis" title="{{ $domain->domain }}">
                            <label class="hidden-xl-up">Domain:</label>
                            {{ $domain->domain }}
                        </div>
                        <div class="col-xl-3 ellipsis" title="">
                            <label class="hidden-xl-up">Website:</label>
                            @if(count($bad_domains) < 10)
                            @if($domain->name_servers['custom_nameservers'] ?? false)
                                <i>Custom</i>
                            @else       
                            {{ $domain->website->name ?? '' }}
                            {{ ($domain->urls->count() > 0 ) ? $domain->urls()->first()->forwards_to : '' }}
                            @endif
                            @endif
                        </div>
                        <div class="col-xl-2">
                            <label class="hidden-xl-up">Status:</label>
                            <div class="label label-danger">

                                {{ $domain->status }}
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="btn-group float-xl-right">
                                <a href="{{ route('domains.register', ['domainName'=> $domain->domain.':'.$domain->sig]) }}/"
                                    class="btn btn-sm btn-primary">

                                    <i class="fa fa-refresh"></i>
                                    Retry
                                </a>
                                <a href="{{ route('domains.cancel', $domain->id) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-times"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif


    @if(count($domains) > 0)
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Your Domains</h4>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-lg-down">
                        <div class="col-xl-4"><strong>Domain:</strong></div>
                        <div class="col-xl-4"><strong>Website / Forward:</strong></div>
                        <div class="col-xl-2"><strong>Status:</strong></div>
                        <div class="col-xl-2"></div>
                    </li>
                    @foreach($domains as $domain)
                    <li class="list-group-item row">
                        <div class="col-xl-4 ellipsis" title="{{ $domain->domain }}">
                            <label class="hidden-xl-up">Domain:</label>
                            {{ $domain->domain }}
                        </div>
                        <div class="col-xl-4 ellipsis"
                        title="{{ isset($domain->website->name) ? $domain->website->name : 'no site yet' }}">
                        <label class="hidden-xl-up">Website:</label>
                       
                        @if(count($domains) < 10)
                        @if($domain->name_servers['custom_nameservers'] ?? false)
                            <i>Custom</i>
                        @else       
                            @if (!empty($domain->website))
                                {{ $domain->website->name ?? '' }}
                            @else
                                {{-- Relationship method used for $domain which is not applicable for an api data --}}
                                {{-- {{ $domain->getSetting('answer') ?? ($domain->urls->count() > 0  ? $domain->urls()->first()->forwards_to : '') }} --}}
                            @endif
                        @endif
                        @endif
                            
                        </div>
                        <div class="col-xl-2">
                            <label class="hidden-xl-up">Status:</label>
                            {{ $domain->type }}
                        </div>
                        <div class="col-xl-2">
                            @include('components.row_menu', ['items' => domain_btn($domain)])
                            {{-- @rowmenu(['items' => $domain->btns])@endrowmenu --}}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif



    <hr>
    <hr>
    <div class="col-xl-6">
        {{-- @if(Auth::user()->admin == true ) --}}
        {{-- admin value could be passed through home_data  --}}
        @if(!empty(session('home_data')['data']->data->user->admin) && session('home_data')['data']->data->user->admin == true )
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title pull-left">Bring Your Own Domain (admin only)</h4>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <form method="post" action="{{ ($paying) ? route('domains.store') : '' }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="type" value="BYOD">
                    <div class="row form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
                        <label class="col-md-2 form-control-label" style="text-align:right">Domain</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="domain"
                                value="{{ old('domain', !empty($sender->domain) ? $sender->domain : NULL ) }}"
                                required{{ ($paying) ? '' : ' readonly' }}>
                            @if ($errors->has('domain'))
                            <span class="help-block">
                                <strong>{{ $errors->first('domain') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-success {{ ($paying) ? '' : 'disabled' }}">
                                <i class="fa fa-btn fa-save"></i> Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div> <!-- end col-xl-6 -->
</div>
@endsection
@section('js')
<link rel="stylesheet" type="text/css"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection