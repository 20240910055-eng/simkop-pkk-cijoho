<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $totalAnggota = DB::table('anggotas')->count();
        $totalSimpanan = DB::table('simpanans')->count(); 
        $totalKredit = DB::table('kredits')->count(); 
        $totalDebet = DB::table('kas')->sum('debet') ?? 0;
        $totalKreditKas = DB::table('kas')->sum('kredit') ?? 0;
        $saldoKas = $totalDebet - $totalKreditKas;
        return view('dashboard', compact('totalAnggota', 'totalSimpanan', 'totalKredit', 'saldoKas'));
    }
}