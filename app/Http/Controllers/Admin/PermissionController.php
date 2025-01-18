<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return view('components.akses.permission')->with([
            'title'           => 'Halaman Permisi',
            'list_permission' => Permission::paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name|min:5|max:25',
        ]);

        try {
            $permission       = new Permission;
            $permission->name = $validator->safe()->name;
            $permission->save();
            toastr()
                ->preventDuplicates(true)
                ->addSuccess('permisi berhasil di tambahkan');

            return redirect()->back();
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
            $permission = Permission::find($request->id);
            $permission->delete();
            toastr()
                ->preventDuplicates(true)
                ->addSuccess('permisi berhasil di delete');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()
                ->persistent()
                ->preventDuplicates(true)
                ->closeButton()
                ->addError($th->getMessage());

            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        $permission = Permission::find($request->id);

        return view('components.akses.permission-edit')->with([
            'title'           => 'Halaman Edit Permisi',
            'list_permission' => $permission,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|unique:permissions,name|min:5|max:25',
            'name' => [
                'required',
                'string',
                'min:5',
                'max:25',
                Rule::unique('permissions')->ignore($request->id),
            ]
        ]);

        try {
            $permission       = Permission::find($request->id);
            $permission->name = $validator->safe()->name;
            $permission->save();
            toastr()
                ->preventDuplicates(true)
                ->addSuccess('permisi berhasil diperbarui');

            return redirect()->back();
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
