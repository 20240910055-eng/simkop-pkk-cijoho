@extends('layouts.app')

@section('halaman')
<div class="container-fluid px-0">
    
    <div class="card border-0 text-white mb-4 shadow-sm" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); border-radius: 16px;">
        <div class="card-body p-4 p-md-5">
            <span class="badge bg-white text-primary fw-bold mb-2 px-3 py-1.5" style="border-radius: 20px;">🌸 PANEL UTAMA</span>
            <h2 class="fw-bold mb-1">Dashboard Koperasi PKK Cijoho</h2>
            <p class="text-white-50 mb-0 small">Sistem pencatatan kas, simpanan, dan kredit terintegrasi Kelurahan Cijoho.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3 fs-3">👥</div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 11px;">TOTAL ANGGOTA</small>
                        <h5 class="fw-bold text-dark mb-0">{{ $totalAnggota ?? 0 }} Orang</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 me-3 fs-3">💰</div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 11px;">TOTAL SIMPANAN</small>
                        <h5 class="fw-bold text-dark mb-0">{{ $totalSimpanan ?? 0 }} Transaksi</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 me-3 fs-3">📖</div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 11px;">SIRKULASI KREDIT</small>
                        <h5 class="fw-bold text-dark mb-0">{{ $totalKredit ?? 0 }} Kontrak</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3 me-3 fs-3">💵</div>
                    <div>
                        <small class="text-muted d-block fw-semibold" style="font-size: 11px;">SALDO KAS UTAMA</small>
                        <h5 class="fw-bold text-dark mb-0">Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4 bg-white h-100" style="border-radius: 16px;">
                <h5 class="fw-bold text-dark mb-3">📌 Prosedur Pembukuan Admin</h5>
                <div class="d-flex align-items-start mb-3">
                    <div class="badge bg-light text-primary p-2.5 rounded-circle me-3 fw-bold">1</div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Registrasi Anggota</h6>
                        <small class="text-muted">Pastikan identitas warga terdata sebelum melakukan setoran awal simpanan.</small>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-3">
                    <div class="badge bg-light text-success p-2.5 rounded-circle me-3 fw-bold">2</div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Validasi Kas Otomatis</h6>
                        <small class="text-muted">Setiap nominal simpanan masuk atau pencairan kredit akan langsung memotong/menambah saldo Kas Utama.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4 bg-white h-100" style="border-radius: 16px;">
                <h5 class="fw-bold text-dark mb-3">📢 Pengumuman Internal</h5>
                <div class="alert alert-info border-0 p-3 mb-2" style="border-radius: 10px;">
                    <span class="fw-bold d-block text-info-emphasis" style="font-size: 14px;">📅 Rapat Rutin Bulanan</span>
                    <small style="font-size: 12px;">Pelaksanaan rekapitulasi buku tabungan wajib akhir bulan diadakan hari Sabtu esok di Balai Kelurahan.</small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection