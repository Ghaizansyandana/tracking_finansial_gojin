@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Manajemen Pengguna</h4>
    @if(session('success'))
    <div class="alert alert-primary alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pengguna Aktif</h5>
            <small class="text-muted float-end">Total: {{ method_exists($users, 'total') ? $users->total() : $users->count() }} User</small>
        </div>

        <div class="card-footer py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    @if(method_exists($users, 'firstItem'))
                        Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
                    @else
                        Menampilkan {{ $users->count() }} data
                    @endif
                </div>
                <div>
                    {{-- Hanya tampilkan links jika $users adalah hasil paginasi --}}
                    @if(method_exists($users, 'links'))
                        {{ $users->links('pagination::bootstrap-5') }}
                    @endif
                </div>
            </div>
        </div>
        
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status Role</th>
                        <th>Ubah Hak Akses</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle bg-label-{{ $user->role == 'admin' ? 'primary' : 'info' }}">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $user->name }}</span>
                                    <small class="text-muted">ID: #{{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-label-primary">
                                    <i class="bx bx-shield-quarter me-1"></i> ADMIN
                                </span>
                            @else
                                <span class="badge bg-label-secondary">
                                    <i class="bx bx-user me-1"></i> USER
                                </span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH') {{-- Pastikan ini ada! --}}
                                
                                <select name="role" onchange="this.form.submit()" class="form-select form-select-sm">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Set User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Set Admin</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="card-footer py-3">
            <div class="d-flex justify-content-between">
                <div class="text-muted">Menampilkan {{ $users->count() }} dari {{ $users->count() }} data</div>
                <div>{{ $users->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection