<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanans';

    // Mengizinkan semua kolom masuk tanpa filter pengisian massal Eloquent
    protected $guarded = [];

    public function anggota() 
    { 
        return $this->belongsTo(Anggota::class, 'anggota_id'); 
    }
}