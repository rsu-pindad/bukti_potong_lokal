@extends('layout.main')
@section('content')
<div class="card">
  <div class="card-header">
    <h3>Data Folder Published Bukti Potong</h3>
  </div>
  <div class="card-body">
    {{-- <div class="card-title mb-4">
        <a href="{{ route('pajak-file-index') }}"
    class="btn btn-outline-secondary">
    <i class="fa-solid fa-chevron-left mr-2"></i>
    Publish
    </a>
  </div> --}}
  <div class="table-responsive">
    <table class="table-condensed table-hover table-striped table">
      <thead>
        <tr>
          <th>No</th>
          <th>File</th>
          <th>Nama folder</th>
          <th>Status</th>
          <th>Jumlah File</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($published as $publish)
        <tr>
          <td>{{ $published->perPage() * ($published->currentPage() - 1) + $loop->iteration }}</td>
          <td>{{ $publish->folder_publish }}</td>
          <td>{{ $publish->folder_name }}</td>
          @if ($publish->folder_status == 0)
          <td>
            <span class="badge rounded-pill text-bg-secondary p-2">Belum Dicari</span>
          </td>
          <td>{{ $publish->folder_jumlah_file }}</td>
          <td>
            <form action="{{ route('pajak-published-file-cari-data-pajak') }}"
              method="post">
              @csrf
              <input type="hidden"
                name="id"
                value="{{ $publish->id }}">
              <input type="hidden"
                name="isReset"
                value="false">
              <button class="btn btn-primary btn-sm">
                Cari
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </form>
          </td>
          @else
          <td>
            <span class="badge rounded-pill text-bg-success p-2">Sudah Dicari</span>
          </td>
          <td colspan="2">
            <form action="{{ route('pajak-published-file-data-pajak') }}"
              method="get">
              <div>
                <input type="hidden"
                  name="file"
                  value="{{ $publish->id }}"
                  readonly>
                <button type="submit"
                  class="btn btn-sm btn-outline-secondary mx-4">
                  {{ $publish->folder_jumlah_file }}
                  <i class="fa-solid fa-eye px-2"></i>
                </button>
              </div>
            </form>
          </td>
          @endif
        </tr>
        @empty
        <tr>
          <td colspan="7"
            class="text-center">Belum ada folder yang di publish</td>
        </tr>
        @endforelse

      </tbody>
      <tfoot>
        {{ $published->links() }}
      </tfoot>
    </table>
  </div>
</div>
</div>
@endsection