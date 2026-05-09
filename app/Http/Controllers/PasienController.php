<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('poli')) {
            $query->where('poli', $request->poli);
        }

        $pasien = $query->latest()->paginate(10)->withQueryString();

        return view('pasien.index', compact('pasien'));
    }

    public function create()
    {
        $noUrut = Pasien::generateNoUrut();
        return view('pasien.create', compact('noUrut'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'            => ['required', 'string', 'size:16', 'unique:pasien,nik'],
            'nama'           => ['required', 'string', 'max:100'],
            'jenis_kelamin'  => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'   => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'  => ['required', 'date', 'before:today'],
            'alamat'         => ['required', 'string'],
            'nama_ortu'      => ['nullable', 'string', 'max:100'],
            'no_telp'        => ['required', 'string', 'max:15'],
            'poli'           => ['required', 'in:KIA,KB,MTBS'],
        ], [
            'nik.required'   => 'NIK wajib diisi.',
            'nik.size'       => 'NIK harus 16 digit.',
            'nik.unique'     => 'NIK sudah terdaftar.',
            'nama.required'  => 'Nama pasien wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'poli.required'  => 'Poli tujuan wajib dipilih.',
        ]);

        $validated['no_urut'] = Pasien::generateNoUrut();

        Pasien::create($validated);

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan! ✅');
    }

    public function show(Pasien $pasien)
    {
        $pasien->load(['anamnesa', 'pemeriksaanFisik', 'diagnosis']);
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nik'            => ['required', 'string', 'size:16', "unique:pasien,nik,{$pasien->id}"],
            'nama'           => ['required', 'string', 'max:100'],
            'jenis_kelamin'  => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'   => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'  => ['required', 'date', 'before:today'],
            'alamat'         => ['required', 'string'],
            'nama_ortu'      => ['nullable', 'string', 'max:100'],
            'no_telp'        => ['required', 'string', 'max:15'],
            'poli'           => ['required', 'in:KIA,KB,MTBS'],
        ]);

        $pasien->update($validated);

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui! ✅');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil dihapus. 🗑️');
    }
}