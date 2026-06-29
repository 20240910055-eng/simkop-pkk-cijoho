<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaksaTambahKolomKredit extends Migration
{
    public function up()
    {
        Schema::table('kredits', function (Blueprint $table) {
            // 1. Cek & Tambah Jenis Peminjam
            if (!Schema::hasColumn('kredits', 'jenis_peminjam')) {
                $table->string('jenis_peminjam')->default('Anggota')->after('id');
            }
            // 2. Cek & Tambah Nama Peminjam Umum
            if (!Schema::hasColumn('kredits', 'nama_peminjam_umum')) {
                $table->string('nama_peminjam_umum')->nullable()->after('jenis_peminjam');
            }
            // 3. Cek & Tambah Tanggal Transaksi (Ini yang bikin error sekarang)
            if (!Schema::hasColumn('kredits', 'tanggal_transaksi')) {
                $table->date('tanggal_transaksi')->nullable()->after('nama_peminjam_umum');
            }
            // 4. Cek & Tambah Jenis Transaksi
            if (!Schema::hasColumn('kredits', 'jenis_transaksi')) {
                $table->string('jenis_transaksi')->nullable()->after('tanggal_transaksi');
            }
            // 5. Cek & Tambah Nominal Pinjaman
            if (!Schema::hasColumn('kredits', 'nominal_pinjaman')) {
                $table->bigInteger('nominal_pinjaman')->default(0)->after('jenis_transaksi');
            }
            // 6. Cek & Tambah Nominal Angsuran
            if (!Schema::hasColumn('kredits', 'nominal_angsuran')) {
                $table->bigInteger('nominal_angsuran')->default(0)->after('nominal_pinjaman');
            }
        });
    }

    public function down()
    {
        Schema::table('kredits', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_peminjam', 
                'nama_peminjam_umum', 
                'tanggal_transaksi', 
                'jenis_transaksi', 
                'nominal_pinjaman', 
                'nominal_angsuran'
            ]);
        });
    }
}