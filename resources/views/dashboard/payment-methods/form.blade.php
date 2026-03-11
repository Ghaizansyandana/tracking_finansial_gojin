<!-- resources/views/dashboard/payment-methods/form.blade.php -->
@php
    $isEdit = isset($paymentMethod);
    $route = $isEdit ? route('dashboard.payment-methods.update', $paymentMethod) : route('dashboard.payment-methods.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ $isEdit ? 'Edit' : 'Tambah' }} Metode Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Metode</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $paymentMethod->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="bank" {{ old('type', $paymentMethod->type ?? '') === 'bank' ? 'selected' : '' }}>Bank</option>
                            <option value="ewallet" {{ old('type', $paymentMethod->type ?? '') === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_name" class="form-label">Nama Akun</label>
                        <input type="text" class="form-control @error('account_name') is-invalid @enderror" 
                               id="account_name" name="account_name" value="{{ old('account_name', $paymentMethod->account_name ?? '') }}" required>
                        @error('account_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_number" class="form-label">Nomor Akun</label>
                        <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                               id="account_number" name="account_number" value="{{ old('account_number', $paymentMethod->account_number ?? '') }}" required>
                        @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', isset($paymentMethod) ? $paymentMethod->is_active : true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Logo</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="logo" class="form-label">Unggah Logo</label>
                        <input class="form-control @error('logo') is-invalid @enderror" type="file" id="logo" name="logo" 
                               onchange="previewImage(this, 'logo-preview')">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="logo-preview" 
                                 src="{{ isset($paymentMethod) && $paymentMethod->logo ? asset('storage/' . $paymentMethod->logo) : '#' }}" 
                                 alt="Logo Preview" 
                                 class="img-thumbnail" 
                                 style="max-width: 100%; display: {{ isset($paymentMethod) && $paymentMethod->logo ? 'block' : 'none' }};">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('dashboard.payment-methods.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
            preview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
@endpush