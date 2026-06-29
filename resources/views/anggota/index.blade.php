@extends('layouts.app')

@section('halaman')
<div class="card kartu-fitur p-4 bg-white border-0 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark m-0">👥 Daftar Anggota PKK</h4>
            <small class="text-muted">Manajemen Data Anggota Koperasi Kelurahan Cijoho</small>
        </div>
        <a href="{{ route('anggota.create') }}" class="btn btn-primary fw-bold shadow-sm">+ Tambah Anggota Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama Anggota</th>
                    <th>No. Telepon / WA</th>
                    <th>Alamat Rumah</th>
                    <th>Saldo Simpanan (Rp)</th>
                    <th style="width: 28%">Aksi</th> </tr>
            </thead>
            <tbody>
                @forelse($anggota as $index => $a)
                @php
                    $pokok    = $a->simpanan_sum_simpanan_pokok ?? 0;
                    $wajib    = $a->simpanan_sum_simpanan_wajib ?? 0;
                    $manasuka = $a->simpanan_sum_simpanan_manasuka ?? 0;
                    $ambil    = $a->simpanan_sum_ambil_simpanan ?? 0;

                    $saldo_simpanan = ($pokok + $wajib + $manasuka) - $ambil;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="fw-bold text-primary">{{ $a->nama_anggota }}</td>
                    <td>{{ $a->no_telepon ?? '-' }}</td>
                    <td>{{ $a->alamat ?? '-' }}</td>
                    
                    <td class="text-end fw-bold text-success" style="background-color: #f8f9fa;">
                        {{ number_format($saldo_simpanan, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        <a href="{{ route('anggota.aktivitas', $a->id) }}" class="btn btn-info btn-sm fw-bold text-white me-1">👁️ Aktivitas</a>
                        
                        <a href="{{ route('anggota.edit', $a->id) }}" class="btn btn-warning btn-sm fw-bold me-1">✏️ Edit</a>
                        
                        <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm fw-bold">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada anggota PKK yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection