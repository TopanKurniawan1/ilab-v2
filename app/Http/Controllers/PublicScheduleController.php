<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Schedule;
use Illuminate\Http\Request;

class PublicScheduleController extends Controller
{
    // Menampilkan semua kelas
    public function index()
    {
        $classes = Classes::with('major')->orderBy('name')->get();
        return view('public_schedules.index', compact('classes'));
    }

    // Menampilkan jadwal detail satu kelas
public function show($classId)
{
    $class = \App\Models\Classes::with(['major'])->findOrFail($classId);

    $now = now('Asia/Jakarta');
    $hari = ucfirst(strtolower($now->isoFormat('dddd'))); // jadi "Rabu"
    $jamSekarang = $now->format('H:i'); // contoh: "09:30"

    // mapping jam ke waktu (sesuai jadwal sekolahmu)
    $jamMap = [
        1 => ['07:15', '07:55'],
        2 => ['07:55', '08:35'],
        3 => ['08:35', '09:15'],
        4 => ['09:30', '10:10'],
        5 => ['10:10', '10:50'],
        6 => ['10:50', '11:30'],
        7 => ['11:30', '12:10'],
        8 => ['13:00', '13:40'],
        9 => ['13:40', '14:20'],
        10 => ['14:20', '15:00'],
    ];

    $jamKe = null;
    foreach ($jamMap as $key => [$mulai, $selesai]) {
        if ($jamSekarang >= $mulai && $jamSekarang < $selesai) {
            $jamKe = $key;
            break;
        }
    }

    $jadwalSekarang = null;
    if ($jamKe) {
        $jadwalSekarang = \App\Models\Schedule::with(['teacher', 'subject', 'classroom'])
            ->where('class_id', $classId)
            ->where('day', ucfirst(strtolower($hari)))
            ->where('period', $jamKe)
            ->first();
    }

    return view('public_schedules.show', compact('class', 'jadwalSekarang', 'jamKe', 'hari'));
}
}
