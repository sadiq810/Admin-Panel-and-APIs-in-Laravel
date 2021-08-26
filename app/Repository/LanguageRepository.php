<?php


namespace App\Repository;


use App\Http\Resources\LanguageCollection;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

class LanguageRepository extends Repository
{

    public function save(Request $request): Language
    {
        $data = array_merge(['status' => $request->status ? 1 : 0], $request->only(['code', 'local_name', 'latin_name', 'direction']));
        return Language::updateOrCreate(['id' => $request->id], $data);
    }

    public function delete($id): void
    {
        Language::destroy($id);
    }

    public function dataTable(): mixed
    {
        return Datatables::of(Language::query())
            ->addColumn('action', fn() => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a>')
        ->rawColumns(['action'])->make(true);
    }

    public function activeList(): Collection
    {
        return Language::select('id', 'code', 'local_name')->active()->get();
    }

    public function updateField(Request $request)
    {
        Language::where(['id' => $request->pk])->update([$request->name => request()->value]);
    }

    public function other($code): Collection
    {
        return Language::select('id as language_id', 'local_name')->active()->where('code', '!=', $code)->get();
    }

    public function list(): LanguageCollection
    {
        $language = Language::active();

        return new LanguageCollection(request()->page == 'all'? $language->get(): $language->paginate(20));
    }
}
