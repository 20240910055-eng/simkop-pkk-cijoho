<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = ['nama_anggota', 'no_telepon', 'alamat'];

    // Relasi ke model Simpanan
    public function simpanan() 
    { 
        return $this->hasMany(Simpanan::class, 'anggota_id'); 
    }

    // Relasi ke model Kredit
    public function kredit() 
    { 
        return $this->hasMany(Kredit::class, 'anggota_id'); 
    }
}