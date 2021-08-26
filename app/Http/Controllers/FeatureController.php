<?php

namespace App\Http\Controllers;

use App\Repository\CategoryRepository;
use App\Repository\FeatureRepository;
use Illuminate\Support\Facades\Validator;

class FeatureController extends Controller
{
    public function index()
    {
        return view('feature.index', [
            'categories' => (new CategoryRepository())->dropdownList(type: 'service'),
            'types'      => (new FeatureRepository())->types()
        ]);
    }

    public function list(): mixed
    {
        return (new FeatureRepository())->dataTables();
    }

    public function save()
    {
        $rules = [
            'title'         => 'required',
            'description'   => 'required',
        ];

        $validator = Validator::make(request()->all(), request()->language_id ? $rules: array_merge($rules, ['category_id'   => 'required']));

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new FeatureRepository())->save();

        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function updateField(): array
    {
        return (new FeatureRepository())->updateField();
    }

    public function delete($lang, $id): array
    {
        return (new FeatureRepository())->delete(id: $id);
    }

    public function detailGrid(): mixed
    {
        return (new FeatureRepository())->detailGrid();
    }
}
