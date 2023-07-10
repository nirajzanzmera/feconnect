@extends('layouts.app')
@section('content')
@include('domains._nav')
<div class="row-fluid">
    <div class="col-md-6 col-md-offset-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Register Your Domain Name</h1>
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('domains.register', $domainName ) }}" id="reg_form">
                    {!! csrf_field() !!}
                    <div class="row form-group">
                        <div class="col-md-12">
                            <strong>Requested Domain: </strong><br />
                            <h2 @if($dark)style="color:white" @endif>
                                {{ $domain_name }}
                            </h2>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <p>
                                <em>
                                    Please double check this is the domain you would like to register.
                                </em>
                            </p>
                            @if($paying)
                                @if(auth()->user()->currentTeam->domains->where('status','active')->count() +
                                auth()->user()->currentTeam->related_domains()->where('status', 'active')->count() == 0)
                                <p>
                                    Your subscription includes 'one' domain registration plus renewals for the life of your
                                    paid subscription.
                                </p>
                                @else
                                <p>
                                    Your subscription includes discounted domain registrations. <br />
                                    Regular price: <s>$14.95/year</s> <br />
                                    Your Price: $9.95/year <br />
                                </p>
                                @endif
                            @else
                                @if(auth()->user()->currentTeam->domains->where('status','active')->count() +
                                    auth()->user()->currentTeam->related_domains()->where('status', 'active')->count() == 0)
                                    <p>
                                        A pro subscription includes 'one' domain registration plus renewals for the life of
                                        your paid subscription.
                                    </p>
                                @else
                                    <p>
                                        Your subscription includes discounted domain registrations. <br />
                                        Regular price: <s>$14.95/year</s> <br />
                                        Your Price: $9.95/year <br />
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success loading">
                                Register
                            </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.loading').on('click', function(e){
            e.preventDefault();
            $(this).addClass('disabled');
            $(this).html('<i class="fa fa-spinner fa-pulse"></i> working...');
            $(this).prop("disabled", true);
            $('#reg_form').submit();
        });
    });
</script>
@endsection