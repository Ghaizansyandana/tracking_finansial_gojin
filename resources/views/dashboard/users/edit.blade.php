@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Data User</h5>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bx bx-chevron-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name', $user->name) }}" />
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Alamat Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email', $user->email) }}" />
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">Role</label>
                            <div class="col-sm-10">
                                <select id="role" name="role" class="form-select">
                                    <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-10 offset-sm-2">
                                <div class="alert alert-warning border-0 shadow-none mb-0 py-2" role="alert" style="background-color: #fff8e1; color: #ffab00;">
                                    <small>Catatan: Untuk mengubah password, silakan gunakan fitur "Reset Password" terpisah.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10 text-end">
                                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection