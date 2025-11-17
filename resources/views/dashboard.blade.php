@extends('layouts.app')

@section('title', 'Dashboard iLab')

@section('content')
  <h2>Selamat datang di iLab Dashboard</h2>
  <p>Pilih menu di sidebar untuk mulai mengelola data kelas, guru, mata pelajaran, dan jadwal.</p>

  <div style="margin-top: 20px;">
    <div class="info-card">
      <h3>📘 Kelas</h3>
      <p>Kelola daftar kelas berdasarkan jurusan.</p>
    </div>

    <div class="info-card">
      <h3>👩‍🏫 Guru</h3>
      <p>Daftar guru dan data pengajar.</p>
    </div>

    <div class="info-card">
      <h3>📚 Mapel</h3>
      <p>Data mata pelajaran sesuai jurusan.</p>
    </div>
  </div>
@endsection
