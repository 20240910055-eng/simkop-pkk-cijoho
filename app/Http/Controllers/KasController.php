<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\Kredit;
use App\Models\Kas;
use Illuminate\Support\Facades\DB; 

class KasController extends Controller
{
    public function dashboard()
    {
        $totalAnggota = DB::table('anggotas')->count();
        $totalSimpanan = DB::table('simpanans')->count(); 
        $totalKredit = DB::table('kredits')->count(); 
        $totalDebet = DB::table('kas')->sum('debet') ?? 0;
        $totalKreditKas = DB::table('kas')->sum('kredit') ?? 0;
        $saldoKas = $totalDebet - $totalKreditKas;
        return view('dashboard', compact('totalAnggota', 'totalSimpanan', 'totalKredit', 'saldoKas'));
    }

    public function index()
    {
        $kas = Kas::orderBy('tanggal', 'asc')->get();
        $saldo = 0;
        foreach($kas as $item) {
            $saldo += ($item->debet - $item->kredit);
            $item->saldo_berjalan = $saldo;
        }

        return view('kas.index', compact('kas'));
    }
}