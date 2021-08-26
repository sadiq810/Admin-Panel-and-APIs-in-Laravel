<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\RoleMenu;
use App\Repository\RoleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public function index()
    {
        return view('role.index');
    }

    public function list(): mixed
    {
        return (new RoleRepository())->dataTable();
    }

    public function updateField(): array
    {
        return (new RoleRepository())->updateField();
    }

    public function save(): array
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

        (new RoleRepository())->save();

        return ['status' => true, 'message' => __('all.record_saved')];
    }

    public function delete($lang, $id): array
    {
        return (new RoleRepository())->delete($id);
    }

    public function roleMenus(Request $request): Factory|View|Application
    {
        return view('role.role_menu', [
            'role_id'    => $request->role_id,
            'role_menus' => RoleMenu::where('role_id', $request->role_id)->pluck('menu_id'),
            'menus'      => Menu::all()]);
    }

    public function saveRoleMenus(): array
    {
        return (new RoleRepository())->saveRoleMenus();
    }
}
