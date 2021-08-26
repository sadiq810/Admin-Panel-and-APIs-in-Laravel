<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogResource;
use App\Repository\BlogRepository;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(): BlogCollection | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new BlogRepository())->list();
    }

    public function single($slug): BlogResource | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new BlogRepository())->single(slug: $slug, language_id: request('lang_id'));
    }
}
