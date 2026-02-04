@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <h5 class="card-title text-primary">Halo, {{ $user->name }}! 👋</h5>
                            <p class="mb-4">
                                Hari ini total saldo dari semua akun keuangan kamu adalah 
                                <span class="fw-bold text-success">Rp {{ number_format($totalSaldo) }}</span>. 
                                Pantau terus pengeluaranmu!
                            </p>
                            <a href="{{ route('dashboard.transaksi.create') }}" class="btn btn-sm btn-outline-primary">Catat Transaksi</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="View Badge User" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Pemasukan</span>
                            <h4 class="card-title mb-2 text-success">Rp {{ number_format($pemasukanBulanIni) }}</h4>
                            <small class="text-muted">Bulan ini</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Pengeluaran</span>
                            <h4 class="card-title mb-2 text-danger">Rp {{ number_format($pengeluaranBulanIni) }}</h4>
                            <small class="text-muted">Bulan ini</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach($transaksiTerakhir as $trx)
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-{{ $trx->jenis == 'pemasukan' ? 'success' : 'danger' }}">
                                    <i class="bx bx-{{ $trx->jenis == 'pemasukan' ? 'up' : 'down' }}-arrow-alt"></i>
                                </span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                <small class="text-muted d-block mb-1">Kategori</small>
                                <h6 class="mb-0">{{ $trx->keterangan ?? 'Tanpa keterangan' }}</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0 {{ $trx->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                        {{ $trx->jenis == 'pemasukan' ? '+' : '-' }} {{ number_format($trx->jumlah) }}
                                    </h6>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        </div>
</div>
@endsection