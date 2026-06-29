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
    Schema::create('anggotas', function (Blueprint $table) {
        $table->id();
        $table->string('nama'); // <-- PASTIKAN TERTULIS 'nama' SEPERTI INI
        $table->string('no_anggota')->unique();
        $table->string('telepon')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
