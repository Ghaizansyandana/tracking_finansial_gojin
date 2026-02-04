<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        // Paksa simpan sebagai string manual
        $user->role = (string) $request->role;
        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', 'Role berhasil diperbarui!');
    }
}
