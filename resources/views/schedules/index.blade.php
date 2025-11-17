@extends('layouts.app')

@section('title', 'Schedules')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📅 Jadwal Setiap Kelas</h3>
  </div>

  {{-- Grid kartu kelas --}}
  <div class="row g-3">
    @forelse($classes as $c)
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-1">{{ $c->name }}</h5>
            <p class="text-muted mb-4">Jurusan: {{ $c->major->name ?? '-' }}</p>
            <div class="mt-auto d-flex justify-content-end gap-2">
              <button class="btn btn-sm btn-success"
                      data-class-id="{{ $c->id }}"
                      data-class-name="{{ $c->name }}"
                      onclick="openViewModal(this)">
                📖 Lihat Jadwal
              </button>
              <button class="btn btn-sm btn-primary"
                      data-class-id="{{ $c->id }}"
                      data-class-name="{{ $c->name }}"
                      onclick="openEditModal(this)">
                ✏️ Edit Jadwal
              </button>
            </div>
          </div>
        </div>
      </div>
    @empty
      <p class="text-muted">Belum ada data kelas.</p>
    @endforelse
  </div>
</div>

{{-- Modal: Lihat Jadwal --}}
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">📖 Jadwal Mingguan — <span id="viewClassName"></span></h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="viewScheduleContent">
        <p class="text-center text-muted">Memuat data...</p>
      </div>
    </div>
  </div>
</div>

{{-- Modal: Edit Jadwal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">✏️ Edit Jadwal — <span id="editClassName"></span></h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="editClassId">
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="white-space:nowrap;">Hari / Jam</th>
                @for($p = 1; $p <= 10; $p++)
                  <th class="text-center" style="min-width:220px;">Jam {{ $p }}</th>
                @endfor
                <th class="text-center" style="min-width:180px;">Ruangan</th>
              </tr>
            </thead>
            <tbody id="weeklyGridBody">
              {{-- Akan diisi JS --}}
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-primary" onclick="submitWeekly()">Simpan Jadwal</button>
      </div>
    </div>
  </div>
</div>

<script>
const DAYS = ['Senin','Selasa','Rabu','Kamis','Jumat'];
window.SUBJECTS   = @json($subjects);
window.TEACHERS   = @json($teachers);
window.CLASSROOMS = @json($classrooms);

// render dropdown mapel & guru
function renderCell(day, period) {
  const cellKey = `${day}-${period}`;
  return `
    <div class="d-grid gap-1" data-cell="${cellKey}">
      <select class="form-select form-select-sm subj" onchange="onSubjectChange('${cellKey}')">
        <option value="">— Mapel —</option>
        ${window.SUBJECTS.map(s => `<option value="${s.id}">${s.name}</option>`).join('')}
      </select>
      <select class="form-select form-select-sm teach">
        <option value="">— Guru —</option>
      </select>
    </div>
  `;
}

// render grid jadwal mingguan
function renderWeeklyGrid() {
  const tbody = document.getElementById('weeklyGridBody');
  let html = '';
  for (const day of DAYS) {
    html += `<tr><th scope="row">${day}</th>`;
    for (let p = 1; p <= 10; p++) html += `<td>${renderCell(day, p)}</td>`;
    html += `
      <td>
        <select class="form-select form-select-sm day-room" data-day="${day}">
          <option value="">— Ruangan —</option>
          ${window.CLASSROOMS.map(r => `<option value="${r.id}">${r.name}</option>`).join('')}
        </select>
      </td>
    `;
    html += `</tr>`;
  }
  tbody.innerHTML = html;
}

// filter guru berdasar mapel
function onSubjectChange(cellKey) {
  const cell = document.querySelector(`[data-cell="${cellKey}"]`);
  const subjSel = cell.querySelector('.subj');
  const teachSel = cell.querySelector('.teach');
  const subjectId = subjSel.value;
  let opts = `<option value="">— Guru —</option>`;
  if (subjectId) {
    const filtered = window.TEACHERS.filter(t => String(t.subject_id || '') === String(subjectId));
    opts += filtered.map(t => `<option value="${t.id}">${t.name}</option>`).join('');
  }
  teachSel.innerHTML = opts;
}

// buka modal EDIT
async function openEditModal(btn) {
  const id = btn.dataset.classId;
  const name = btn.dataset.className;
  document.getElementById('editClassId').value = id;
  document.getElementById('editClassName').textContent = name;
  renderWeeklyGrid();

  try {
    const res = await fetch(`/schedules/fetch/${id}`);
    const json = await res.json();
    if (json?.data) {
      for (const [key, val] of Object.entries(json.data)) {
        const cell = document.querySelector(`[data-cell="${key}"]`);
        if (!cell) continue;
        const subjSel = cell.querySelector('.subj');
        const teachSel = cell.querySelector('.teach');
        if (val.subject_id) subjSel.value = val.subject_id;
        onSubjectChange(key);
        if (val.teacher_id) teachSel.value = val.teacher_id;
        const roomSel = document.querySelector(`.day-room[data-day="${val.day}"]`);
        if (val.classroom_id && roomSel) roomSel.value = val.classroom_id;
      }
    }
  } catch (e) { console.error(e); alert('Gagal memuat data jadwal.'); }

  new bootstrap.Modal(document.getElementById('editModal')).show();
}

// buka modal LIHAT
async function openViewModal(btn) {
  const id = btn.dataset.classId;
  const name = btn.dataset.className;
  document.getElementById('viewClassName').textContent = name;
  document.getElementById('viewScheduleContent').innerHTML = "<p class='text-center text-muted'>Memuat...</p>";
  try {
    const res = await fetch(`/schedules/view/${id}`);
    const html = await res.text();
    document.getElementById('viewScheduleContent').innerHTML = html;
  } catch {
    document.getElementById('viewScheduleContent').innerHTML = "<p class='text-danger text-center'>Gagal memuat jadwal.</p>";
  }
  new bootstrap.Modal(document.getElementById('viewModal')).show();
}

// submit jadwal mingguan
async function submitWeekly() {
  const classId = document.getElementById('editClassId').value;
  const items = [];

  for (const day of DAYS) {
    const roomVal = document.querySelector(`.day-room[data-day="${day}"]`)?.value || null;
    for (let p = 1; p <= 10; p++) {
      const cell = document.querySelector(`[data-cell="${day}-${p}"]`);
      const subj = cell.querySelector('.subj').value;
      const teach = cell.querySelector('.teach').value;
      if (subj || teach || roomVal) {
        items.push({ day, period: p, subject_id: subj || null, teacher_id: teach || null, classroom_id: roomVal || null });
      }
    }
  }

  try {
    const res = await fetch(`{{ route('schedules.store') }}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({ class_id: classId, items })
    });
    const json = await res.json();
    if (json.ok) {
      bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
      alert('Jadwal berhasil disimpan!');
    } else alert('Gagal menyimpan jadwal.');
  } catch (e) {
    console.error(e);
    alert('Terjadi kesalahan saat menyimpan jadwal.');
  }
}
</script>
@endsection
