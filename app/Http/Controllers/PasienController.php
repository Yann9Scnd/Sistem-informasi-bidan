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
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pasien = $query->latest()->paginate(10)->withQueryString();

        return view('pasien.index', compact('pasien'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'              => ['required', 'string', 'size:16', 'unique:pasien,nik'],
            'nama'             => ['required', 'string', 'max:100'],
            'jenis_kelamin'    => ['required', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir'    => ['required', 'date', 'before:today'],
            'no_hp'            => ['required', 'string', 'max:15'],
            'alamat_tinggal'   => ['required', 'string'],
            'alamat_ktp'       => ['nullable', 'string'],
            'golongan_darah'   => ['nullable', 'in:A,B,AB,O'],
            'agama'            => ['nullable', 'string', 'max:20'],
            'pekerjaan'        => ['nullable', 'string', 'max:50'],
            'status'           => ['required', 'in:Aktif,Tidak Aktif'],
        ], [
            'nik.required'   => 'NIK wajib diisi.',
            'nik.size'       => 'NIK harus 16 digit.',
            'nik.unique'     => 'NIK sudah terdaftar.',
            'nama.required'  => 'Nama pasien wajib diisi.',
        ]);

        Pasien::create($validated);

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan! ✅');
    }

    public function show(Pasien $pasien)
    {
        $pasien->load(['anamnesa', 'pemeriksaanFisik', 'pemeriksaanLainnya']);
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nik'              => ['required', 'string', 'size:16', "unique:pasien,nik,{$pasien->id}"],
            'nama'             => ['required', 'string', 'max:100'],
            'jenis_kelamin'    => ['required', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir'    => ['required', 'date', 'before:today'],
            'no_hp'            => ['required', 'string', 'max:15'],
            'alamat_tinggal'   => ['required', 'string'],
            'alamat_ktp'       => ['nullable', 'string'],
            'golongan_darah'   => ['nullable', 'in:A,B,AB,O'],
            'agama'            => ['nullable', 'string', 'max:20'],
            'pekerjaan'        => ['nullable', 'string', 'max:50'],
            'status'           => ['required', 'in:Aktif,Tidak Aktif'],
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