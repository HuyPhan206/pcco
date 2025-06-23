<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::where('is_staff', true)->with('roles')->get();
        return view('admin.staff.index', compact('staffs'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.staff.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_staff' => true,
        ]);

        $user->roles()->attach($request->roles);

        return redirect()->route('admin.staff.index')->with('success', 'Thêm nhân viên thành công.');
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.staff.edit', compact('staff', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'roles' => 'required|array',
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $staff->roles()->sync($request->roles);

        return redirect()->route('admin.staff.index')->with('success', 'Cập nhật nhân viên thành công.');
    }

    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->roles()->detach();
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Xóa nhân viên thành công.');
    }
}
