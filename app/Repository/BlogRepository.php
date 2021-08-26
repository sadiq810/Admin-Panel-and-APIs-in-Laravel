<?php


namespace App\Repository;


use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\BlogTranslation;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogRepository extends Repository
{
    public function dataTable(): mixed
    {
        $blogTranslations = BlogTranslation::select('article_id as id', 'article_id', 'language_id', 'title', 'summary', 'description', 'seo_keywords', 'seo_description')
            ->with(['language', 'blog'])->where('language_id', $this->getLanguage()?->id);

        return Datatables::of($blogTranslations)
            ->addColumn('action', fn () => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function save(): Blog
    {
        $data = request()->only(['category_id']);

        if (request()->hasFile('image'))
            $data['image'] = $this->uploadImage(request()->image, true);

        $data['status'] = request()->status ? 1 : 0;

        $blog = Blog::updateOrCreate(['id' => request()->id], request()->language_id ? [] : $data);
        $blog->translations()->updateOrCreate(['language_id' => request()->language_id ?? $this->getLanguage()?->id], request()->only(['title', 'seo_keywords', 'seo_description', 'summary', 'description']));

        if ($blog->wasRecentlyCreated) {
            $blog->slug = Str::slug(request()->title . '-' . $blog->id, '-');
            $blog->save();
        }

        return $blog;
    }

    public function delete($id): array
    {
        $blog = Blog::findOrFail($id);
        $blog->translations()->delete();
        $blog->delete();

        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function updateField(): array
    {
        $keys = explode('_', request()->pk);
        BlogTranslation::updateOrCreate(['article_id' => $keys[0], 'language_id' => $keys[1] ?? $this->getLanguage()?->id], [request()->name => request()->value]);

        return ['status' => true, 'message' => __('all.value_saved')];
    }

    public function detailGrid(): mixed
    {
        $languages = (new LanguageRepository())->other(app()->getLocale());

        $blogTranslations = BlogTranslation::whereIn('language_id', $languages->pluck('language_id'))
            ->where('article_id', request()->id)->get();

        $languages->each(function ($l) use ($blogTranslations) {
            $blogTrans          = $blogTranslations->where('language_id', $l->language_id)->first();
            $l->id              = request()->id;
            $l->title           =  $blogTrans->title ?? '';
            $l->summary         =  $blogTrans->summary ?? '';
            $l->description     =  $blogTrans->description ?? '';
            $l->summary         =  $blogTrans->summary ?? '';
            $l->seo_description =  $blogTrans->seo_description ?? '';
            $l->seo_keywords    =  $blogTrans->seo_keywords ?? '';
        });

        return Datatables::of($languages)
            ->addColumn('action', fn($row) => '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editSub btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function list(): BlogCollection
    {
        $blog = Blog::whereHas('translations', function($q) {
                if (request()->search)
                    $q->where('title', 'LIKE', '%'.request('search').'%');
                $q->where('language_id', request()->lang_id);
            })
            ->with(['translations' => function($q) {
                if (request()->search)
                    $q->where('title', 'LIKE', '%'.request('search').'%');
                $q->where('language_id', request()->lang_id);
            }]);

        return new BlogCollection(request()->page == 'all' ? $blog->get() : $blog->paginate(20));
    }

    public function single($slug, $language_id): BlogResource
    {
        $blog = Blog::whereHas('translations', fn($q) => $q->where('language_id', $language_id))
            ->with(['translations' => fn($q) => $q->where('language_id', $language_id)])
            ->whereSlug($slug)->firstOrFail();

        return new BlogResource($blog);
    }
}
