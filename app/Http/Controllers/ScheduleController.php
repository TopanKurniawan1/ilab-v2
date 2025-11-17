<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        // Ambil semua kelas + jurusan untuk tampilan utama
        $classes = Classes::with('major')->orderBy('name')->get();

        // Data master untuk form di modal
        $subjects   = Subject::orderBy('name')->get(['id','name']);
        $teachers   = Teacher::orderBy('name')->get(['id','name','subject_id']);
        $classrooms = Classroom::orderBy('name')->get(['id','name']);

        return view('schedules.index', compact('classes', 'subjects', 'teachers', 'classrooms'));
    }

    /** ========== LIHAT JADWAL (READONLY) ========== */
    public function view(Classes $class)
    {
        $schedules = Schedule::with(['subject', 'teacher', 'classroom'])
            ->where('class_id', $class->id)
            ->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('period')
            ->get();

        return view('schedules.partials.view', compact('class', 'schedules'));
    }

    /** ========== FETCH DATA UNTUK FORM EDIT ========== */
    public function fetch(Classes $class)
    {
        $rows = Schedule::where('class_id', $class->id)
            ->get(['day','period','subject_id','teacher_id','classroom_id']);

        $data = [];
        foreach ($rows as $r) {
            $key = "{$r->day}-{$r->period}";
            $data[$key] = [
                'day'          => $r->day,
                'period'       => $r->period,
                'subject_id'   => $r->subject_id,
                'teacher_id'   => $r->teacher_id,
                'classroom_id' => $r->classroom_id,
            ];
        }

        return response()->json(['data' => $data]);
    }

    /** ========== SIMPAN JADWAL MINGGUAN ========== */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'class_id' => ['required', 'exists:classes,id'],
                'items' => ['array'],
                'items.*.day' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat'],
                'items.*.period' => ['required', 'integer', 'min:1', 'max:10'],
                'items.*.subject_id' => ['nullable', 'exists:subjects,id'],
                'items.*.teacher_id' => ['nullable', 'exists:teachers,id'],
                'items.*.classroom_id' => ['nullable', 'exists:classrooms,id'],
            ]);

            DB::transaction(function () use ($request) {
                // hapus jadwal lama kelas ini
                Schedule::where('class_id', $request->class_id)->delete();

                // insert jadwal baru
                foreach ($request->items as $it) {
                    Schedule::create($it + ['class_id' => $request->class_id]);
                }
            });

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            \Log::error('Schedule error: ' . $e->getMessage());
            return response()->json([
                'ok' => false,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
