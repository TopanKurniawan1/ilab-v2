@extends('layouts.app')

@section('title', 'Data Mata Pelajaran')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📚 Data Mata Pelajaran</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Mapel</button>
  </div>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th width="5%">#</th>
        <th>Nama Mapel</th>
        <th>Kode</th>
        <th>Dibuat</th>
        <th width="15%">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($subjects as $subject)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $subject->name }}</td>
          <td>{{ $subject->code ?? '-' }}</td>
          <td>{{ $subject->created_at->format('d M Y') }}</td>
          <td>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $subject->id }}">Edit</button>
            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $subject->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                  <div class="mb-3">
                    <label>Nama Mapel</label>
                    <input type="text" name="name" value="{{ $subject->name }}" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label>Kode</label>
                    <input type="text" name="code" value="{{ $subject->code }}" class="form-control">
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
        <tr><td colspan="5" class="text-center text-muted">Belum ada data mapel.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Mapel</label>
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
