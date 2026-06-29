@extends('layouts.app')

@section('halaman')
<div class="mb-3">
    <a href="{{ route('anggota.index') }}" class="btn btn-secondary btn-sm fw-bold">← Kembali ke Daftar Anggota</a>
</div>

<div class="card kartu-fitur p-4 bg-white border-0 shadow-sm mb-4">
    <div class="border-bottom pb-3 mb-4">
        <span class="badge bg-primary mb-2">Profil Anggota PKK</span>
        <h3 class="fw-bold text-dark m-0">👤 {{ $anggota->nama_anggota }}</h3>
        <p class="text-muted m-0 mt-1">
            <strong>No. Telepon:</strong> {{ $anggota->no_telepon ?? '-' }} | 
            <strong>Alamat:</strong> {{ $anggota->alamat ?? '-' }}
        </p>
    </div>

    <h5 class="fw-bold text-dark mb-3">🕒 Log Aktivitas Riwayat Transaksi</h5>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 15%">Tanggal</th>
                    <th>Jenis Aktivitas / Keterangan</th>
                    <th>Nominal Transaksi (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php $hasActivity = false; @endphp
                
                @foreach($anggota->simpanan as $s)
                    @php $hasActivity = true; @endphp
                    
                    @if(($s->simpanan_pokok + $s->simpanan_wajib + $s->simpanan_manasuka) > 0)
                    <tr>
                        <td class="text-center text-muted">{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-success me-2">SETORAN</span> 
                            Menambahkan saldo tabungan 
                            (Pokok: {{ number_format($s->simpanan_pokok, 0, ',', '.') }}, 
                            Wajib: {{ number_format($s->simpanan_wajib, 0, ',', '.') }}, 
                            Sukarela: {{ number_format($s->simpanan_manasuka, 0, ',', '.') }})
                        </td>
                        <td class="text-end fw-bold text-success">
                            + {{ number_format(($s->simpanan_pokok + $s->simpanan_wajib + $s->simpanan_manasuka), 0, ',', '.') }}
                        </td>
                    </tr>
                    @endif

                    @if($s->ambil_simpanan > 0)
                    <tr>
                        <td class="text-center text-muted">{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-danger me-2">PENARIKAN</span> 
                            Melakukan pengambilan / penarikan dana simpanan buku fisik
                        </td>
                        <td class="text-end fw-bold text-danger">
                            - {{ number_format($s->ambil_simpanan, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endif
                @endforeach

                @if(!$hasActivity)
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">Anggota ini belum pernah melakukan aktivitas transaksi apa pun.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection