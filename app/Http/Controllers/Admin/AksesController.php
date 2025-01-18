<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class AksesController extends Controller
{
    public function index()
    {
        return view('components.akses.akses')->with([
            'title' => 'Halaman Akses',
            'list_akses' => User::with([
                'roles' => function ($roles) {
                    return $roles->select('roles.name');
                }
            ])
            ->select(['id','username'])
            ->paginate(5),
        ]);
    }

    public function showRole(Request $request)
    {
        $user = User::find($request->id);
        $role = Role::get();

        return view('components.akses.akses-assign-role')->with([
            'title'      => 'Pilih role untuk user',
            'user'       => $user,
            'list_roles' => $role,
            // 'user_has_role' => $user->role->pluck('name')
        ]);
    }

    public function assignRole(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->syncRoles($request->input('role'));

            toastr()
                ->preventDuplicates(true)
                ->addSuccess('role berhasil diberikan');

            return redirect()->route('akses');
        } catch (\Throwable $th) {
            toastr()
                ->persistent()
                ->preventDuplicates(true)
                ->closeButton()
                ->addError($th->getMessage());

            return back()->withInput();
        }
    }
}
