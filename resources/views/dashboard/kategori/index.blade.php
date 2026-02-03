@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">Kategori Keuangan</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
            <i class="bx bx-plus"></i> Tambah Kategori
        </button>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($kategoris as $k)
                    <tr>
                        <td><strong>{{ $k->nama }}</strong></td>
                        <td>
                            <span class="badge {{ $k->tipe == 'pemasukan' ? 'bg-label-success' : 'bg-label-danger' }}">
                                {{ ucfirst($k->tipe) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.kategori.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('dashboard.kategori.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control" placeholder="Misal: Makan, Gaji, Listrik" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe</label>
                    <select name="tipe" class="form-select">
                        <option value="pengeluaran">Pengeluaran</option>
                        <option value="pemasukan">Pemasukan</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection