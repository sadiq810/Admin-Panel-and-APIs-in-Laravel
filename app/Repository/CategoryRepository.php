<?php


namespace App\Repository;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

class CategoryRepository extends Repository
{
    public function save(): Category
    {
        $data = request()->only(['order', 'type']);
        $data['status'] = request()->status ? 1 : 0;

        $category = Category::updateOrCreate(['id' => request()->id], $data);

        $category->translations()->updateOrCreate(['language_id' => $this->getLanguage()?->id], request()->only(['title', 'description']));

        return $category;
    }

    public function delete($id): array
    {
        Category::destroy($id);
        CategoryTranslation::where('category_id', $id)->delete();
        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function dataTables(): mixed
    {
        $categoryTranslations = CategoryTranslation::with('category');
        $categoryTranslations->where('language_id', '=', request()->lang_id ?? $this->getLanguage()?->id);

        return Datatables::of($categoryTranslations)
            ->addColumn('action', fn () => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function detailDataTables(): mixed
    {
        $languages = (new LanguageRepository())->other(app()->getLocale());

        $cats = CategoryTranslation::whereIn('language_id', $languages->pluck('language_id'))
            ->where('category_id', request()->id)->get();

        $languages->each(function ($l) use ($cats) {
            $cat = $cats->where('language_id', $l->language_id)->first();
            $l->title = $cat ? $cat->title : '';
            $l->id = request()->id;
        });

        return Datatables::of($languages)->make(true);
    }

    public function updateField(): array
    {
        switch (request('name')) {
            case 'title':
                $pk = explode('_', request()->pk);
                CategoryTranslation::updateOrCreate(['category_id' => $pk[0], 'language_id' => $pk[1] ?? $this->getLanguage()?->id], ['title' => request()->value]);
                break;
            case 'level':
            case 'order':
            case 'status':
                Category::where(['id' => request()->pk])->update([request()->name => request()->value]);
                break;
            default:
                return ['status' => false, 'message' => __('all.action_not_recognized')];
        }//..... end of switch() .....//

        return ['status' => true, 'message' => __('all.value_saved')];
    }

    public function dropdownList($lang_id = null, $type = 'article'): Collection
    {
        return CategoryTranslation::where('language_id', $lang_id ?? $this->getLanguage()?->id)->pluck('title', 'category_id');
    }

    public function list()
    {
        $result = CategoryTranslation::with(['category'])->whereHas('category', function($q) {
            if (request()->type)
                $q->where('type', request()->type);

            if (request()->search)
                $q->where('title', 'LIKE', '%'.request('search').'%');

            $q->active();
        });

        if (request()->lang_id != 'all')
            $result->where('language_id', request()->lang_id);

        return new CategoryCollection((request()->page == 'all' || request()->page == 0) ? $result->get(): $result->paginate(20));
    }
}
