<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('kredits', function (Blueprint $table) {
        if (!Schema::hasColumn('kredits', 'jenis_peminjam')) {
            $table->string('jenis_peminjam')->default('Anggota')->after('anggota_id');
        }
        if (!Schema::hasColumn('kredits', 'nama_peminjam_umum')) {
            $table->string('nama_peminjam_umum')->nullable()->after('jenis_peminjam');
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('kredits', function (Blueprint $table) {
        $table->dropColumn(['jenis_peminjam', 'nama_peminjam_umum']);
    });
}
};
