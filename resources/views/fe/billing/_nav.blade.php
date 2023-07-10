@include('fe.layouts._breadcrumbs')

<ul class="nav nav-pills" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'billing.payment') ? ' active' : ''}}"
           href="{{ route('billing.payment') }}">
            <i class="fa fa-lists"></i>
            Billing
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'billing.plans') ? ' active' : ''}}"
           href="{{ route('billing.plans') }}">
            <i class="fa fa-lists"></i>
            Choose a Plan
        </a>
    </li>

    <li class="nav-item ">
        <a class="nav-link {{ (Route::currentRouteName() == 'billing.card') ? ' active' : ''}}"
           href="{{ route('billing.card') }}">
            <i class="fa fa-credit-card"></i>
            Add Card
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == 'billing.referrals') ? ' active' : ''}}"
           href="{{ route('billing.referrals') }}">
            Referrals
        </a>
    </li>
</ul>
{{-- @endif --}}