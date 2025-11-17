<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Jadwal Kelas — SMKN 1 Karawang')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f5f6fa;
      font-family: "Segoe UI", sans-serif;
    }
    .navbar {
      background: linear-gradient(90deg, #007bff, #0056b3);
    }
    .navbar-brand {
      font-weight: bold;
      letter-spacing: 0.5px;
    }
    footer {
      background: #fff;
      border-top: 1px solid #ddd;
      color: #555;
      padding: 15px 0;
      text-align: center;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/jadwal') }}">
        📘 Jadwal Kelas SMKN 1 Karawang
      </a>
    </div>
  </nav>

  <!-- Konten Utama -->
  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="mt-5">
    <div class="container">
      © {{ date('Y') }} SMKN 1 Karawang — Sistem Informasi Jadwal Publik
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
