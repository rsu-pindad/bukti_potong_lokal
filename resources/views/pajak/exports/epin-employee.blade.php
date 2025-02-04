<table>
  <thead>
    <tr>
      <th>npp lama</th>
      <th>npp baru</th>
      <th>nama</th>
      <th>status_kepegawaian</th>
      <th>nik</th>
      <th>npwp</th>
      <th>status_ptkp</th>
      <th>email</th>
      <th>no_hp</th>
      <th>epin</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($employees as $employee)
      <tr>
        <td>{{ $employee->npp }}</td>
        <td>{{ $employee->npp_baru }}</td>
        <td>{{ $employee->nama }}</td>
        <td>{{ $employee->status_kepegawaian }}</td>
        <td>{{ $employee->nik }}</td>
        <td>{{ $employee->npwp }}</td>
        <td>{{ $employee->status_ptkp }}</td>
        <td>{{ $employee->email }}</td>
        <td>{{ $employee->no_hp }}</td>
        <td>{{ $employee->epin }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
