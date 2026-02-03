@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('dashboard.transaksi.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" 
                            name="tanggal" 
                            class="form-control" 
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{-- Otomatis hari ini --}}
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis</label>
                        <select name="jenis" class="form-select" required>
                            <option value="pengeluaran">Pengeluaran (Saldo Berkurang)</option>
                            <option value="pemasukan">Pemasukan (Saldo Bertambah)</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilih Akun/Dompet</label>
                        <select name="akun_id" class="form-select" required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach($akuns as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->nama_akun }} (Sisa: Rp {{ number_format($akun->saldo_saat_ini) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }} ({{ ucfirst($kat->tipe) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah (Rp)</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="jumlah" class="form-control" placeholder="10000" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan (Opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Beli bensin, bayar kos, dll"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection