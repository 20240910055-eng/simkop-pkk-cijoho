@extends('layouts.app')

@section('halaman')
<div class="card kartu-fitur p-4 bg-white border-0 shadow-sm">
    <div class="mb-4">
        <h4 class="fw-bold text-dark m-0">📊 Buku Catatan Kas Utama</h4>
        <small class="text-muted">Arus Utama Keuangan Pra Koperasi PKK Kelurahan Cijoho</small>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 12%">Tanggal</th>
                    <th style="width: 40%">Penjelasan / Keterangan Transaksi</th>
                    <th style="width: 16%">Debet (Rp)</th>
                    <th style="width: 16%">Kredit (Rp)</th>
                    <th style="width: 16%">Saldo Berjalan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kas as $k)
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $k->penjelasan }}</td>
                    <td class="text-end text-success">{{ $k->debet > 0 ? number_format($k->debet, 0, ',', '.') : '-' }}</td>
                    <td class="text-end text-danger">{{ $k->kredit > 0 ? number_format($k->kredit, 0, ',', '.') : '-' }}</td>
                    <td class="text-end fw-bold table-primary">Rp {{ number_format($k->saldo_berjalan, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat arus kas masuk atau keluar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection