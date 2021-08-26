<?php

namespace App\Http\Controllers;


use App\Repository\FaqRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * @return Factory|View
     * Load page view.
     */
    public function index(): Factory|View
    {
        return view('faqs.index');
    }//..... end of index() .....//

    /**
     * @return mixed
     * List faqs for dataTables.
     */
    public function listFaqsForDataTables(): mixed
    {
        return (new FaqRepository())->dataTable();
    }//..... end of listFaqsForDataTables() .....//

    /**
     * @return mixed
     * Populate faq detail grid.
     */
    public function populateFaqDetailGrid(): mixed
    {
        return (new FaqRepository())->detailDataTable();
    }//..... end of populateFaqDetailGrid() .....//

    /**
     * Save page contents.
     */
    public function save(): array
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'short' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new FaqRepository())->save();

        return ['status' => true, 'message' => __('all.record_saved')];
    }//.... end of save() .....//

    /**
     * @return array
     * Update single field by id.
     */
    public function updateField(): array
    {
        return (new FaqRepository())->updateField();
    }//..... end of updateField() .....//
}
