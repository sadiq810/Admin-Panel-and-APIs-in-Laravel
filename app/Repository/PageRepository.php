<?php


namespace App\Repository;


use App\Http\Resources\PageResource;
use App\Http\Resources\PagesCollection;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PageRepository extends Repository
{
    public function save(): Page
    {
        $data = request()->only(['order', 'type', 'position']);
        $data['status'] = request()->status ? 1 : 0;

        $page = Page::updateOrCreate(['id' => request()->id], $data);

        $page->translations()->updateOrCreate(['page_id' => $page->id, 'language_id' => request()->lang_id ?? $this->getLanguage()?->id], request()->only(['title', 'content', 'seo_keywords', 'seo_description']));

        if ($page->wasRecentlyCreated) {
            $page->slug = Str::slug(request()->title.'-'.$page->id);
            $page->save();
        }

        return $page;
    }

    public function dataTables(): mixed
    {
        $pageTranslation = PageTranslation::with('page')->where('language_id', $this->getLanguage()?->id);

        if (request()->type_filter)
            $pageTranslation->whereHas('page', fn($q) => $q->where('type', request()->type_filter));

        return Datatables::of($pageTranslation)
            ->addColumn('action', fn($row) => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function subDataTables(): mixed
    {
        $languages = (new LanguageRepository())->other(app()->getLocale());

        $pageTranslations = PageTranslation::whereIn('language_id', $languages->pluck('language_id'))
            ->where('page_id', request()->id)->get();

        $languages->each(function ($l) use ($pageTranslations) {
            $page       = $pageTranslations->where('language_id', $l->language_id)->first();
            $l->id      = request()->id;
            $l->title   = $page->title ?? '';
            $l->type    = $page->page->type ?? '';
            $l->slug    = $page->page->slug ?? '';
            $l->order   = $page->page->order ?? '';
            $l->status  = $page->page->status ?? '';
            $l->content = $page->content ?? '';
            $l->seo_keywords    = $page->seo_keywords ?? '';
            $l->seo_description = $page->seo_description ?? '';
        });

        return Datatables::of($languages)
            ->addColumn('action', fn($row) => '<a href="javascript:void(0)" data-id="' . $row->id . '" class="editSub btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function updateField(): array
    {
        $ids = explode('_', request()->pk);

        switch (request('name')) {
            case 'order':
            case 'type':
            case 'status':
                Page::where(['id' => $ids[0]])->update([request()->name => request()->value]);
                break;
            case 'title':
                PageTranslation::updateOrCreate(['page_id' => $ids[0], 'language_id' => $ids[1] ?? optional($this->getLanguage())->id], [request()->name => request()->value]);
                break;
            default:
                return ['status' => false, 'message' => __('all.action_not_recognized')];
        }//..... end of switch() .....//

        return ['status' => true, 'message' => __('all.value_saved')];
    }

    public function list(): PagesCollection
    {
        $pages = Page::whereHas('translations', function($q) {
            if (request()->search)
                $q->where('title', 'LIKE', '%'.request('search').'%');

            if (request()->type)
                $q->where('type', request()->type);

            $q->where('language_id', request()->lang_id);
        })->with(['translations' => function($q) {
                if (request()->search)
                    $q->where('title', 'LIKE', '%'.request('search').'%');
                $q->where('language_id', request()->lang_id);
            }]);

        return new PagesCollection($pages->get());
    }

    public function customList(): Collection
    {
        return Page::select('pages.slug', 'page_translations.title')
            ->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->where('language_id', request()->lang_id)
            ->where('type', 'page')
            ->get();
    }

    public function getBySlug($slug): PageResource | null
    {
        $page = Page::whereHas('translations', fn($q) => $q->where('language_id', request()->lang_id))
            ->with(['translations' => fn($q) => $q->where('language_id', request()->lang_id)])
            ->where('slug', $slug)
            ->firstOrFail();

        return new PageResource($page);
    }
}
