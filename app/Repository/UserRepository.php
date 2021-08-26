<?php


namespace App\Repository;


use App\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserRepository
{
    public function save(): User
    {
        $data = request()->only(['name', 'email', 'role_id']);

        if (request()->has('password') and request('password'))
            $data['password'] = bcrypt(request()->password);

        return User::updateOrCreate(['id' => request()->id], $data);
    }

    public function updateField(): array
    {
        $ids = explode('_', request()->pk);

        switch (request('name')) {
            case 'name':
                User::where(['id' => $ids[0]])->update([request()->name => request()->value]);
            case 'email':
                $validator = Validator::make(request()->all(), [
                    'value' => 'required|unique:users,email,' . request('id')
                ]);

                if ($validator->fails())
                    return ['status' => false, 'message' => implode(' ', $validator->errors()->all())];

                User::where(['id' => $ids[0]])->update([request()->name => request()->value]);
                break;
            default:
                return ['status' => false, 'message' => __('all.action_not_recognized')];
        }//..... end of switch() .....//

        return ['status' => true, 'message' => __('all.value_saved')];
    }

    public function delete(): array
    {
        $status = User::destroy(request()->id);

        return ['status' => !!$status, 'message' => $status ? __('all.record_deleted') : __('all.incomplete_action')];
    }

    public function dataTable()
    {
        return Datatables::of(User::with('role'))
            ->addColumn('role_title', function ($user) {
                return $user->role?->title;
            })->addColumn('action', function ($user) {
                return /*$user->id == auth()->user()->id ? '' :*/ '<a href="javascript:void(0)" class="edit btn btn-round btn-info btn-sm"><i class="fa fa-edit"></i></a> | <a href="javascript:void(0)" class="delete btn btn-round btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })->rawColumns(['action'])->make(true);
    }
}
