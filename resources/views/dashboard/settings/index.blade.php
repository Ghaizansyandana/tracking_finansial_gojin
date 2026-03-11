@extends('layouts.dashboard')

@section('title', 'Pengaturan Sistem')

@push('style')
    <!-- Additional styles for settings page -->
    <style>
        .settings-card {
            transition: all 0.3s ease;
        }
        .settings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Pengaturan /</span> Sistem
        </h4>

        <div class="row">
            <!-- Pengaturan Umum -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card settings-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class='bx bx-cog'></i>
                                </span>
                            </div>
                            <h5 class="mb-0">Umum</h5>
                        </div>
                        <p class="text-muted">Pengaturan dasar aplikasi seperti nama aplikasi, logo, dan informasi kontak.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <!-- Pengaturan Notifikasi -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card settings-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class='bx bx-bell'></i>
                                </span>
                            </div>
                            <h5 class="mb-0">Notifikasi</h5>
                        </div>
                        <p class="text-muted">Kelola preferensi notifikasi email dan sistem.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <!-- Backup & Restore -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card settings-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class='bx bx-cloud-upload'></i>
                                </span>
                            </div>
                            <h5 class="mb-0">Backup & Restore</h5>
                        </div>
                        <p class="text-muted">Buat cadangan data atau pulihkan dari cadangan yang ada.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <!-- Pengguna & Peran -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card settings-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class='bx bx-user'></i>
                                </span>
                            </div>
                            <h5 class="mb-0">Pengguna & Peran</h5>
                        </div>
                        <p class="text-muted">Kelola pengguna, peran, dan izin akses.</p>
                        <a href="{{ route('dashboard.users.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <!-- Integrasi -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card settings-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class='bx bx-plug'></i>
                                </span>
                            </div>
                            <h5 class="mb-0">Integrasi</h5>
                        </div>
                        <p class="text-muted">Kelauar integrasi dengan layanan pihak ketiga.</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card settings-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-secondary">
                                    <i class='bx bx-credit-card'></i>
                                </span>
                            </div>
                            <h5 class="mb-0">Pembayaran</h5>
                        </div>
                        <p class="text-muted">Kelola metode pembayaran dan pengaturan transaksi.</p>
                        <a href="{{ route('dashboard.payment-methods.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Additional scripts for settings page -->
    <script>
        // Add any JavaScript specific to the settings page here
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
