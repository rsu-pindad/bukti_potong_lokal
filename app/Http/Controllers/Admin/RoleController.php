<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('components.akses.role')->with([
            'title'     => 'Halaman Role',
            'list_role' => Role::paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name|min:5|max:25',
        ]);

        try {
            $role       = new Role;
            $role->name = $validator->safe()->name;
            $role->save();
            toastr()
                ->preventDuplicates(true)
                ->addSuccess('role berhasil di tambahkan');

            redirect()->route('role');
        } catch (\Throwable $th) {
            toastr()
                ->persistent()
                ->preventDuplicates(true)
                ->closeButton()
                ->addError($th->getMessage());

            return back()->withInput();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $role = Role::find($request->id);
            $role->delete();
            toastr()
                ->preventDuplicates(true)
                ->addSuccess('role berhasil di delete');

            redirect()->route('role');
        } catch (\Throwable $th) {
            toastr()
                ->persistent()
                ->preventDuplicates(true)
                ->closeButton()
                ->addError($th->getMessage());

            redirect()->route('role');
        }
    }

    public function edit(Request $request)
    {
        $role = Role::find($request->id);

        return view('components.akses.role-edit')->with([
            'title'     => 'Halaman Edit Role',
            'list_role' => $role,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'min:5',
                'max:25',
                Rule::unique('roles')->ignore($request->id),
            ],
        ]);

        try {
            $role       = Role::find($request->id);
            $role->name = $validator->safe()->name;
            $role->save();
            toastr()
                ->preventDuplicates(true)
                ->addSuccess('role berhasil diperbarui');

            return redirect()->route('role');
        } catch (\Throwable $th) {
            toastr()
                ->persistent()
                ->preventDuplicates(true)
                ->closeButton()
                ->addError($th->getMessage());

            return back()->withInput();
        }
    }

    public function showPermission(Request $request)
    {
        $role       = Role::find($request->id);
        $permission = Permission::get();

        return view('components.akses.role-assign-permission')->with([
            'title'               => 'Pilih permision pada role',
            'role'                => $role,
            'list_permission'     => $permission,
            'role_has_permission' => $role->permissions->pluck('name')
        ]);
    }

    public function assignPermission(Request $request)
    {
        try {
            $role = Role::find($request->id);
            $role->syncPermissions($request->input('permisi'));

            toastr()
                ->preventDuplicates(true)
                ->addSuccess('permisi berhasil diberikan');

            return redirect()->route('role');
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
