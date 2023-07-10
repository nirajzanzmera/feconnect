@include('layouts.partials._breadcrumbs')
<ul class="nav nav-pills" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'billing.payment') ? ' active' : ''}}"
            href="{{ route('billing.payment') }}">
            <i class="fa fa-lists"></i>
            Billing
        </a>
    </li>
    @notsubscribed
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'plans.index') ? ' active' : ''}}"
            href="{{ route('plans.index') }}">
            <i class="fa fa-lists"></i>
            Choose a Plan
        </a>
    </li>
    @endnotsubscribed

    @subscribed
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'plans.index') ? ' active' : ''}}"
            href="{{ route('plans.index') }}">
            <i class="fa fa-lists"></i>
            Change Plans
        </a>
    </li>
    @notsubcanceled
    <li class="nav-item">
        <a id="cancel_plan" class="nav-link{{ (Route::currentRouteName() == 'plans.cancel') ? ' active' : ''}}"
            href="{{ route('plans.cancel') }}">
            <i class="fa fa-lists"></i>
            Cancel Plan
        </a>
    </li>
    @endnotsubcanceled




    @resumable
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'plans.resume') ? ' active' : ''}}"
            href="{{ route('plans.resume') }}">
            <i class="fa fa-lists"></i>
            Resume Plan
        </a>
    </li>
    @endresumable
    @endsubscribed

    @notusercanceled
    <li class="nav-item">
        <a id="cancel_plan" class="nav-link{{ (Route::currentRouteName() == 'plans.cancel') ? ' active' : ''}}"
            href="{{ route('plans.cancel') }}">
            <i class="fa fa-lists"></i>
            Cancel Plan
        </a>
    </li>
    @endnotusercanceled


    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'plans.card') ? ' active' : ''}}"
            href="{{ route('plans.card') }}">
            <i class="fa fa-credit-card"></i>
            {{ auth()->user()->currentTeam->hasCardOnFile() ? 'Update Card' : 'Add Card' }}
        </a>
    </li>
    @if(auth()->user()->currentTeam->hasCardOnFile())
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'billing.funds') ? ' active' : ''}}"
            href="{{ route('billing.funds') }}">
            <i class="fa fa-plus-circle"></i>
            Add Funds
        </a>
    </li>
    @endif
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'billing.referrals') ? ' active' : ''}}"
            href="{{ route('billing.referrals') }}">
            {{--<i class="fa fa-dollar"></i>--}}
            Referrals
        </a>
    </li>
</ul>