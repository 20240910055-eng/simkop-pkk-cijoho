@extends('layouts.app')

@section('halaman')
<div class="container-fluid px-4 py-3">
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
        <span class="me-2">✅</span>
        <div><strong>{{ session('success') }}</strong></div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-bold text-dark mb-1">💰 Buku Rekap Kredit & Pinjaman</h4>
                <p class="text-muted small mb-0">Ringkasan akumulasi total pinjaman, total angsuran masuk, dan sisa tunggakan berjalan per orang.</p>
            </div>
            <div>
                <a href="{{ url('/kredit/create') }}" class="btn btn-primary fw-bold px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center">
                    <span class="me-2">+</span> Catat Setoran / Pinjaman Kredit
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 1200px;">
                    <thead class="table-dark text-nowrap">
                        <tr>
                            <th class="ps-4 py-3 text-center" style="width: 60px;">No</th>
                            <th class="py-3">Nama Peminjam</th>
                            <th class="py-3 text-center">Jenis Peminjam</th>
                            <th class="py-3 text-end">Total Pinjaman (Rp)</th>
                            <th class="py-3 text-end">Total Angsuran Masuk (Rp)</th>
                            <th class="py-3 text-end">Total Jasa (Rp)</th>
                            <th class="py-3 text-end">Total Provisi (Rp)</th>
                            <th class="py-3 text-end">Sisa Angsuran / Tunggakan (Rp)</th>
                            <th class="py-3 text-center" style="padding-right: 24px; width: 150px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_kredit as $index => $k)
                        @php
                            // 1. Hitung sisa pokok pinjaman murni
                            $sisa_pokok = $k->total_pinjaman - $k->total_angsuran;

                            // 2. Akumulasikan sisa pokok langsung dengan komponen bunga (jasa + provisi)
                            $sisa_tunggakan_plus_bunga = $sisa_pokok + $k->total_jasa + $k->total_provisi;
                        @endphp
                        <tr class="border-bottom">
                            <td class="ps-4 text-center text-muted small">{{ $index + 1 }}</td>
                            <td>
                                @if($k->jenis_peminjam === 'Anggota')
                                    <a href="{{ url('/anggota/'.$k->anggota_id) }}" class="fw-bold text-decoration-none text-primary">
                                        {{ $k->nama_peminjam ?? 'Tanpa Nama' }}
                                    </a>
                                @else
                                    <span class="fw-bold text-dark">{{ $k->nama_peminjam ?? 'Tanpa Nama' }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($k->jenis_peminjam === 'Anggota')
                                    <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-2 small fw-semibold">Anggota PKK</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-2 small fw-semibold">Masyarakat Umum</span>
                                @endif
                            </td>
                            
                            <td class="text-end fw-semibold text-danger">
                                {{ $k->total_pinjaman > 0 ? number_format($k->total_pinjaman, 0, ',', '.') : '0' }}
                            </td>

                            <td class="text-end fw-semibold text-success">
                                {{ $k->total_angsuran > 0 ? number_format($k->total_angsuran, 0, ',', '.') : '0' }}
                            </td>

                            <td class="text-end fw-semibold text-muted">
                                {{ $k->total_jasa > 0 ? number_format($k->total_jasa, 0, ',', '.') : '0' }}
                            </td>

                            <td class="text-end fw-semibold text-muted">
                                {{ $k->total_provisi > 0 ? number_format($k->total_provisi, 0, ',', '.') : '0' }}
                            </td>

                            @if($sisa_tunggakan_plus_bunga > 0)
                                <td class="text-end fw-bold text-danger" style="background-color: #fff5f5;">
                                    {{ number_format($sisa_tunggakan_plus_bunga, 0, ',', '.') }}
                                </td>
                            @else
                                <td class="text-end fw-bold text-muted">
                                    0
                                </td>
                            @endif

                            <td class="text-center" style="padding-right: 24px;">
                                @if($sisa_tunggakan_plus_bunga > 0)
                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-2">Belum Lunas</span>
                                @else
                                    <span class="badge bg-success fw-bold px-2 py-1 rounded-2">Lunas ✓</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <div class="fs-2 mb-2">📁</div>
                                <p class="mb-0 small fw-semibold">Belum ada riwayat rekap kredit peminjaman.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection