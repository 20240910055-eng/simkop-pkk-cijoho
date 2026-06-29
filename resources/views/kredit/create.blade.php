@extends('layouts.app')

@section('halaman')
<div class="p-4 bg-white rounded-3 shadow-sm border mx-auto" style="max-width: 750px;">
    <h4 class="fw-bold text-center mb-1">✍️ Input Transaksi Pinjaman / Angsuran</h4>
    <p class="text-muted text-center small mb-4">Pencatatan kredit untuk anggota PKK maupun masyarakat umum</p>

    <form method="POST" action="{{ url('/kredit') }}">
        @csrf
        
        <div class="mb-3">
            <label class="form-label small fw-bold">Jenis Peminjam</label>
            <select name="jenis_peminjam" id="jenis_peminjam" class="form-select" required onchange="togglePeminjam()">
                <option value="Anggota">Anggota PKK resmi</option>
                <option value="Umum">Masyarakat Umum (Non-Anggota)</option>
            </select>
        </div>

        <div class="mb-3" id="box_anggota">
    <label class="form-label small fw-bold">Pilih Anggota PKK</label>
    <select name="anggota_id" class="form-control">
        <option value="">-- Pilih Anggota --</option>
        @foreach($anggota as $item)
            <option value="{{ $item->id }}">{{ $item->nama }}</option>
        @endforeach
    </select>
</div>
        </div>

        <div class="mb-3 d-none" id="box_umum">
            <label class="form-label small fw-bold">Nama Peminjam (Masyarakat Umum)</label>
            <input type="text" name="nama_peminjam_umum" class="form-control" placeholder="Masukkan nama lengkap masyarakat umum">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Tanggal</label>
                <input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Jenis Transaksi</label>
                <select name="jenis_transaksi" id="jenis_transaksi" class="form-select" required onchange="toggleJenisTransaksi()">
                    <option value="Pemberian Pinjaman Baru">Pemberian Pinjaman Baru</option>
                    <option value="Angsuran">Angsuran</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nominal Pinjaman (Rp)</label>
                <input type="number" name="nominal_pinjaman" id="nominal_pinjaman" class="form-control" value="0">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nominal Angsuran (Rp)</label>
                <input type="number" name="nominal_angsuran" id="nominal_angsuran" class="form-control" value="0" disabled>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Biaya Jasa Pinjaman (%)</label>
                <div class="input-group">
                    <input type="number" step="0.01" name="persen_jasa" id="persen_jasa" class="form-control" value="0" placeholder="Contoh: 1.5">
                    <span class="input-group-text bg-light">%</span>
                </div>
                <div class="form-text text-muted" style="font-size: 0.75rem;">Dihitung otomatis dari Nominal Pinjaman</div>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Biaya Provisi (%)</label>
                <div class="input-group">
                    <input type="number" step="0.01" name="persen_provisi" id="persen_provisi" class="form-control" value="0" placeholder="Contoh: 1">
                    <span class="input-group-text bg-light">%</span>
                </div>
                <div class="form-text text-muted" style="font-size: 0.75rem;">Biaya administrasi penanganan awal</div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Simpan Transaksi Kredit</button>
    </form>
</div>

<script>
function togglePeminjam() {
    var jenis = document.getElementById('jenis_peminjam').value;
    var boxAnggota = document.getElementById('box_anggota');
    var boxUmum = document.getElementById('box_umum');

    if (jenis === 'Anggota') {
        boxAnggota.classList.remove('d-none');
        boxUmum.classList.add('d-none');
    } else {
        boxAnggota.classList.add('d-none');
        boxUmum.classList.remove('d-none');
    }
}

function toggleJenisTransaksi() {
    var jenisTransaksi = document.getElementById('jenis_transaksi').value;
    var inputPinjaman = document.getElementById('nominal_pinjaman');
    var inputAngsuran = document.getElementById('nominal_angsuran');
    var inputJasa = document.getElementById('persen_jasa');
    var inputProvisi = document.getElementById('persen_provisi');

    if (jenisTransaksi === 'Pemberian Pinjaman Baru') {
        // Aktifkan kolom pinjaman, kunci kolom angsuran
        inputPinjaman.disabled = false;
        inputAngsuran.disabled = true;
        inputAngsuran.value = 0; // Reset nilai ke 0 agar tidak ikut terkirim

        // Pinjaman biasanya memakai biaya jasa & provisi
        inputJasa.disabled = false;
        inputProvisi.disabled = false;
    } else {
        // Kunci kolom pinjaman, aktifkan kolom angsuran
        inputPinjaman.disabled = true;
        inputPinjaman.value = 0; // Reset nilai ke 0
        inputAngsuran.disabled = false;

        // Saat mengangsur, umumnya tidak dikenakan provisi/jasa baru lagi
        inputJasa.disabled = true;
        inputJasa.value = 0;
        inputProvisi.disabled = true;
        inputProvisi.value = 0;
    }
}

// Jalankan fungsi saat halaman pertama kali dimuat agar kondisi awal sinkron
window.onload = function() {
    toggleJenisTransaksi();
};
</script>
@endsection