<?php

namespace App\Http\Controllers;


use App\Repository\FeatureRepository;
use App\Repository\ItemRepository;

class ItemController extends Controller
{
    public function index($lang, $feature_id)
    {
        return view('feature.item', [
            'feature' => (new FeatureRepository())->getTranslationById(id: $feature_id),
            'types'   => (new ItemRepository())->types()
        ]);
    }

    public function save($lng, $feature_id): array
    {
        (new ItemRepository())->save($feature_id);

        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function list(): mixed
    {
        return (new ItemRepository())->dataTable();
    }

    public function delete($lng, $id): array
    {
        return (new ItemRepository())->delete($id);
    }

    public function detailGrid(): mixed
    {
        return (new ItemRepository())->detailGrid();
    }

    public function updateField(): array
    {
        return (new ItemRepository())->updateField();
    }
}
