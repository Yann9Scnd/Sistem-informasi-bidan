<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanFisik;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $query = PemeriksaanFisik::with('pasien');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $pemeriksaan = $query->latest()->paginate(10)->withQueryString();

        return view('pemeriksaan.index', compact('pemeriksaan'));
    }

    public function store(Request $request)
    {
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
            'kesadaran'    => ['required', 'in:Komposmentis,Somnolen,Sopor,Koma'],
            'td_sistolik'  => ['required', 'integer'],
            'td_diastolik' => ['required', 'integer'],
            'nadi'         => ['required', 'integer'],
            'suhu'         => ['required', 'numeric'],
            'nafas_rr'     => ['required', 'integer'],
            'tinggi_badan' => ['required', 'numeric'],
            'berat_badan'  => ['required', 'numeric'],
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
