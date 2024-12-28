<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AdminUserController extends Controller
{
    //
    public function index(Request $request)
{
    $search = $request->get('search');
    $users = User::query()
        ->where('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->paginate(10);

    return view('layouts.admin_user', compact('users'));
}

public function create()
{
    return view('layouts.create_user');
}

// Xử lý lưu người dùng mới
public function store(Request $request)
{
    // Validate dữ liệu
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
    ]);

    // Tạo người dùng mới
    User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
    ]);

    // Redirect hoặc thông báo thành công
    return redirect()->route('admin.user.create')->with('success', 'User created successfully.');
}
public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('layouts.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }


}
