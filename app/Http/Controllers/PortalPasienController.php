<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PortalPasienController extends Controller
{
    /**
     * Tampilkan form lookup NIK.
     */
    public function showLookup()
    {
        return view('portal.lookup');
    }

    /**
     * Cari pasien berdasarkan NIK + tanggal lahir.
     */
    public function search(Request $request)
    {
        $request->validate([
            'nik'           => ['required', 'string', 'size:16'],
            'tanggal_lahir' => ['required', 'date'],
        ], [
            'nik.required'           => 'NIK wajib diisi.',
            'nik.size'               => 'NIK harus 16 digit.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        ]);

        $pasien = Pasien::where('nik', $request->nik)
            ->whereDate('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if (!$pasien) {
            return back()
                ->withInput()
                ->withErrors(['nik' => 'Data pasien tidak ditemukan. Pastikan NIK dan tanggal lahir benar.']);
        }

        // Simpan token sementara di session untuk akses hasil
        $token = bin2hex(random_bytes(16));
        Session::put("portal_token_{$token}", $pasien->id);
        Session::put("portal_token_{$token}_expires", now()->addMinutes(30));

        return redirect()->route('portal.hasil', ['token' => $token]);
    }

    /**
     * Tampilkan hasil pemeriksaan pasien (read-only).
     */
    public function showHasil(string $token)
    {
        $pasienId = Session::get("portal_token_{$token}");
        $expires  = Session::get("portal_token_{$token}_expires");

        if (!$pasienId || !$expires || now()->gt($expires)) {
            return redirect()->route('portal.lookup')
                ->withErrors(['nik' => 'Sesi telah berakhir. Silakan masukkan NIK kembali.']);
        }

        $pasien = Pasien::with([
            'anamnesa', 'pemeriksaanFisik', 'diagnosis'
        ])->findOrFail($pasienId);

        return view('portal.hasil', compact('pasien', 'token'));
    }

    /**
     * Download PDF hasil pemeriksaan.
     */
    public function downloadPDF(string $token)
    {
        $pasienId = Session::get("portal_token_{$token}");
        $expires  = Session::get("portal_token_{$token}_expires");

        if (!$pasienId || !$expires || now()->gt($expires)) {
            return redirect()->route('portal.lookup')
                ->withErrors(['nik' => 'Sesi telah berakhir. Silakan masukkan NIK kembali.']);
        }

        $pasien = Pasien::with([
            'latestAnamnesa', 'latestPemeriksaanFisik', 'latestDiagnosis'
        ])->findOrFail($pasienId);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('portal.pdf', compact('pasien'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Hasil_Pemeriksaan_' . str_replace(' ', '_', $pasien->nama) . '_' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
