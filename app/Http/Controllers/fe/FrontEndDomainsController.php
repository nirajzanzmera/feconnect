<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FrontEndDomainsController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('verify.login');
    }



    public function domains() 
    {
        $results=Helper::GetDefaultApi("api/domains");
        return view('fe.domains.index', (array)$results['data']);
    }

    public function domains_edit($id) 
    {
        
        $hosting=Helper::GetDefaultApi("/domains/${id}/hosting/data");
        $emails=Helper::GetDefaultApi("/domains/${id}/emails/data");
        $domains=Helper::GetDefaultApi("api/domains");

        $results = (object) array_merge( (array)$hosting['data'],  (array)$emails['data']);

        $results = (object) array_merge( (array)$domains['data'], (array)$results);
        $boxes = $emails['data']->forwards;

        return view('fe.domains.edit', (array)$results)->with(['boxes'=> $boxes]);
    }

    public function domain_emails($id) 
    {
        $results=Helper::GetDefaultApi("/domains/${id}/emails/data");
        $domains=Helper::GetDefaultApi("api/domains");
        $results['data']->domain = $domains['data']->domain;
        $custom = '';

        return view('domains.boxes.index_new', (array)$results['data'])->with(['custom'=>$custom]);
    }
    
    public function hosting_data($id) 
    {
        $results=Helper::GetDefaultApi("/domains/${id}/hosting/data");

        return $results['data'];
    }
    
    public function emails_data($id) 
    {
        $results=Helper::GetDefaultApi("/domains/${id}/emails/data");

        return $results['data'];
    }

    public function domains_hosting($id) 
    {
        $results=Helper::GetDefaultApi("/domains/${id}/hosting/data");

        $domains=Helper::GetDefaultApi("api/domains");
        $results['data']->domain = $domains['data']->domain;

        return view('fe.domains.hosting.index', (array)$results['data']);
    }
    
    public function domains_advanced($id) 
    {

        $results=Helper::GetDefaultApi("api/domains");

        return view('fe.domains.advanced.index', (array)$results['data']);
    }

    public function domains_advanced_lock($id) 
    {

        $results=Helper::GetDefaultApi("api/domains");

        return view('fe.domains.advanced.lock', (array)$results['data']);
    }

}
