@extends('layouts.app')

@section('halaman')
<div class="card kartu-fitur p-4 bg-white border-0 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark m-0">💰 Buku Simpanan Anggota (Rekap Per Orang)</h4>
            <small class="text-muted">Akumulasi saldo Tabungan Pokok, Wajib, dan Sukarela PKK Cijoho</small>
        </div>
        <a href="{{ route('simpanan.create') }}" class="btn btn-primary fw-bold shadow-sm">+ Catat Setoran Simpanan</a>
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
                    <th>Pokok (Rp)</th>
                    <th>Wajib (Rp)</th>
                    <th>Manasuka (Rp)</th>
                    <th class="text-danger">Ambil Simpanan (Rp)</th>
                    <th style="background-color: #198754; color: #ffffff;">Saldo Akhir Bersih (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data_simpanan as $index => $s)
                @php
                    // Rumus: (Total Pokok + Total Wajib + Total Manasuka) - Total Ambil Simpanan
                    $total_masuk = $s->total_pokok + $s->total_wajib + $s->total_manasuka;
                    $saldo_bersih = $total_masuk - $s->total_ambil;
                @endphp
                <tr>
                    <td class="text-center text-muted small">{{ $index + 1 }}</td>
                    <td>
                        <a href="{{ url('/anggota/'.$s->anggota_id) }}" class="fw-bold text-decoration-none text-primary">
                            {{ $s->nama_anggota ?? 'Anggota Terhapus' }}
                        </a>
                    </td>
                    
                    <td class="text-end">
                        {{ $s->total_pokok > 0 ? number_format($s->total_pokok, 0, ',', '.') : '0' }}
                    </td>
                    
                    <td class="text-end">
                        {{ $s->total_wajib > 0 ? number_format($s->total_wajib, 0, ',', '.') : '0' }}
                    </td>
                    
                    <td class="text-end">
                        {{ $s->total_manasuka > 0 ? number_format($s->total_manasuka, 0, ',', '.') : '0' }}
                    </td>
                    
                    <td class="text-end fw-semibold text-danger">
                        {{ $s->total_ambil > 0 ? number_format($s->total_ambil, 0, ',', '.') : '0' }}
                    </td>

                    <td class="text-end fw-bold text-success" style="background-color: #f4faf3;">
                        {{ number_format($saldo_bersih, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada catatan setoran simpanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection