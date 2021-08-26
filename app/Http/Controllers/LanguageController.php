<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Repository\LanguageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load language listing view.
     */
    public function index()
    {
        return view('language.language_list');
    }

    /**
     * @return mixed
     * Load languages list of datatables.
     */
    public function list(): mixed
    {
        return (new LanguageRepository())->dataTable();
    }//..... end of loadLanguages() .....//

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request): array
    {
        $validator = Validator::make($request->all(), [
           'code'      =>'required',
           'local_name'=>'required',
           'latin_name'=>'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new LanguageRepository())->save($request);

        return ['status' => true, 'message' => __('all.record_saved')];
    }//..... end of store() ....//

    /**
     * Remove the specified resource from storage.
     *
     * @param $lng
     * @param int $id
     * @return array
     */
    public function destroy($lng, $id): array
    {
        (new LanguageRepository())->delete($id);
        return ['status' => true, 'message' => __('all.record_deleted')];
    }

    /**
     * @return Collection
     * Get Active languages list.
     */
    public function getActiveLanguages(): Collection
    {
        return (new LanguageRepository())->activeList();
    }//..... end of getActiveLanguages() .....//

    /**
     * @return \Illuminate\Http\RedirectResponse
     * Change language.
     */
    public function changeLanguage()
    {
        $lang = request()->segment(4);

        if ($lang) {
            $lang = Language::where('code', $lang)->first();
            if ($lang)
                app()->setLocale($lang->code);
        }//..... end if() .....//

        return redirect()->route(app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName(), app()->getLocale());
    }//..... end of changeLanguage() .....//


    /**
     * @param Request $request
     * return message array
     * save updated book field
     * @return array
     */
    public function updateField(Request $request): array
    {
        (new LanguageRepository())->updateField($request);

        return ['status' => true, 'message' => __('all.value_saved')];
    }
}//..... end of class.
