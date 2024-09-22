@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header">
      <h3>Data Folder Published Bukti Potong</h3>
    </div>
    <div class="card-body">
      <div class="card-title mb-4">
        <a href="{{ route('pajak-published-index') }}"
           class="btn btn-outline-secondary">
          <i class="fa-solid fa-chevron-left mr-2"></i>
          Kembali
        </a>
      </div>
      <form action="{{ route('published-file-data-pajak') }}"
            method="get">
        <input type="hidden"
               name="file"
               value="{{ $published->id }}"
               readonly>
        <div class="input-group mb-2">
          <button class="btn btn-primary">Cari</button>
          <input type="text"
                 class="form-control"
                 name="cari"
                 value="{{ request('cari') }}"
                 placeholder="cari data">
        </div>
      </form>
      <table class="table-responsive table-condensed table-striped table">
        <thead>
          <tr>
            <th>No</th>
            <th>File folder</th>
            <th>Nama File</th>
            <th>NPWP</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($files as $file)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $file->file_path }}</td>
              <td>{{ $file->file_name }}</td>
              <td>{{ $file->file_identitas_npwp }}</td>
              <td>{{ $file->file_identitas_nik }}</td>
              <td>{{ $file->file_identitas_nama }}</td>
              <td>{{ $file->file_identitas_alamat }}</td>
              <td>
                <a target="_blank"
                class="btn btn-outline-danger"
                   href="{{ route('published-cari-file-pajak', ['folder' => $file->file_path, 'filename' => $file->file_name]) }}">
                  <i class="fa-solid fa-file-pdf"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8">Data tidak ditemukan</td>
            </tr>
          @endforelse
        </tbody>
        <tfoot>
          {{ $files->appends($_GET)->links() }}
        </tfoot>
      </table>
    </div>
  </div>
@endsection
