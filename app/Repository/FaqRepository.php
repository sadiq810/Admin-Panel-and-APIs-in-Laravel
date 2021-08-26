<?php


namespace App\Repository;


use App\Http\Resources\FaqsCollection;
use App\Models\Faq;
use App\Models\FaqTranslation;
use Yajra\DataTables\Facades\DataTables;

class FaqRepository extends Repository
{
    public function save(): Faq
    {
        $faq = request()->only(['order']);

        if (request()->hasFile('image'))
            $faq['image'] = $this->uploadImage(request()->image, true);

        $faq['status'] = request()->status ? 1 : 0;

        $faq = Faq::updateOrCreate(['id' => request()->id], request()->lang_id ? [] : $faq);

        $faq->translations()->updateOrCreate(['language_id' => request()->lang_id ?? $this->getLanguage()?->id], request()->only(['title', 'short', 'description']));

        return $faq;
    }

    public function dataTable(): mixed
    {
        $faqs = Faq::select('faqs.*', 'faq_translations.title', 'faq_translations.short', 'faq_translations.description')
            ->join('faq_translations', 'faqs.id', '=', 'faq_translations.faq_id')
            ->where('language_id', $this->getLanguage()?->id);

        return Datatables::of($faqs)
            ->addColumn('action', fn () => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function detailDataTable():mixed
    {
        $languages = (new LanguageRepository())->other(app()->getLocale());

        $faqTranslations = FaqTranslation::whereIn('language_id', $languages->pluck('language_id'))
            ->where('faq_id', request()->id)->with('faq')->get();

        $languages->each(function ($l) use ($faqTranslations) {
            $faq        = $faqTranslations->where('language_id', $l->language_id)->first();
            $l->id      = request()->id;
            $l->order   =  $faq->faq->order ?? '';
            $l->status  =  $faq->faq->status ?? 0;
            $l->title   =  $faq->title ?? '';
            $l->short   =  $faq->short ?? '';
            $l->description =  $faq->description ?? '';
        });

        return Datatables::of($languages)
            ->addColumn('action', fn($row) => '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editSub btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function updateField(): array
    {
        $ids = explode('_', request()->pk);

        switch (request('name')) {
            case 'order':
            case 'status':
                Faq::where(['id' => $ids[0]])->update([request()->name => request()->value]);
                break;
            case 'title':
                FaqTranslation::updateOrCreate(['faq_id' => $ids[0], 'language_id' => $ids[1] ?? $this->getLanguage()?->id], [request()->name => request()->value]);
                break;
            default:
                return ['status' => false, 'message' => __('all.action_not_recognized')];
        }//..... end of switch() .....//

        return ['status' => true, 'message' => __('all.value_saved')];
    }

    public function list()
    {
        $Faq = Faq::sorted()->active()->with(['translations' => fn ($q) => $q->where('language_id', request()->lang_id)]);

        return new FaqsCollection(request()->page == 'all' ? $Faq->get(): $Faq->paginate(20));
    }
}
