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
    </div>

    <div class="row mb-4">
        <div class="col-md-12 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @forelse($transaksiTerakhir as $trx)
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-{{ $trx->tipe == 'masuk' ? 'success' : 'danger' }}">
                                    <i class="bx bx-{{ $trx->tipe == 'masuk' ? 'up-arrow-alt' : 'down-arrow-alt' }}"></i>
                                </span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</small>
                                    <h6 class="mb-0">{{ $trx->judul }}</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0 {{ $trx->tipe == 'masuk' ? 'text-success' : 'text-danger' }}">
                                        {{ $trx->tipe == 'masuk' ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                                    </h6>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="text-center text-muted">Belum ada transaksi bulan ini.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Grafik Pemasukan vs Pengeluaran (6 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <div id="transaksiMasukKeluarChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var el = document.querySelector('#transaksiMasukKeluarChart');
        if (!el || typeof ApexCharts === 'undefined') return;

        var labels = @json($labels ?? []);
        var seriesMasuk = @json($seriesMasuk ?? []);
        var seriesKeluar = @json($seriesKeluar ?? []);

        var options = {
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false }
            },
            series: [
                { name: 'Pemasukan', data: seriesMasuk },
                { name: 'Pengeluaran', data: seriesKeluar }
            ],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: { categories: labels },
            yaxis: {
                labels: {
                    formatter: function (val) { return 'Rp ' + (val || 0).toLocaleString('id-ID'); }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) { return 'Rp ' + (val || 0).toLocaleString('id-ID'); }
                }
            },
            colors: ['#696cff', '#ff3e1d'],
            legend: { position: 'top' }
        };

        var chart = new ApexCharts(el, options);
        chart.render();
    })();
</script>
@endpush