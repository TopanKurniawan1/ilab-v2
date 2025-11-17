@extends('layouts.app')

@section('title', 'Data Ruangan')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>🏫 Data Ruangan</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Ruangan</button>
  </div>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th width="5%">#</th>
        <th>Nama Ruangan</th>
        <th>Kapasitas</th>
        <th>Dibuat</th>
        <th width="15%">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($classrooms as $classroom)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $classroom->name }}</td>
          <td>{{ $classroom->capacity ?? '-' }}</td>
          <td>{{ $classroom->created_at->format('d M Y') }}</td>
          <td>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $classroom->id }}">Edit</button>
            <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $classroom->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                  <div class="mb-3">
                    <label>Nama Ruangan</label>
                    <input type="text" name="name" value="{{ $classroom->name }}" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label>Kapasitas</label>
                    <input type="number" name="capacity" value="{{ $classroom->capacity }}" class="form-control">
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
        <tr><td colspan="5" class="text-center text-muted">Belum ada data ruangan.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Tambah Ruangan Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('classrooms.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Ruangan</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Kapasitas</label>
            <input type="number" name="capacity" class="form-control">
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
