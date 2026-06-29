@extends('layouts.app')

@section('halaman')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card kartu-fitur p-4 bg-white border-0 shadow-sm">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark m-0">💰 Catat Setoran Simpanan</h4>
                <small class="text-muted">Pilih nama anggota dan masukkan nominal tabungan sesuai buku fisik</small>
            </div>

            <!-- Tampilan Pesan Error Manipulasi Backend -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('simpanan.store') }}" method="POST">
                @csrf
                
                <!-- Pilihan Nama Anggota -->
                <div class="mb-3">
                    <label class="fw-bold text-dark mb-1">Nama Anggota PKK</label>
                    <select name="anggota_id" class="form-select" required>
                        <option value="">-- Pilih Anggota PKK --</option>
                        @foreach($anggota as $a)
                            <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                {{ $a->nama_anggota }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Setor -->
                <div class="mb-3">
                    <label class="fw-bold text-dark mb-1">Tanggal Setor</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>

                <div class="row">
                    <!-- Simpanan Pokok -->
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-dark mb-1">Simpanan Pokok (Rp)</label>
                        <input type="text" name="simpanan_pokok" id="simpanan_pokok" class="form-control" value="{{ old('simpanan_pokok', 0) }}">
                        <small id="pesan_pokok" class="form-text d-block mt-1"></small>
                    </div>

                    <!-- Simpanan Wajib -->
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-dark mb-1">Simpanan Wajib (Rp)</label>
                        <input type="text" name="simpanan_wajib" class="form-control" value="{{ old('simpanan_wajib', 0) }}">
                    </div>
                </div>

                <div class="row">
                    <!-- Manasuka / Sukarela -->
                    <div class="col-md-6 mb-4">
                        <label class="fw-bold text-dark mb-1">Manasuka / Sukarela (Rp)</label>
                        <input type="text" name="simpanan_manasuka" class="form-control" placeholder="Masukkan nominal..." value="{{ old('simpanan_manasuka') }}">
                    </div>

                    <!-- Ambil Simpanan -->
                    <div class="col-md-6 mb-4">
                        <label class="fw-bold text-dark mb-1">Ambil Simpanan (Rp)</label>
                        <input type="text" name="ambil_simpanan" class="form-control" value="{{ old('ambil_simpanan', 0) }}">
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('simpanan.index') }}" class="btn btn-light fw-bold px-4 border">Kembali</a>
                    <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">Simpan Tabungan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- LOGIKAJAVASCRIPT DETEKSI ANGGOTA SECARA REALTIME -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAnggota = document.querySelector('select[name="anggota_id"]');
    const inputPokok = document.getElementById('simpanan_pokok');
    const pesanPokok = document.getElementById('pesan_pokok');

    function periksaStatusPokok() {
        const anggotaId = selectAnggota.value;

        if (!anggotaId) {
            inputPokok.disabled = false;
            pesanPokok.textContent = "";
            return;
        }

        // Panggil internal API Laravel menggunakan fetch data browser
        fetch(`/simpanan/cek-pokok/${anggotaId}`)
            .then(response => response.json())
            .then(data => {
                if (data.sudah_bayar) {
                    // Jika data terdeteksi sudah lunas: kunci inputan dan paksa jadi 0
                    inputPokok.disabled = true;
                    inputPokok.value = "0";
                    pesanPokok.textContent = "✓ Anggota ini sudah melunasi Simpanan Pokok awal.";
                    pesanPokok.className = "form-text text-success fw-bold";
                } else {
                    // Jika anggota baru: buka kunci inputan
                    inputPokok.disabled = false;
                    pesanPokok.textContent = "⚠️ Anggota baru wajib mengisi nominal Simpanan Pokok.";
                    pesanPokok.className = "form-text text-warning fw-bold";
                }
            })
            .catch(error => console.error('Gagal memproses validasi pokok:', error));
    }

    // Jalankan fungsi setiap kali pilihan dropdown nama anggota diubah
    selectAnggota.addEventListener('change', periksaStatusPokok);
    
    // Jalankan juga saat halaman pertama kali dibuka (untuk menangani error old validation)
    if(selectAnggota.value) {
        periksaStatusPokok();
    }
});
</script>
@endsection