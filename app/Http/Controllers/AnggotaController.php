<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::withSum('simpanan', 'simpanan_pokok')
            ->withSum('simpanan', 'simpanan_wajib')
            ->withSum('simpanan', 'simpanan_manasuka')
            ->withSum('simpanan', 'ambil_simpanan')
            ->get() ?? [];

        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_anggota' => 'required'
        ]);

        Anggota::create($request->all());
        return redirect()->route('anggota.index')->with('success', 'Anggota PKK Berhasil Didaftarkan!');
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_anggota' => 'required'
        ]);

        $anggota = Anggota::findOrFail($id);
        $anggota->update($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data Anggota Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota Berhasil Dihapus dari Sistem!');
    }

    public function aktivitas($id)
    {
        $anggota = Anggota::with(['simpanan' => function($query) {
            $query->latest();
        }])->findOrFail($id);

        return view('anggota.aktivitas', compact('anggota'));
    }
}