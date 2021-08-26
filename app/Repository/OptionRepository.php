<?php


namespace App\Repository;


use App\Models\FeatureOption;
use App\Models\FeatureOptionTranslation;
use Yajra\DataTables\Facades\DataTables;

class OptionRepository extends Repository
{
    public function types(): array
    {
        return [
            'icon' => 'Icon',
            'list_item' => 'List Item'
        ];
    }

    public function save($feature_id)
    {
        if (request()->type == 'icon')
            $this->saveIconOption($feature_id);
        else
            $this->saveListOption($feature_id);
    }

    private function saveListOption($feature_id): void
    {
        $data = request()->only(['type']);
        $data['feature_id'] = $feature_id;

        $option = FeatureOption::updateOrCreate(['id' => request()->id], request()->language_id ? [] : $data);

        $option->translations()->updateOrCreate(['feature_option_id' => $option->id, 'language_id' => request()->language_id ?? $this->getLanguage()?->id], request()->only(['title', 'description']));
    }

    private function saveIconOption($feature_id): void
    {
        $data = request()->only(['title', 'description', 'type']);
        $data['feature_id'] = $feature_id;

        if (request()->hasFile('icon'))
            $data['icon'] = $this->uploadImage(request()->icon, false);

        FeatureOption::updateOrCreate(['id' => request()->id], $data);
    }

    public function dataTable(): mixed
    {
        $options = FeatureOption::with(['translations' => fn($q) => $q->where('language_id', $this->getLanguage()?->id)]);

        return Datatables::of($options)
            ->addColumn('action', fn () => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function delete($id): array
    {
        FeatureOption::destroy($id);
        FeatureOptionTranslation::where('feature_option_id', $id)->delete();
        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function detailGrid()
    {
        $option = FeatureOption::findOrFail(request()->id);
        if ($option->type != 'icon') {
            $languages = (new LanguageRepository())->other(app()->getLocale());

            $translations = FeatureOptionTranslation::whereIn('language_id', $languages->pluck('language_id'))
                ->where('feature_option_id', request()->id)->with('option')->get();

            $languages->each(function ($l) use ($translations) {
                $faq        = $translations->where('language_id', $l->language_id)->first();
                $l->id      = request()->id;
                $l->title   =  $faq->title ?? '';
                $l->description =  $faq->description ?? '';
            });
        } else
            $languages = collect([]);

        return Datatables::of($languages)
            ->addColumn('action', fn($row) => '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editSub btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function updateField(): array
    {
        $key = explode('_', request()->pk);

        FeatureOptionTranslation::updateOrCreate(['feature_option_id' => $key[0], 'language_id' => $key[1]], [request()->name => request()->value]);
        return ['status' => true, 'message' => __('all.value_saved')];
    }
}
