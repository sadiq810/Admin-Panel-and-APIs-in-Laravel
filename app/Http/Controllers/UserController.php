<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load users main view.
     */
    public function index()
    {
        return view('user.index', ['roles' => Role::pluck('title', 'id')]);
    }//..... end of index() .....//

    /**
     * @return mixed
     * Load users list for dataTables.
     */
    public function loadUsersForDataTable(): mixed
    {
        return (new UserRepository())->dataTable();
    }//..... end of loadUsersForDataTable() ......//

    /**
     * @return array
     * Save record.
     */
    public function save(): array
    {
        if (request()->has('id') and request('id'))
            $validator = Validator::make(request()->all(), [
                'name' => 'required',
                'email' => ['required', Rule::unique('users')->ignore(request()->id)]
            ]);
        else
            $validator = Validator::make(request()->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:5'
            ]);

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new UserRepository())->save();

        return ['status' => true, 'message' => __('all.record_saved')];
    }//..... end of save() .....//

    /**
     * @return array
     * Update single field.
     */
    public function updateField(): array
    {
        return (new UserRepository())->updateField();
    }//..... end of updateField() .....//

    /**
     * @return array
     * Delete user.
     */
    public function delete(): array
    {
        return (new UserRepository())->delete();
    }//..... end of delete() .....//

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load change password view.
     */
    public function loadChangePasswordView()
    {
        return view('user.change_password');
    }//..... end of loadChangePasswordView() ......//

    /**
     * Change password.
     */
    public function changePassword()
    {
        if (!Hash::check(request()->old_password, auth()->user()->password))
            return redirect()->back()->withErrors(['error' => __('all.old_pass_incorrect')]);

        $user = Auth::user();
        $user->password = bcrypt(request('new_password'));
        $user->save();

        session()->flash('success', __('all.pass_changed'));
        return redirect()->back();
    }//..... end of changePassword() ......//
}
