<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Anamnesa;
use App\Models\PemeriksaanFisik;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    /**
     * Tampilkan halaman daftar notifikasi.
     */
    public function index()
    {
        $notifications = $this->generateNotifications();
        return view('notifications.index', compact('notifications'));
    }

    /**
     * JSON endpoint untuk badge count.
     */
    public function getCount()
    {
        $count = count($this->generateNotifications());
        return response()->json(['count' => $count]);
    }

    /**
     * Generate notifikasi dari data aktual.
     */
    private function generateNotifications(): array
    {
        $notifications = [];

        // 1. Pasien baru hari ini
        $pasienBaru = Pasien::whereDate('created_at', Carbon::today())->latest()->get();
        foreach ($pasienBaru as $p) {
            $notifications[] = [
                'type'    => 'pasien_baru',
                'icon'    => '👤',
                'title'   => 'Pasien Baru Terdaftar',
                'message' => "Pasien {$p->nama} ({$p->nik}) telah mendaftar di poli {$p->poli}.",
                'time'    => $p->created_at,
                'link'    => route('pasien.show', $p),
            ];
        }

        // 2. Pasien tanpa anamnese (terdaftar tapi belum mulai pemeriksaan)
        $tanpaAnamnese = Pasien::whereDoesntHave('anamnesa')
            ->whereDate('created_at', '>=', Carbon::today()->subDays(7))
            ->latest()->take(10)->get();
        foreach ($tanpaAnamnese as $p) {
            $notifications[] = [
                'type'    => 'belum_periksa',
                'icon'    => '⚠️',
                'title'   => 'Belum Ada Anamnese',
                'message' => "Pasien {$p->nama} belum dilakukan anamnese sejak {$p->created_at->diffForHumans()}.",
                'time'    => $p->created_at,
                'link'    => route('anamnesa.step1', $p),
            ];
        }

        // 3. Pemeriksaan belum lengkap (ada anamnese, belum ada diagnosis)
        $belumDiagnosis = Pasien::whereHas('anamnesa')
            ->whereDoesntHave('diagnosis')
            ->latest()->take(10)->get();
        foreach ($belumDiagnosis as $p) {
            $notifications[] = [
                'type'    => 'belum_diagnosis',
                'icon'    => '📋',
                'title'   => 'Diagnosis Belum Lengkap',
                'message' => "Pasien {$p->nama} sudah anamnese tapi belum ada diagnosis.",
                'time'    => $p->latestAnamnesa?->created_at ?? $p->created_at,
                'link'    => route('anamnesa.step3', $p),
            ];
        }

        // Urutkan berdasar waktu terbaru
        usort($notifications, fn($a, $b) => $b['time']->timestamp <=> $a['time']->timestamp);

        return $notifications;
    }
}
