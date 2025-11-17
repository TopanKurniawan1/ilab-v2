<head>
  <meta charset="UTF-8">
  <title>Dashboard iLab</title>

  {{-- Bootstrap CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
  {{-- Header --}}
  <header class="bg-dark text-white d-flex align-items-center p-3">
    <button class="btn btn-outline-light me-3" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      <i class="bi bi-list"></i>
    </button>
    <h5 class="mb-0">Dashboard iLab</h5>
  </header>

  {{-- Sidebar --}}
  <div class="offcanvas offcanvas-start text-bg-dark" id="sidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menu</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column">
        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link text-white"><i class="bi bi-house"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('majors.index') }}" class="nav-link text-white"><i class="bi bi-lightning"></i> Jurusan</a></li>
        <li class="nav-item"><a href="{{ route('classes.index') }}" class="nav-link text-white"><i class="bi bi-book"></i> Kelas</a></li>
        <li class="nav-item"><a href="{{ route('teachers.index') }}" class="nav-link text-white"><i class="bi bi-person-badge"></i> Guru</a></li>
        <li class="nav-item"><a href="{{ route('subjects.index') }}" class="nav-link text-white"><i class="bi bi-journal-bookmark"></i> Mapel</a></li>
        <li class="nav-item"><a href="{{ route('classrooms.index') }}" class="nav-link text-white"><i class="bi bi-building"></i> Ruangan</a></li>
        <li class="nav-item"><a href="{{ route('schedules.index') }}" class="nav-link text-white"><i class="bi bi-clock-history"></i> Jadwal</a></li>

      </ul>
    </div>
  </div>

  {{-- Konten utama --}}
  <main class="container-fluid py-4">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer class="bg-light text-center py-2 border-top">
    &copy; 2025 iLab Beta | SMKN 1 Karawang
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
