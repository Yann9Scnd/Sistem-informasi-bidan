<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesa;
use App\Models\PemeriksaanFisik;
use App\Models\PemeriksaanLainnya;
use Illuminate\Http\Request;

class AnamnesaController extends Controller
{
    // ─── STEP 1: Anamnesa ─────────────────────────────────────────────────────

    public function step1(Pasien $pasien)
    {
        $anamnesa = $pasien->anamnesa;
        return view('anamnesa.step1', compact('pasien', 'anamnesa'));
    }

    public function storeStep1(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'keluhan_utama'     => ['required', 'string'],
            'riwayat_penyakit'  => ['nullable', 'string'],
            'riwayat_keluarga'  => ['nullable', 'string'],
            'alergi'            => ['nullable', 'string', 'max:200'],
            'obat_saat_ini'     => ['nullable', 'string'],
            'hari_pertama_haid' => ['nullable', 'date'],
            'gravida'           => ['nullable', 'integer', 'min:0'],
            'para'              => ['nullable', 'integer', 'min:0'],
            'abortus'           => ['nullable', 'integer', 'min:0'],
        ], [
            'keluhan_utama.required' => 'Keluhan utama wajib diisi.',
        ]);

        // Upsert: buat atau perbarui data anamnesa
        $pasien->anamnesa()->updateOrCreate(
            ['pasien_id' => $pasien->id],
            $validated
        );

        return redirect()->route('anamnesa.step2', $pasien)
            ->with('success', 'Anamnesa Step 1 tersimpan.');
    }

    // ─── STEP 2: Pemeriksaan Fisik ────────────────────────────────────────────

    public function step2(Pasien $pasien)
    {
        // Guard: step 1 harus sudah diisi
        if (!$pasien->anamnesa) {
            return redirect()->route('anamnesa.step1', $pasien)
                ->with('error', 'Harap isi Anamnesa terlebih dahulu.');
        }

        $pemeriksaan = $pasien->pemeriksaanFisik;
        return view('anamnesa.step2', compact('pasien', 'pemeriksaan'));
    }

    public function storeStep2(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'tekanan_darah_sistolik'  => ['required', 'integer', 'min:50', 'max:300'],
            'tekanan_darah_diastolik' => ['required', 'integer', 'min:30', 'max:200'],
            'nadi'                    => ['required', 'integer', 'min:30', 'max:250'],
            'suhu'                    => ['required', 'numeric', 'min:30', 'max:45'],
            'pernapasan'              => ['required', 'integer', 'min:5', 'max:60'],
            'berat_badan'             => ['required', 'numeric', 'min:1', 'max:300'],
            'tinggi_badan'            => ['required', 'numeric', 'min:50', 'max:250'],
            'lingkar_perut'           => ['nullable', 'numeric'],
            'tinggi_fundus'           => ['nullable', 'numeric'],
            'denyut_jantung_janin'    => ['nullable', 'integer'],
            'presentasi_janin'        => ['nullable', 'string', 'max:50'],
            'catatan_fisik'           => ['nullable', 'string'],
        ]);

        $pasien->pemeriksaanFisik()->updateOrCreate(
            ['pasien_id' => $pasien->id],
            $validated
        );

        return redirect()->route('anamnesa.step3', $pasien)
            ->with('success', 'Pemeriksaan Fisik tersimpan.');
    }

    // ─── STEP 3: Pemeriksaan Lainnya ──────────────────────────────────────────

    public function step3(Pasien $pasien)
    {
        if (!$pasien->pemeriksaanFisik) {
            return redirect()->route('anamnesa.step2', $pasien)
                ->with('error', 'Harap isi Pemeriksaan Fisik terlebih dahulu.');
        }

        $lainnya = $pasien->pemeriksaanLainnya;
        return view('anamnesa.step3', compact('pasien', 'lainnya'));
    }

    public function storeStep3(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'hemoglobin'         => ['nullable', 'numeric', 'min:0', 'max:30'],
            'golongan_darah_lab' => ['nullable', 'in:A,B,AB,O'],
            'rhesus'             => ['nullable', 'in:Positif,Negatif'],
            'gula_darah'         => ['nullable', 'numeric'],
            'protein_urine'      => ['nullable', 'in:Negatif,+1,+2,+3,+4'],
            'hiv_status'         => ['nullable', 'in:Non Reaktif,Reaktif,Tidak Diperiksa'],
            'hepatitis_b'        => ['nullable', 'in:Non Reaktif,Reaktif,Tidak Diperiksa'],
            'catatan_lainnya'    => ['nullable', 'string'],
            'tindakan'           => ['nullable', 'string'],
            'diagnosa'           => ['nullable', 'string'],
        ]);

        $pasien->pemeriksaanLainnya()->updateOrCreate(
            ['pasien_id' => $pasien->id],
            $validated
        );

        return redirect()->route('anamnesa.selesai', $pasien)
            ->with('success', 'Semua pemeriksaan berhasil disimpan! ✅');
    }

    // ─── SELESAI ──────────────────────────────────────────────────────────────

    public function selesai(Pasien $pasien)
    {
        $pasien->load(['anamnesa', 'pemeriksaanFisik', 'pemeriksaanLainnya']);
        return view('anamnesa.selesai', compact('pasien'));
    }
}