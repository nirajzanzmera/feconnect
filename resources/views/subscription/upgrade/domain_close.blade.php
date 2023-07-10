@extends('layouts.guest') 
@section('content') @if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="padding-top:70px;">
            <h2 class="text-primary center m-a-2">
                <img width="250px;" src="{{ asset('img/dataczar-logo.png') }}">
            </h2>
            <div class="card">
                <div class="card-header center">
                    <strong>Checkout</strong>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title">Free Domain</h4>
                            <p class="card-subtitle"></p>
                        </div>
                        <div class="media-right media-middle"></div>
                    </div>
                </div>
                <div class="card-block" style="text-align: center">
                    <h4>
                        Get Your Domain FREE!
                    </h4>
                    <p>
                        @if($paying)
                        With your order today you can get a domain for free on your account. <br /> Please
                        choose your domain! 
                        @else 
                        Sign-up now and we'll give you a domain name and website 30 days for free!
                        You'll also get access to all of the Dataczar features FREE for 30 days, and then it's just 
                        {{ $price_test ? '$19.95' : '$9.95' }}
                        a month to the same card you used today. Keep in mind you can cancel at any time. 
                        @endif
                    </p>
                </div>
                <div class="card-block">
                    <div class="row form-group">
                        <div id="results">

                        </div>
                    </div>
                </div>
                <div class="card-block" style="text-align: center">
                    <div class="row">
                        <div class="col-lg-12" id="search_block" style="display:none;">
                            <strong>Or Search:</strong>
                            <div class="input-group">
                                <input type="text" class="form-control ignore-me" id="keyword" placeholder="domain name...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="search"><i class="fa fa-search fa-btn"></i> Search</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block" style="text-align: center">
                    <div class="row form-group">
                        <a href="{{ route('auth.phone_confirmation') }}" class="btn">I'll do this later</a>
                    </div>
                </div>
            </div>
            <div>
                <small style="color:#999">
                    Void where prohibited. Other terms, conditions, and restrictions may apply.
                    This offer is subject to change or termination without notice. 
                    Your Dataczar access continues until cancelled. If you do not wish to continue for 
                    {{ $price_test ? '$19.95' : '$9.95' }}/mo
                    you can cancel anytime at the site or by calling (844) 855-2927.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
 
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
    @include('domains.partials._results')
<script>
    var template = $('#template').html();
Mustache.parse(template);   // optional, speeds up future uses

load_results();
$(document).on( 'click', '#reload', function(e){
    e.preventDefault();
    load_results();
});
$(document).on( 'click', '#search', function(e){
    e.preventDefault();
    var keyword = $('#keyword').val();
    load_results(keyword);
});
function load_results(keyword = '{{ isset($autodetect) ? $autodetect : "" }}') {
    $('#results').html('<i class="fa fa-btn fa-spinner fa-spin"></i> Loading');
    if(keyword !== '') {
        $.ajax({
            url: '{{ route('domains.search') }}/' + keyword + '?limit=3&available=true&tldFilter=com',
            type: 'GET',
            success: function(result) {

                $('#search_block').show();
                if( result.results.length === 0 ) {
                    $('#results').html('<a href="#" id="reload" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Domains</a>');
                } else {
                    dz('event','domains_offered', result);
                    result.idx = function() {
                        return ++window['INDEX']||(window['INDEX']=0);
                    };
                    var rendered = Mustache.render(template, result);

                    $('#results').html(rendered);
                }
            },
        });
    }
}

</script>
@endsection
