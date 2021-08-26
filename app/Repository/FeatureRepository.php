<?php


namespace App\Repository;


use App\Http\Resources\FeatureCollection;
use App\Models\Feature;
use App\Models\FeatureTranslation;
use Yajra\DataTables\Facades\DataTables;

class FeatureRepository extends Repository
{
    public function types(): array
    {
        return [
            'as_list'           => 'Self as a list item',
            'dropdown'          => 'Dropdown',
            'has_items_list'    => 'Has Items List',
            'icon'              => 'Icon',
            'textarea'          => 'Textarea',
            'textbox'           => 'Text Box'
        ];
    }

    public function dataTables()
    {
        $featureTranslations = FeatureTranslation::select('feature_id as id', 'feature_id', 'language_id', 'title', 'description')
            ->with(['feature'])->where('language_id', $this->getLanguage()?->id);

        return Datatables::of($featureTranslations)
            ->addColumn('action', fn ($row) => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        <a href="'.route('features.options', [app()->getLocale(), $row->id]).'" class="btn btn-round btn-primary btn-sm" title="'.__('all.add_options').'"><i class="fa fa-list-alt"></i></a>
                                        <a href="'.route('features.items', [app()->getLocale(), $row->id]).'" class="btn btn-round btn-default btn-sm" title="'.__('all.add_items').'"><i class="fa fa-angellist"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function save(): Feature
    {
        $data = request()->only(['category_id', 'price', 'type']);

        if (request()->hasFile('image'))
            $data['image'] = $this->uploadImage(request()->image, true);

        $data['status'] = request()->status ? 1 : 0;

        $feature = Feature::updateOrCreate(['id' => request()->id], request()->language_id ? [] : $data);
        $feature->translations()->updateOrCreate(['language_id' => request()->language_id ?? $this->getLanguage()?->id], request()->only(['title', 'description']));

        return $feature;
    }

    public function updateField(): array
    {
        $keys = explode('_', request()->pk);
        FeatureTranslation::updateOrCreate(['feature_id' => $keys[0], 'language_id' => $keys[1] ?? $this->getLanguage()?->id], [request()->name => request()->value]);

        return ['status' => true, 'message' => __('all.value_saved')];
    }

    public function delete($id): array
    {
        $feature = Feature::findOrFail($id);
        $feature->translations()->delete();
        $feature->delete();

        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function detailGrid(): mixed
    {
        $languages = (new LanguageRepository())->other(app()->getLocale());

        $featureTranslations = FeatureTranslation::whereIn('language_id', $languages->pluck('language_id'))
            ->where('feature_id', request()->id)->get();

        $languages->each(function ($l) use ($featureTranslations) {
            $translation        = $featureTranslations->where('language_id', $l->language_id)->first();
            $l->id              = request()->id;
            $l->title           = $translation->title ?? '';
            $l->description     = $translation->description ?? '';
        });

        return Datatables::of($languages)
            ->addColumn('action', fn($row) => '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editSub btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function getTranslationById($id, $lang_id = null): FeatureTranslation
    {
        return FeatureTranslation::where('feature_id', $id)->where('language_id', $lang_id ?? $this->getLanguage()?->id)->firstOrFail();
    }

    public function detailList(): FeatureCollection
    {
        $features = Feature::active()
            ->with([
                'translations'          => fn($q) => $q->where('language_id', request()->lang_id),
                'options.translations'  => fn($q) => $q->where('language_id', request()->lang_id),
                'items.translations'    => fn($q) => $q->where('language_id', request()->lang_id),
            ]);

        return new FeatureCollection(request()->page == 'all' ? $features->get() : $features->paginate(20));
    }
}
