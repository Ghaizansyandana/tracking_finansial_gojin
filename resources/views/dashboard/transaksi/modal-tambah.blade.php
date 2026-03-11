<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Tambah Transaksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.transaksi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul / Keterangan</label>
                        <input type="text" id="judul" name="judul" class="form-control" placeholder="Contoh: Beli Kopi" required />
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select name="tipe" id="tipe" class="form-select" required>
                            <option value="masuk">Pemasukan (+)</option>
                            <option value="keluar">Pengeluaran (-)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="number" id="nominal" name="nominal" class="form-control" placeholder="50000" required />
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="payment_method_id" class="form-label">Metode Pembayaran</label>
                        <select name="payment_method_id" id="payment_method_id" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            @foreach(\App\Models\PaymentMethod::active()->get() as $method)
                            <option value="{{ $method->id }}">{{ $method->name }} ({{ $method->type }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>