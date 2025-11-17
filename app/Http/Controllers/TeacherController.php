<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('subject')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('teachers.index', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'subject_id' => 'nullable|exists:subjects,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'nip', 'email', 'phone', 'subject_id']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = public_path('uploads/teachers');

            // buat folder jika belum ada
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['photo'] = 'uploads/teachers/' . $filename;
        }

        Teacher::create($data);

        return redirect()->route('teachers.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'subject_id' => 'nullable|exists:subjects,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'nip', 'email', 'phone', 'subject_id']);

        if ($request->hasFile('photo')) {
            // hapus foto lama kalau ada
            if ($teacher->photo && file_exists(public_path($teacher->photo))) {
                @unlink(public_path($teacher->photo));
            }

            // simpan foto baru
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $destination = public_path('uploads/teachers');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['photo'] = 'uploads/teachers/'.$filename;
        }

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'Guru berhasil diperbarui.');
    }

        public function destroy(Teacher $teacher)
    {
        try {
            // Hapus file foto jika ada
            if ($teacher->photo && file_exists(public_path($teacher->photo))) {
                @unlink(public_path($teacher->photo)); // pakai @ agar tidak error fatal
            }

            $teacher->delete();

            return redirect()->route('teachers.index')->with('success', 'Guru berhasil dihapus.');
        } catch (\Throwable $e) {
            \Log::error('Gagal menghapus guru: '.$e->getMessage());
            return redirect()->route('teachers.index')->with('error', 'Terjadi kesalahan saat menghapus guru.');
        }
    }


}
