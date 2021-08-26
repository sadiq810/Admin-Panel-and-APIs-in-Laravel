<?php


namespace App\Repository;


use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleRepository extends Repository
{
    public function dataTable(): mixed
    {
        return Datatables::of(Role::query())
            ->addColumn('action', fn () => '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a> |
                                    <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a> |
                                    <a href="javascript:void(0)" class="assignMenus btn btn-round btn-primary btn-sm" title="'.__('all.assign_menus').'"><i class="fa fa-list"></i></a>')
            ->rawColumns(['action'])->make(true);
    }

    public function updateField(): array
    {
        Role::where(['id' => request()->pk])->update([request()->name => request()->value]);
        return ['status' => true, 'message' => __('all.value_saved')];
    }

    public function save(): Role
    {
        $role = Role::updateOrCreate(['id' => request('id')], request()->only('title'));

        return $role;
    }

    public function delete($id): array
    {
        $status = Role::destroy($id);
        return ['status' => !!$status, 'message' => $status ? __('all.record_deleted') : __('all.incomplete_action')];
    }

    public function saveRoleMenus(): array
    {
        $role = Role::findOrFail(request()->role_id);
        $role->menus()->sync(request()->menu);

        return ['status' => true, 'message' => __('all.value_saved')];
    }
}
