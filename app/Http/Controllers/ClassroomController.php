<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::orderBy('name')->get();
        return view('classrooms.index', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        Classroom::create($request->only('name', 'capacity'));
        return redirect()->route('classrooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $classroom->update($request->only('name', 'capacity'));
        return redirect()->route('classrooms.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
