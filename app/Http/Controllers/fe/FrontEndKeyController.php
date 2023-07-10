<?php

namespace App\Http\Controllers\fe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Helper;

class FrontEndKeyController extends Controller
{

    public function index()
    {
        $results=Helper::GetDefaultApi("/api/accounts/keys");
        return view('fe.key.index',(array)$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $list =  Helper::ActDefaultApi("api/accounts/keys","POST",$input);

        //return $list['data']->apikey;
        //return redirect(route('key.list'));

        $results=Helper::GetDefaultApi("/api/accounts/keys");
        $results['key'] = $list['data']->apikey;


        return view('fe.key.index',(array)$results);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $results =  Helper::ActDefaultApi("/api/accounts/keys/".$id,"GET");

        return view('fe.key.edit',(array)$results['data']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $input = $request->all();
        $results =  Helper::ActDefaultApi("/api/accounts/keys/".$id,"PATCH",$input);
        return redirect(route('key.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Helper::ActDefaultApi("/api/accounts/keys/".$id,"DELETE");
        return redirect(route('key.list'));
    }
}
