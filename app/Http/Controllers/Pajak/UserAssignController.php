<?php

namespace App\Http\Controllers\Pajak;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserAssignController extends Controller
{

    public function edit(Request $request)
    {
        return view('pajak.user.user-edit')->with([
            'title'   => 'Assign User',
            'user' => User::find($request->id),
            'karyawan' => Employee::where('user_id', null)->orderBy('nama', 'asc')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'userSelect' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $employee       = Employee::find($validator->safe()->userSelect);
            $employee->user_id = $validator->safe()->id;
            $employee->save();
            flash()
                ->success('Profile user berhasil diperbarui')
                ->flash();

            return redirect('pajak-employee/user');
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }

    public function show(Request $request)
    {
        $employee = Employee::find($request->id);
        if (!$employee) {
            return redirect()->back();
        }
        $user = User::find($employee->user_id);
        return view('pajak.user.user-assign-edit')->with([
            'title'   => 'User',
            'employee' => $employee,
            'user' => $user
        ]);
    }

    public function remove(Request $request)
    {
        try {
            $employee = Employee::find($request->id);
            $employee->user_id = null;
            $employee->save();
            flash()
                ->warning('Profile user berhasil dilepas')
                ->flash();
            return redirect()->route('pajak-employee-index');
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();
            return redirect()->route('pajak-employee-index');
        }
    }
}
