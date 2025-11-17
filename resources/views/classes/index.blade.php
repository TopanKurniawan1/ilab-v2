@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📘 Data Kelas</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Kelas</button>
  </div>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th width="5%">#</th>
        <th>Nama Kelas</th>
        <th>Jurusan</th>
        <th>Dibuat</th>
        <th width="15%">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($classes as $class)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $class->name }}</td>
          <td>{{ $class->major->name ?? '-' }}</td>
          <td>{{ $class->created_at->format('d M Y') }}</td>
          <td>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $class->id }}">Edit</button>
            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $class->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form action="{{ route('classes.update', $class->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                  <div class="mb-3">
                    <label>Nama Kelas</label>
                    <input type="text" name="name" value="{{ $class->name }}" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label>Jurusan</label>
                    <select name="major_id" class="form-select">
                      <option value="">-- Pilih Jurusan --</option>
                      @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ $class->major_id == $major->id ? 'selected' : '' }}>
                          {{ $major->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-warning text-white">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @empty
        <tr><td colspan="5" class="text-center text-muted">Belum ada data kelas.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Tambah Kelas Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('classes.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Kelas</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Jurusan</label>
            <select name="major_id" class="form-select">
              <option value="">-- Pilih Jurusan --</option>
              @foreach($majors as $major)
                <option value="{{ $major->id }}">{{ $major->name }}</option>
              @endforeach
            </select>
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
