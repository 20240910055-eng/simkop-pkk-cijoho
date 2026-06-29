<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('kredits', function (Blueprint $table) {
        $table->id();
        $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
        $table->date('tanggal_transaksi');
        $table->enum('jenis_transaksi', ['pinjaman', 'angsuran']);
        $table->integer('pemberian_kredit')->default(0);
        $table->integer('angsuran_kredit')->default(0);
        $table->integer('jasa_pinjaman')->default(0);
        $table->integer('provisi_pinjaman')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kredits');
    }
};
