<?php

namespace App\Http\Controllers;

use App\Repository\PageRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * @return Factory|View
     * Load page view.
     */
    public function index(): Factory|View
    {
        return view('pages.index');
    }//..... end of index() .....//

    /**
     * @return mixed
     * List pages for dataTables.
     */
    public function listPagesForDataTables(): mixed
    {
        return (new PageRepository())->dataTables();
    }//..... end of listPagesForDataTables() .....//

    /**
     * @return mixed
     * Populate page detail grid.
     */
    public function populatePageDetailGrid(): mixed
    {
       return (new PageRepository())->subDataTables();
    }//..... end of populatePageDetailGrid() .....//

    /**
     * @return array
     * Save page contents.
     */
    public function save(): array
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new PageRepository())->save();

        return ['status' => true, 'message' => __('all.record_saved')];
    }//.... end of save() .....//

    /**
     * @return array
     * Update single field by id.
     */
    public function updateField(): array
    {
        return (new PageRepository())->updateField();
    }//..... end of updateField() .....//
}//..... end of class.
