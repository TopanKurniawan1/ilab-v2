<h5>Jadwal Mingguan Kelas {{ $class->name }}</h5>

@foreach (['Senin','Selasa','Rabu','Kamis','Jumat'] as $day)
  <h6 class="mt-3">{{ $day }}</h6>
  <table class="table table-bordered table-sm align-middle">
    <thead>
      <tr>
        <th style="width:60px">Jam</th>
        <th>Mapel</th>
        <th>Guru</th>
        <th>Ruangan</th>
      </tr>
    </thead>
    <tbody>
      @php
        $daySchedules = $schedules->where('day', $day);
      @endphp
      @for ($p = 1; $p <= 10; $p++)
        @php
          $s = $daySchedules->firstWhere('period', $p);
        @endphp
        <tr>
          <td class="text-center">{{ $p }}</td>
          <td>{{ $s->subject->name ?? '-' }}</td>
          <td>{{ $s->teacher->name ?? '-' }}</td>
          <td>{{ $s->classroom->name ?? '-' }}</td>
        </tr>
      @endfor
    </tbody>
  </table>
@endforeach
