@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2 class="mb-3">👩‍🏫 Data Guru</h2>

  {{-- ✅ Pesan Error Validasi --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Ukuran foto tidak boleh melebihi 2MB</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- ✅ Pesan Sukses --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Tombol Tambah Guru --}}
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
    + Tambah Guru
  </button>

  {{-- Tabel Data Guru --}}
  <table class="table table-bordered align-middle table-striped">
    <thead class="table-dark text-center">
      <tr>
        <th style="width:50px;">#</th>
        <th>Foto</th>
        <th>Nama</th>
        <th>NIP</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Mata Pelajaran</th>
        <th style="width:150px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($teachers as $teacher)
      <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td class="text-center">
          @if($teacher->photo)
            <img src="{{ asset($teacher->photo) }}" alt="Foto {{ $teacher->name }}"
                 width="60" height="60" class="rounded border" style="object-fit:cover;">
          @else
            <span class="text-muted">-</span>
          @endif
        </td>
        <td>{{ $teacher->name }}</td>
        <td>{{ $teacher->nip ?? '-' }}</td>
        <td>{{ $teacher->email ?? '-' }}</td>
        <td>{{ $teacher->phone ?? '-' }}</td>
        <td>{{ $teacher->subject->name ?? '-' }}</td>
<td class="text-center">
  <div class="d-flex justify-content-center gap-2">
    <!-- Tombol Edit -->
    <button class="btn btn-sm btn-warning px-2 py-1"
            style="font-size: 13px; min-width: 70px;"
            data-bs-toggle="modal"
            data-bs-target="#editTeacherModal{{ $teacher->id }}">
      ✏️ Edit
    </button>

    <!-- Tombol Hapus -->
    <form action="{{ route('teachers.destroy', $teacher->id) }}"
          method="POST"
          onsubmit="return confirm('Yakin hapus guru ini?')"
          class="m-0">
      @csrf
      @method('DELETE')
      <button class="btn btn-sm btn-danger px-2 py-1"
              style="font-size: 13px; min-width: 70px;">
        🗑 Hapus
      </button>
    </form>
  </div>
</td>


      </tr>
      @empty
        <tr><td colspan="8" class="text-center text-muted">Belum ada data guru.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- ===================== MODAL TAMBAH GURU ===================== -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addTeacherLabel">Tambah Guru</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">NIP</label>
              <input type="text" name="nip" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Telepon</label>
              <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Mata Pelajaran</label>
              <select name="subject_id" class="form-select">
                <option value="">-- Pilih Mapel --</option>
                @foreach($subjects as $subject)
                  <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Foto Guru</label>
              <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">💾 Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ===================== MODAL EDIT GURU ===================== -->
@foreach($teachers as $teacher)
<div class="modal fade" id="editTeacherModal{{ $teacher->id }}" tabindex="-1" aria-labelledby="editTeacherLabel{{ $teacher->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="editTeacherLabel{{ $teacher->id }}">Edit Guru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input type="text" name="name" class="form-control" value="{{ $teacher->name }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">NIP</label>
              <input type="text" name="nip" class="form-control" value="{{ $teacher->nip }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="{{ $teacher->email }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Telepon</label>
              <input type="text" name="phone" class="form-control" value="{{ $teacher->phone }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Mata Pelajaran</label>
              <select name="subject_id" class="form-select">
                <option value="">-- Pilih Mapel --</option>
                @foreach($subjects as $subject)
                  <option value="{{ $subject->id }}" {{ $teacher->subject_id == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Foto Guru</label>
              <input type="file" name="photo" class="form-control" accept="image/*">
              @if($teacher->photo)
                <div class="mt-2 text-center">
                  <img src="{{ asset($teacher->photo) }}" alt="Foto {{ $teacher->name }}"
                       width="80" height="80" class="rounded border" style="object-fit:cover;">
                </div>
              @endif
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">💾 Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
