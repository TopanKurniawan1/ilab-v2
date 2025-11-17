@extends('layouts.public')

@section('title', 'Jadwal Kelas')

@section('content')
<div class="container py-5">
  <h2 class="mb-4 text-center">📘 Jadwal Mingguan Semua Kelas</h2>

  <div class="row g-4">
    @foreach($classes as $c)
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-body text-center">
            <h5 class="card-title mb-1">{{ $c->name }}</h5>
            <p class="text-muted mb-3">{{ $c->major->name ?? '—' }}</p>
            <a href="{{ route('public.schedules.show', $c->id) }}" class="btn btn-primary w-100">
              📅 Tampilkan Jadwal
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
