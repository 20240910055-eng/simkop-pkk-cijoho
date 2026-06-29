@extends('layouts.app')

@section('halaman')
<div class="card kartu-fitur p-5 bg-white col-lg-6 mx-auto border-0 shadow-sm" style="border-radius: 15px;">
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark m-0">✍️ Formulir Anggota Baru</h4>
        <small class="text-muted">Masukkan data identitas anggota PKK dengan benar</small>
    </div>

    <form action="{{ route('anggota.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap Anggota</label>
            <input type="text" name="nama_anggota" class="form-control @error('nama_anggota') is-invalid @enderror" placeholder="Contoh: Ny. Itah" required>
            @error('nama_anggota')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">No. Telepon / WA (Opsional)</label>
            <input type="text" name="no_telepon" class="form-control" placeholder="Contoh: 081234xxxxxx">
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Alamat Rumah (Opsional)</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh: RT 02 / RW 01, Lingkungan Cijoho"></textarea>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('anggota.index') }}" class="btn btn-light w-50 py-2 fw-bold">Kembali</a>
            <button type="submit" class="btn btn-success w-50 py-2 fw-bold shadow-sm">Daftarkan Anggota</button>
        </div>
    </form>
</div>
@endsection