<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kredit extends Model
{
    use HasFactory;

    protected $table = 'kredits';

    // Mendaftarkan semua kolom yang bisa diisi melalui form (Mass Assignment)
    protected $fillable = [
        'anggota_id',
        'jenis_peminjam',
        'nama_peminjam_umum',
        'tanggal_transaksi', 
        'jenis_transaksi',
        'nominal_pinjaman',
        'nominal_angsuran',
        'biaya_jasa',
        'biaya_provisi',
        'pemberian_kredit',
        'angsuran_kredit',
        'jasa_pinjaman',
        'provisi_pinjaman',
    ];
    /**
     * Relasi ke model Anggota
     * Satu data kredit memiliki/milik dari satu Anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}