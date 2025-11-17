<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Major;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('major')->orderBy('name')->get();
        $majors = Major::orderBy('name')->get();

        return view('classes.index', compact('classes', 'majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'major_id' => 'nullable|exists:majors,id'
        ]);

        Classes::create($request->only('name', 'major_id'));
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'major_id' => 'nullable|exists:majors,id'
        ]);

        $class->update($request->only('name', 'major_id'));
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Classes $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
