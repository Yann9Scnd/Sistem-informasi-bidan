<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesa;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pasien'      => Pasien::count(),
            'pasien_baru_hari_ini' => Pasien::whereDate('created_at', Carbon::today())->count(),
            'pasien_bulan_ini'  => Pasien::whereMonth('created_at', Carbon::now()->month)->count(),
            'pasien_aktif'      => Pasien::where('status', 'Aktif')->count(),
        ];

        $pasien_terbaru = Pasien::latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'pasien_terbaru'));
    }
}