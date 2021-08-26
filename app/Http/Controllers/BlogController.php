<?php

namespace App\Http\Controllers;


use App\Repository\BlogRepository;
use App\Repository\CategoryRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * @return Factory|View
     * Load language listing view.
     */
    public function index(): Factory|View
    {
        return view('blog.blogs_list', ['categories' => (new CategoryRepository())->dropdownList()]);
    }

    /**
     * @return mixed
     * Load languages list of datatables.
     */
    public function list(): mixed
    {
        return (new BlogRepository())->dataTable();
    }//..... end of loadLanguages() .....//

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request): array
    {
        $rules = [
            'title'         => 'required',
            'description'   => 'required',
        ];

        $validator = Validator::make($request->all(), $request->language_id ? $rules: array_merge($rules, ['category_id'   => 'required']));

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new BlogRepository())->save();

        return ['status' => true, 'message' => __('all.record_saved')];
    }//..... end of store() ....//

    /**
     * @return array
     */
    public function updateField(): array
    {
        return (new BlogRepository())->updateField();
    }

    /**
     * Remove the specified resource from storage.
     * @param $lng
     * @param $id
     * @return array
     */
    public function destroy($lng, $id): array
    {
        return (new BlogRepository())->delete(id: $id);
    }

    public function detailGrid(): mixed
    {
        return (new BlogRepository())->detailGrid();
    }
}
