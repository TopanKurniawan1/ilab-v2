
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Jurusan</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMajorModal">+ Tambah Jurusan</button>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th style="width: 50px;">#</th>
            <th>Nama Jurusan</th>
            <th>Kode</th>
            <th style="width: 180px;">Aksi</th>
        </tr>
        <link rel="stylesheet" href="{{ asset('major.css') }}">

    </thead>
    <tbody>
        @forelse ($majors as $major)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $major->name }}</td>
            <td>{{ $major->code ?? '-' }}</td>
            <td>
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editMajorModal{{ $major->id }}">Edit</button>
                <form action="{{ route('majors.destroy', $major) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus jurusan ini?')">Hapus</button>
                </form>
            </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editMajorModal{{ $major->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('majors.update', $major) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title">Edit Jurusan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label>Nama Jurusan</label>
                    <input type="text" name="name" value="{{ $major->name }}" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label>Kode</label>
                    <input type="text" name="code" value="{{ $major->code }}" class="form-control">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @empty
        <tr><td colspan="4" class="text-center text-muted">Belum ada data jurusan</td></tr>
        @endforelse
    </tbody>
</table>

<!-- Modal Tambah -->
<div class="modal fade" id="addMajorModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('majors.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Jurusan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Jurusan</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Kode</label>
            <input type="text" name="code" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
