<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqsCollection;
use App\Repository\FaqRepository;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * @return FaqsCollection|array
     * Get Categories list.
     */
    public function index(): FaqsCollection | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new FaqRepository())->list();
    }//..... end of index() .....//
}
