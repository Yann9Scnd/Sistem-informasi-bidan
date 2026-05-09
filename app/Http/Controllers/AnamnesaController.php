<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesa;
use App\Models\PemeriksaanFisik;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

class AnamnesaController extends Controller
{
    // ─── PILIH PASIEN ─────────────────────────────────────────────────────

    public function pilihPasien(Request $request)
    {
        $query = Pasien::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('poli')) {
            $query->where('poli', $request->poli);
        }

        $pasien = $query->latest()->paginate(10)->withQueryString();

        return view('pelayanan.pilih-pasien', compact('pasien'));
    }

    // ─── STEP 1: Anamnesa ─────────────────────────────────────────────────────

    public function step1(Pasien $pasien)
    {
        $anamnesa = $pasien->latestAnamnesa;
        return view('anamnesa.step1', compact('pasien', 'anamnesa'));
    }

    public function storeStep1(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nama_petugas'   => ['required', 'string', 'max:100'],
            'keluhan'        => ['required', 'string'],
            'riwayat_pasien' => ['nullable', 'string'],
            'status_hamil'   => ['required', 'in:0,1'],
        ], [
            'nama_petugas.required' => 'Nama petugas wajib diisi.',
            'keluhan.required'      => 'Keluhan wajib diisi.',
        ]);

        $validated['status_hamil'] = (bool) $validated['status_hamil'];

        // Buat record anamnesa baru untuk kunjungan ini
        $pasien->anamnesa()->create($validated);

        return redirect()->route('anamnesa.step2', $pasien)
            ->with('success', 'Anamnesa tersimpan.');
    }

    // ─── STEP 2: Pemeriksaan Fisik ────────────────────────────────────────────

    public function step2(Pasien $pasien)
    {
        if (!$pasien->latestAnamnesa) {
            return redirect()->route('anamnesa.step1', $pasien)
                ->with('error', 'Harap isi Anamnesa terlebih dahulu.');
        }

        $pemeriksaan = $pasien->latestPemeriksaanFisik;
        return view('anamnesa.step2', compact('pasien', 'pemeriksaan'));
    }

    public function storeStep2(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'kesadaran'      => ['required', 'in:Komposmentis,Somnolen,Sopor,Koma'],
            'td_sistolik'    => ['required', 'integer', 'min:50', 'max:300'],
            'td_diastolik'   => ['required', 'integer', 'min:30', 'max:200'],
            'nadi'           => ['required', 'integer', 'min:30', 'max:250'],
            'suhu'           => ['required', 'numeric', 'min:30', 'max:45'],
            'nafas_rr'       => ['required', 'integer', 'min:5', 'max:60'],
            'tinggi_badan'   => ['required', 'numeric', 'min:1', 'max:250'],
            'berat_badan'    => ['required', 'numeric', 'min:0.5', 'max:300'],
            'lingkar_lengan' => ['nullable', 'numeric'],
            'lingkar_perut'  => ['nullable', 'numeric'],
            'anc_terpadu'    => ['required', 'in:Belum,Sudah'],
        ]);

        $pasien->pemeriksaanFisik()->create($validated);

        return redirect()->route('anamnesa.step3', $pasien)
            ->with('success', 'Pemeriksaan Fisik tersimpan.');
    }

    // ─── STEP 3: Diagnosis ────────────────────────────────────────────────────

    public function step3(Pasien $pasien)
    {
        if (!$pasien->latestPemeriksaanFisik) {
            return redirect()->route('anamnesa.step2', $pasien)
                ->with('error', 'Harap isi Pemeriksaan Fisik terlebih dahulu.');
        }

        $diagnosis = $pasien->latestDiagnosis;
        return view('anamnesa.step3', compact('pasien', 'diagnosis'));
    }

    public function storeStep3(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'diagnosa'   => ['required', 'string'],
            'resep_obat' => ['nullable', 'string'],
            'edukasi'    => ['nullable', 'string'],
        ], [
            'diagnosa.required' => 'Diagnosa wajib diisi.',
        ]);

        $pasien->diagnosis()->create($validated);

        return redirect()->route('anamnesa.selesai', $pasien)
            ->with('success', 'Semua pemeriksaan berhasil disimpan! ✅');
    }

    // ─── SELESAI ──────────────────────────────────────────────────────────────

    public function selesai(Pasien $pasien)
    {
        $pasien->load(['latestAnamnesa', 'latestPemeriksaanFisik', 'latestDiagnosis']);
        return view('anamnesa.selesai', compact('pasien'));
    }
}