<?php
namespace App\Http\Controllers\Dashboard;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // JANGAN pakai User::all(), harus pakai paginate()
        $users = User::latest()->paginate(10); 
        return view('dashboard.users.index', compact('users'));
    }
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
            return $next($request);
        });
    }
    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:admin,petugas',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        Alert::success('Success', 'User created successfully');
        return redirect()->route('dashboard.users.index');
    }

    public function show(string $id)
    {
        //
    }
        
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:admin,member',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('dashboard.users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Alert::success('Success', 'User deleted successfully');
        return redirect()->route('dashboard.users.index');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        // Kita pakai DB update manual untuk memastikan quotes-nya benar jika Eloquent bermasalah
        \DB::table('users')
            ->where('id', $user->id)
            ->update([
                'role' => (string) $request->role,
                'updated_at' => now()
            ]);

        return redirect()->route('dashboard.users.index')->with('success', 'Role berhasil diperbarui!');
    }
}