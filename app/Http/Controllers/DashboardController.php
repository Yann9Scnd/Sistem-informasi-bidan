<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesa;
use App\Models\PemeriksaanFisik;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pasien'         => Pasien::count(),
            'pasien_baru_hari_ini' => Pasien::whereDate('created_at', Carbon::today())->count(),
            'pasien_bulan_ini'     => Pasien::whereMonth('created_at', Carbon::now()->month)->count(),
            'poli_kia'             => Pasien::where('poli', 'KIA')->count(),
            'poli_kb'              => Pasien::where('poli', 'KB')->count(),
            'poli_mtbs'            => Pasien::where('poli', 'MTBS')->count(),
            'pemeriksaan_hari_ini' => PemeriksaanFisik::whereDate('created_at', Carbon::today())->count(),
        ];

        $pasien_terbaru = Pasien::latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'pasien_terbaru'));
    }
}