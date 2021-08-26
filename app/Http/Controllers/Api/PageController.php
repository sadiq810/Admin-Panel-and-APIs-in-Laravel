<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Http\Resources\PagesCollection;
use App\Repository\PageRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(): PagesCollection | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new PageRepository())->list();
    }

    /**
     * @return array|Collection
     * Get only: title, slug
     */
    public function list(): Collection | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new PageRepository())->customList();
    }

    public function bySlug($slug): PageResource | null | array
    {
        $validator = Validator::make(request()->all(), ['lang_id' => 'required']);

        if ($validator->fails())
            return ['error' => 'lang_id is required', 'data' => []];

        return (new PageRepository())->getBySlug($slug);
    }
}
