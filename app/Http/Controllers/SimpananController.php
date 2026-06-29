<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota;
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SimpananController extends Controller
{
    public function __construct() 
    { 
        $this->middleware('auth'); 
    }

    // 1. Tampilan Halaman Rekap Buku Simpanan (REKAP PER ORANG)
    public function index()
    {
        // Deteksi nama kolom di tabel anggotas untuk menghindari error SQL jika ada perbedaan nama field
        $kolom_anggota = Schema::hasTable('anggotas') ? Schema::getColumnListing('anggotas') : [];
        $kolom_nama = 'id';
        if (in_array('nama', $kolom_anggota)) $kolom_nama = 'nama';
        elseif (in_array('nama_lengkap', $kolom_anggota)) $kolom_nama = 'nama_lengkap';
        elseif (in_array('nama_anggota', $kolom_anggota)) $kolom_nama = 'nama_anggota';

        // Mengelompokkan nominal tabungan dan penarikan secara akumulatif per anggota
        $data_simpanan = DB::table('simpanans')
            ->join('anggotas', 'simpanans.anggota_id', '=', 'anggotas.id')
            ->select(
                'simpanans.anggota_id',
                "anggotas.{$kolom_nama} as nama_anggota",
                DB::raw('SUM(simpanans.simpanan_pokok) as total_pokok'),
                DB::raw('SUM(simpanans.simpanan_wajib) as total_wajib'),
                DB::raw('SUM(simpanans.simpanan_manasuka) as total_manasuka'),
                DB::raw('SUM(simpanans.ambil_simpanan) as total_ambil')
            )
            ->groupBy('simpanans.anggota_id', 'nama_anggota')
            ->get();

        return view('simpanan.index', compact('data_simpanan'));
    }

    // 2. Tampilan Form Input Transaksi Simpanan
    public function create()
    {
        $anggota = Anggota::all();
        return view('simpanan.create', compact('anggota'));
    }

    // 3. Mengecek apakah anggota sudah pernah membayar simpanan pokok (Fitur Proteksi Asli Anda)
    public function cekStatusPokok($anggota_id)
    {
        $sudah_bayar = DB::table('simpanans')
            ->where('anggota_id', $anggota_id)
            ->where('simpanan_pokok', '>', 0)
            ->exists();

        return response()->json(['sudah_bayar' => $sudah_bayar]);
    }

    // 4. Proses Simpan Data & Otomatis Mutasi Kas Utama
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'tanggal'    => 'required|date',
        ]);

        $pokok    = (int) preg_replace('/[^0-9]/', '', $request->simpanan_pokok ?? 0);
        $wajib    = (int) preg_replace('/[^0-9]/', '', $request->simpanan_wajib ?? 0);
        $manasuka = (int) preg_replace('/[^0-9]/', '', $request->simpanan_manasuka ?? 0);
        $ambil    = (int) preg_replace('/[^0-9]/', '', $request->ambil_simpanan ?? 0);

        // PROTEKSI DATA: Mencegah manipulasi input dari backend jika sudah pernah bayar (Asli Anda)
        if ($pokok > 0) {
            $cek = DB::table('simpanans')
                ->where('anggota_id', $request->anggota_id)
                ->where('simpanan_pokok', '>', 0)
                ->exists();
                
            if ($cek) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal! Anggota ini sudah pernah melunasi Simpanan Pokok awal.');
            }
        }

        // Menyimpan data murni transaksi ke database tabel simpanans
        DB::table('simpanans')->insert([
            'anggota_id'        => $request->anggota_id,
            'tanggal'           => $request->tanggal,
            'simpanan_pokok'    => $pokok,
            'simpanan_wajib'    => $wajib,
            'simpanan_manasuka' => $manasuka,
            'ambil_simpanan'    => $ambil, 
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // Ambil data anggota untuk keperluan penulisan log di Buku Kas Utama
        $anggota = DB::table('anggotas')->where('id', $request->anggota_id)->first();
        $nama_anggota = $anggota ? ($anggota->nama_anggota ?? $anggota->nama ?? 'Anggota') : 'Anggota';

        // Alur otomatisasi pencatatan Buku Kas Utama (Asli Anda)
        $total_masuk = $pokok + $wajib + $manasuka;
        if ($total_masuk > 0) {
            Kas::create([
                'tanggal'    => $request->tanggal,
                'penjelasan' => "Simpanan Buku Tabungan: " . $nama_anggota,
                'debet'      => $total_masuk,
                'kredit'     => 0
            ]);
        }

        if ($ambil > 0) {
            Kas::create([
                'tanggal'    => $request->tanggal,
                'penjelasan' => "Penarikan / Ambil Simpanan: " . $nama_anggota,
                'debet'      => 0,
                'kredit'     => $ambil
            ]);
        }

        return redirect()->route('simpanan.index')->with('success', 'Catatan Simpanan Berhasil Ditambahkan!');
    }
}