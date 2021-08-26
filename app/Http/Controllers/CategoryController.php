<?php

namespace App\Http\Controllers;

use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return view('category.category_list', ['languages' => (new LanguageRepository())->activeList()]);
    }

    /**
     * @return mixed
     * Get Categories list for datatables.
     */
    public function listCategories(): mixed
    {
        return (new CategoryRepository())->dataTables();
    }//..... end of listCategories() .....//

    /**
     * Store a newly created resource in db.
     * @return array
     */
    public function save(): array
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'type'  => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new CategoryRepository())->save();

        return ['status' => true, 'message' => __('all.record_saved')];
    }//..... end of save() .....//

    /**
     * Remove the specified resource from storage.
     * @return array
     */
    public function destroy($lang, $id, $land_id): array
    {
        return (new CategoryRepository())->delete(id: $id);
    }

    /**
     * @return mixed
     * Get details grid records.
     */
    public function getDetailList(): mixed
    {
        return (new CategoryRepository())->detailDataTables();
    }//..... end of getDetailList() ....//

    /**
     * @return array
     * Save updated field value
     */
    public function updateField(): array
    {
        return (new CategoryRepository())->updateField();
    }//..... end of updateField() .....//
}
