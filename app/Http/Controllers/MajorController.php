<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    // Halaman utama jurusan
    public function index()
    {
        $majors = Major::orderBy('name')->get();
        return view('majors.index', compact('majors'));
    }

    // Simpan data jurusan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:majors,code',
        ]);

        Major::create($request->only('name', 'code'));

        return redirect()->route('majors.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Update jurusan
    public function update(Request $request, Major $major)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:majors,code,' . $major->id,
        ]);

        $major->update($request->only('name', 'code'));

        return redirect()->route('majors.index')->with('success', 'Jurusan berhasil diperbarui!');
    }

    // Hapus jurusan
    public function destroy(Major $major)
    {
        $major->delete();
        return redirect()->route('majors.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
