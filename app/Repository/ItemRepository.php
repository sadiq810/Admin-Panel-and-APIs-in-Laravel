<?php

namespace App\Repository;


use App\Models\FeatureItem;
use App\Models\FeatureItemTranslation;
use Yajra\DataTables\Facades\DataTables;

class ItemRepository extends Repository
{
    public function types(): array
    {
        return [
            'list_item' => 'Self as a list item',
            'color'     => 'Color',
            'icon'      => 'Icon',
            'textarea'  => 'Textarea',
            'textbox'   => 'Text Box'
        ];
    }

    public function save($feature_id): FeatureItem
    {
        $data = request()->only(['price', 'type']);

        if (request()->hasFile('icon'))
            $data['icon'] = $this->uploadImage(request()->icon, false);

        $data['feature_id'] = $feature_id;

        if (request()->hasFile('preview_image'))
            $data['preview_image'] = $this->uploadImage(request()->preview_image, false);

        $item = FeatureItem::updateOrCreate(['id' => request()->id], request()->language_id ? [] : $data);
        $item->translations()->updateOrCreate(['language_id' => request()->language_id ?? $this->getLanguage()?->id], request()->only(['title', 'description']));

        return $item;
    }

    public function dataTable(): mixed
    {
        $options = FeatureItem::with(['translations' => fn($q) => $q->where('language_id', $this->getLanguage()?->id)]);

        return Datatables::of($options)
            ->addColumn('action', fn () => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function delete($id): array
    {
        FeatureItem::destroy($id);
        FeatureItemTranslation::where('feature_item_id', $id)->delete();
        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function detailGrid()
    {
        $languages = (new LanguageRepository())->other(app()->getLocale());

        $translations = FeatureItemTranslation::whereIn('language_id', $languages->pluck('language_id'))
            ->where('feature_item_id', request()->id)->with('item')->get();

        $languages->each(function ($l) use ($translations) {
            $translation    = $translations->where('language_id', $l->language_id)->first();
            $l->id          = request()->id;
            $l->title       =  $translation->title ?? '';
            $l->description =  $translation->description ?? '';
        });

        return Datatables::of($languages)
            ->addColumn('action', fn($row) => '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editSub btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function updateField(): array
    {
        $key = explode('_', request()->pk);

        FeatureItemTranslation::updateOrCreate(['feature_item_id' => $key[0], 'language_id' => $key[1]], [request()->name => request()->value]);
        return ['status' => true, 'message' => __('all.value_saved')];
    }
}
