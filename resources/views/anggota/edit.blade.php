@extends('layouts.app')

@section('halaman')
<div class="card kartu-fitur p-5 bg-white col-lg-6 mx-auto border-0 shadow-sm" style="border-radius: 15px;">
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark m-0">✏️ Edit Data Anggota</h4>
        <small class="text-muted">Perbarui data identitas anggota PKK jika terjadi kesalahan</small>
    </div>

    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap Anggota</label>
            <input type="text" name="nama_anggota" class="form-control @error('nama_anggota') is-invalid @enderror" value="{{ $anggota->nama_anggota }}" required>
            @error('nama_anggota')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">No. Telepon / WA</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ $anggota->no_telepon }}">
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Alamat Rumah</label>
            <textarea name="alamat" class="form-control" rows="3">{{ $anggota->alamat }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('anggota.index') }}" class="btn btn-light w-50 py-2 fw-bold">Batal</a>
            <button type="submit" class="btn btn-warning w-50 py-2 fw-bold shadow-sm">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection