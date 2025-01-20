<table>
  <thead>
    <tr>
      <th>No</th>
      <th>BulanTahun/mmyyyy</th>
      <th>Nama</th>
      <th>Link</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($bupot as $bp)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $bp->file_path }}</td>
        <td>{{ $bp->file_identitas_nama }}</td>
        <td>{{ $bp->short_link }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
