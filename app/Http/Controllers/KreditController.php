<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Anggota;

class KreditController extends Controller
{
    public function __construct() 
    { 
        $this->middleware('auth'); 
    }

    public function index()
    {
        $kolom_anggota = Schema::hasTable('anggotas') ? Schema::getColumnListing('anggotas') : [];
        
        $kolom_nama = 'id'; 
        if (in_array('nama', $kolom_anggota)) $kolom_nama = 'nama';
        elseif (in_array('nama_lengkap', $kolom_anggota)) $kolom_nama = 'nama_lengkap';
        elseif (in_array('nama_anggota', $kolom_anggota)) $kolom_nama = 'nama_anggota';

        $data_kredit = DB::table('kredits')
            ->leftJoin('anggotas', 'kredits.anggota_id', '=', 'anggotas.id')
            ->select(
                'kredits.anggota_id',
                'kredits.jenis_peminjam',
                
                DB::raw("CASE 
                    WHEN kredits.jenis_peminjam = 'Anggota' THEN anggotas.{$kolom_nama} 
                    ELSE kredits.nama_peminjam_umum 
                END as nama_peminjam"),
                DB::raw('SUM(kredits.nominal_pinjaman) as total_pinjaman'),
                DB::raw('SUM(kredits.nominal_angsuran) as total_angsuran'),
                DB::raw('SUM(kredits.biaya_jasa) as total_jasa'),       // Ambil total jasa dari DB
                DB::raw('SUM(kredits.biaya_provisi) as total_provisi')   // Ambil total provisi dari DB
            )
            ->groupBy('kredits.anggota_id', 'kredits.jenis_peminjam', 'nama_peminjam')
            ->get();

        return view('kredit.index', compact('data_kredit'));
    }

    public function create()
    {
        $kolom_anggota = Schema::hasTable('anggotas') ? Schema::getColumnListing('anggotas') : [];
        $kolom_nama = 'id';
        if (in_array('nama', $kolom_anggota)) $kolom_nama = 'nama';
        elseif (in_array('nama_lengkap', $kolom_anggota)) $kolom_nama = 'nama_lengkap';
        elseif (in_array('nama_anggota', $kolom_anggota)) $kolom_nama = 'nama_anggota';

        $anggota = DB::table('anggotas')->select('id', "{$kolom_nama} as nama")->get();
        
        return view('kredit.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        $jenis = $request->input('jenis_peminjam');
        $pinjaman = $request->input('nominal_pinjaman') ?? 0;
        $angsuran = $request->input('nominal_angsuran') ?? 0;

        $persen_jasa = $request->input('persen_jasa') ?? 0;
        $persen_provisi = $request->input('persen_provisi') ?? 0;

        $rupiah_jasa = ($persen_jasa / 100) * $pinjaman;
        $rupiah_provisi = ($persen_provisi / 100) * $pinjaman;

        $anggota_id = $request->input('anggota_id');
        $tanggal_input = $request->input('tanggal_transaksi') ?? now()->format('Y-m-d');

        if ($jenis === 'Anggota' && empty($anggota_id)) {
            $jenis = 'Umum';
        }

        $jenis_transaksi_form = $request->input('jenis_transaksi');
        $jenis_transaksi_enum = 'pinjaman';

        if (str_contains(strtolower($jenis_transaksi_form), 'angsuran')) {
            $jenis_transaksi_enum = 'angsuran';
        } elseif (str_contains(strtolower($jenis_transaksi_form), 'pinjaman')) {
            $jenis_transaksi_enum = 'pinjaman';
        } else {
            $jenis_transaksi_enum = $jenis_transaksi_form;
        }

        $dataInsert = [
            'anggota_id'         => $jenis === 'Anggota' ? $anggota_id : null,
            'tanggal_transaksi'  => $tanggal_input,
            'jenis_transaksi'    => $jenis_transaksi_enum,
            'nominal_pinjaman'   => $pinjaman,
            'nominal_angsuran'   => $angsuran,
            'biaya_jasa'         => $rupiah_jasa,    
            'biaya_provisi'      => $rupiah_provisi,  
            'created_at'         => now(),
            'updated_at'         => now(),
        ];

        if (Schema::hasColumn('kredits', 'jenis_peminjam')) {
            $dataInsert['jenis_peminjam'] = $jenis;
        }

        if (Schema::hasColumn('kredits', 'nama_peminjam_umum')) {
            $dataInsert['nama_peminjam_umum'] = $jenis === 'Umum' 
                ? ($request->input('nama_peminjam_umum') ?? 'Umum (Tanpa Nama)') 
                : null;
        }

        DB::table('kredits')->insert($dataInsert);

        if ($pinjaman > 0 || $angsuran > 0) {
            $nama_log = $jenis === 'Anggota' 
                ? 'Anggota PKK' 
                : 'Masyarakat Umum (' . ($request->input('nama_peminjam_umum') ?? 'Tanpa Nama') . ')';
            
            $teks_deskripsi = 'Transaksi Kredit ' . $nama_log;

            $kolom_kas = Schema::hasTable('kas') ? Schema::getColumnListing('kas') : [];
            
            $dataKas = [
                'debet'      => $angsuran, 
                'kredit'     => $pinjaman, 
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (in_array('tanggal', $kolom_kas)) {
                $dataKas['tanggal'] = $tanggal_input;
            }

            if (in_array('penjelasan', $kolom_kas)) {
                $dataKas['penjelasan'] = $teks_deskripsi;
            } elseif (in_array('keterangan', $kolom_kas)) {
                $dataKas['keterangan'] = $teks_deskripsi;
            } elseif (in_array('uraian', $kolom_kas)) {
                $dataKas['uraian'] = $teks_deskripsi;
            } elseif (in_array('keterangan_transaksi', $kolom_kas)) {
                $dataKas['keterangan_transaksi'] = $teks_deskripsi;
            }

            DB::table('kas')->insert($dataKas);
        }

        return redirect('/kredit')->with('success', 'Transaksi Kredit Berhasil Disimpan!');
    }
}