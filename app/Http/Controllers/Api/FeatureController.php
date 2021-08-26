<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureCollection;
use App\Repository\FeatureRepository;
use Illuminate\Support\Facades\Validator;

class FeatureController extends Controller
{
    public function detailList(): FeatureCollection | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new FeatureRepository())->detailList();
    }
}
