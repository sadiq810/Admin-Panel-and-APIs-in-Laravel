<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Repository\CategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * @return CategoryCollection|array
     * Get Categories list.
     */
    public function index(): CategoryCollection | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new CategoryRepository())->list();
    }//..... end of index() .....//
}//..... end of class.
