<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanFisik;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $pemeriksaan = PemeriksaanFisik::with('pasien')->latest()->paginate(10);
        return view('pemeriksaan.index', compact('pemeriksaan'));
    }

    public function store(Request $request)
    {
        // Handled via AnamnesaController step2
        return redirect()->back();
    }

    public function show(PemeriksaanFisik $pemeriksaan)
    {
        $pemeriksaan->load('pasien');
        return view('pemeriksaan.show', compact('pemeriksaan'));
    }

    public function update(Request $request, PemeriksaanFisik $pemeriksaan)
    {
        $validated = $request->validate([
            'tekanan_darah_sistolik'  => ['required', 'integer'],
            'tekanan_darah_diastolik' => ['required', 'integer'],
            'nadi'                    => ['required', 'integer'],
            'suhu'                    => ['required', 'numeric'],
            'pernapasan'              => ['required', 'integer'],
            'berat_badan'             => ['required', 'numeric'],
            'tinggi_badan'            => ['required', 'numeric'],
        ]);

        $pemeriksaan->update($validated);

        return redirect()->back()->with('success', 'Data pemeriksaan diperbarui.');
    }

    public function destroy(PemeriksaanFisik $pemeriksaan)
    {
        $pemeriksaan->delete();
        return redirect()->back()->with('success', 'Data pemeriksaan dihapus.');
    }
}