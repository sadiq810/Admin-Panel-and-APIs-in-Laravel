<?php

namespace App\Http\Controllers;

use App\Repository\FeatureRepository;
use App\Repository\OptionRepository;

class OptionController extends Controller
{
    public function index($lang, $feature_id)
    {
        return view('feature.option', [
            'feature'       => (new FeatureRepository())->getTranslationById(id: $feature_id),
            'types'         => (new OptionRepository())->types()
        ]);
    }

    public function save($lng, $feature_id): array
    {
        (new OptionRepository())->save($feature_id);

        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function list(): mixed
    {
        return (new OptionRepository())->dataTable();
    }

    public function delete($lng, $id): array
    {
        return (new OptionRepository())->delete($id);
    }

    public function detailGrid(): mixed
    {
        return (new OptionRepository())->detailGrid();
    }

    public function updateField(): array
    {
        return (new OptionRepository())->updateField();
    }
}
