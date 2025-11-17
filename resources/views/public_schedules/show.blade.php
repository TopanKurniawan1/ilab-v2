<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal {{ $class->name }}</title>
  <link rel="stylesheet" href="{{ asset('css/public-style.css') }}">
</head>
<body>
<div class="container">

  {{-- HEADER --}}
  <div class="header">
    <img src="{{ asset('images/logo-pplg.png') }}" alt="Logo Kiri" class="logo">
    <h1>SMK Negeri 1 Karawang</h1>
    <img src="{{ asset('images/logo-aws.png') }}" alt="Logo Kanan" class="logo">
  </div>

  {{-- INFO GURU SAAT INI --}}
  <div class="info-container">
    <div class="info">
      <div class="row">
        <span class="label">NAMA GURU</span>
        <span class="value">
          {{ $jadwalSekarang->teacher->name ?? 'Tidak ada jadwal saat ini' }}
        </span>
      </div>

      <div class="row">
        <span class="label">JAM KE</span>
        <span class="value">{{ $jamKe ?? '-' }}</span>
      </div>

      <div class="row">
        <span class="label">MAPEL</span>
        <span class="value">{{ $jadwalSekarang->subject->name ?? '-' }}</span>
      </div>

      <div class="row">
        <span class="label">RUANGAN</span>
        <span class="value">{{ $jadwalSekarang->classroom->name ?? '-' }}</span>
      </div>
    </div>

    <div class="foto">
      <img src="{{ $jadwalSekarang && $jadwalSekarang->teacher->photo ? asset($jadwalSekarang->teacher->photo) : asset('images/default-teacher.png') }}" alt="Foto Guru">
    </div>
  </div>

  {{-- TANGGAL --}}
  <div class="tanggal">
    <b>{{ $hari }}</b> — {{ now('Asia/Jakarta')->format('d F Y, H:i') }}
  </div>

  {{-- INFORMASI TAMBAHAN --}}
  @if(!$jadwalSekarang)
    <div class="text-center" style="margin-top:30px;">
      <h3 style="color:#888;">Tidak ada pelajaran berlangsung saat ini.</h3>
    </div>
  @endif

</div>
</body>
</html>
