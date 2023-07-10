<script id="template" type="x-tmpl-mustache">
@{{#msg}}
<li class="list-group-item alert alert-warning">
    <i class="fa fa-warning"></i>
    @{{msg}} (@{{terms}})
</li>
@{{/msg}}
@{{#results}}
    <li class="list-group-item @{{^purchasable}} disabled@{{/purchasable}}">
        <div class="row center text-lg-left">
            <div class="col-xl-1 media-middle">
                <i class="material-icons text-muted">public</i>
            </div>
            <div class="col-xl-8 media-middle">
            <span style="font-size:16px; font-weight: bold;">
                    @{{ domainName }}
                </span>
            </div>
            <div class="col-xl-2 text-center text-lg-left">
                @{{#purchasable}}
                {{-- @if (Route::currentRouteName() == 'landing.index')
                    <a href="{{ route('auth.checkout', ['data'=>$landing->pkgcd]) }}&amp;domain=@{{ domainName }}:@{{ sig }}" class="btn btn-success">Add To Cart</a>
                @elseif  --}}
                @if(Route::currentRouteName() == 'plans.upgrade2')
                <form action="{{ route('domains.register.upsell') }}/@{{ domainName }}:@{{ sig }}{{ ($price_test) ? '/3' : '/2' }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="redir" value="auth.phone_confirmation">
                    <button id="choose@{{idx}}" type="submit" class="btn btn-success reg-btn">Choose</button>
                </form>
                @else
                    @if (isset(auth()->user()->currentTeam) && auth()->user()->currentTeam->hasCardOnFile())
                        <a href="{{ route('domains.register') }}/@{{ domainName }}:@{{ sig }}" class="btn btn-success">Register...</a>
                    @else
                        <a href="{{ route('auth.checkout', ['data'=> $pkgcd->encoded ?? '' ]) }}&amp;domain=@{{ domainName }}:@{{ sig }}" class="btn btn-success">
                            Add To Cart
                        </a>
                    @endif
                @endif
                @{{/purchasable}}
                
                @{{^purchasable}}
                Not available
                @{{/purchasable}}
                
            </div>
        </div>
    </li>
    @{{/results}}
</script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.reg-btn', function(e){
            e.preventDefault();
            $(this).attr('disabled', 'disabled');
            dz('event', 'domain_reg', '{!! json_encode($tracking) !!}');
            var form = $(this).parents('form:first');
            form.submit();
        });
    });
</script>
