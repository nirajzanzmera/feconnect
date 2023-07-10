<?php

namespace App\Http\Controllers\fe;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Images\FlatIcon;
use App\Images\Pexels;


class FrontEndImageController extends Controller
{


    public function searchFlaticon(Request $request)
    {
        if (!empty(env('FLATICON_KEY'))) {
            $valid_data = $request->validate($this->rules());
            $flaticon = new FlatIcon;
            return response()->json($flaticon->search(
                $valid_data['search'], 
                !empty($valid_data['page']) ? $valid_data['page'] : 1
            ));
        }
        else {
            return Helper::RepeatDefaultApi($request,'/api/flaticon/search',"POST");
        }
    }

    public function searchPexels(Request $request)
    {
        if (!empty(env('PEXELS_KEY'))) {
            $valid_data = $request->validate($this->rules());
            $pexels = new Pexels;
            return response()->json($pexels->search(
                $valid_data['search'], 
                !empty($valid_data['page']) ? $valid_data['page'] : 1
            ));
        }
        else {
            return Helper::RepeatDefaultApi($request,'/api/pexels/search',"POST");
        }
    }


    public function searchPixabay(Request $request)
    {
        if (!empty(env('PIXABAY_KEY'))) {
            $valid_data = $request->validate($this->rules());
            $pexels = new Pixabay;
            return response()->json($pexels->search(
                $valid_data['search'], 
                !empty($valid_data['page']) ? $valid_data['page'] : 1
            ));
        }
        else {
            return Helper::RepeatDefaultApi($request,'/api/pixabay/search',"POST");
        }
    }

    public function rules()
    {
        return [
            'search' => 'required | string',
            'page' => 'nullable | integer'
        ];
    }
}