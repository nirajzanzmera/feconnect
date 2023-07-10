<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontEndBillingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }

    public function card(Request $request){
        $results=Helper::GetDefaultApi("/api/plans/card");
        return view('fe.billing.card', (array)$results['data']);
    }

    public function funds(Request $request){
        $results=Helper::GetDefaultApi("/api/billing/fund");
        return view('fe.billing.fund', (array)$results['data']);
    }

    public function referrals(Request $request){
        $results=Helper::GetDefaultApi("/api/accounts/referrals");
        return view('fe.billing.referral', (array)$results['data']);
    }

    public function plans(Request $request){
        $results=Helper::GetDefaultApi("/api/plans");
        return view('fe.billing.plan', (array)$results['data']);
    }

    public function plans_table(Request $request){
        $results=Helper::GetDefaultApi("/api/plans");
        return view('fe.billing.plan_table', (array)$results['data']);
    }

    public function payment(Request $request){
        $results=Helper::GetDefaultApi("/api/plans/card");
        //$results=Helper::GetDefaultApi("/api/billing/payments");
        return view('fe.billing.card', (array)$results['data']);
    }


}
