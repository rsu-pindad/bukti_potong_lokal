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
          <th>File Bulanan</th>
          <th>File Tidak Final</th>
          <th>File Tahunan</th>
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
          <td>{{ $publish->folder_jumlah_final }}</td>
          <td>{{ $publish->folder_jumlah_tidak_final }}</td>
          <td>{{ $publish->folder_jumlah_aone }}</td>
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
          <td>
            <form action="{{ route('pajak-published-file-data-pajak') }}"
              method="get">
              <div>
                <input type="hidden"
                  name="file"
                  value="{{ $publish->id }}"
                  readonly>
                <button type="submit"
                  class="btn btn-sm btn-outline-secondary mx-4">
                  {{ $publish->folder_jumlah_final }}
                  <i class="fa-solid fa-eye px-2"></i>
                </button>
              </div>
            </form>
          </td>
          <td>
            <form action="{{ route('pajak-published-file-data-pajak') }}"
              method="get">
              <div>
                <input type="hidden"
                  name="file"
                  value="{{ $publish->id }}"
                  readonly>
                <button type="submit"
                  class="btn btn-sm btn-outline-secondary mx-4">
                  {{ $publish->folder_jumlah_tidak_final }}
                  <i class="fa-solid fa-eye px-2"></i>
                </button>
              </div>
            </form>
          </td>
          <td>
            <form action="{{ route('pajak-published-file-data-pajak') }}"
              method="get">
              <div>
                <input type="hidden"
                  name="file"
                  value="{{ $publish->id }}"
                  readonly>
                <button type="submit"
                  class="btn btn-sm btn-outline-secondary mx-4">
                  {{ $publish->folder_jumlah_aone }}
                  <i class="fa-solid fa-eye px-2"></i>
                </button>
              </div>
            </form>
          </td>
          <td>
            <div class="justify-content-around flex flex-row">
              <div class="py-2">
                <form action="{{ route('pajak-published-file-cari-data-pajak') }}"
                  method="post">
                  @csrf
                  <input type="hidden"
                    name="id"
                    value="{{ $publish->id }}">
                  <input type="hidden"
                    name="isReset"
                    value="true">
                  <button class="btn btn-danger btn-sm mx-4">
                    Reset
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                  </button>
                </form>
              </div>
              <div class="py-2">
                <form action="{{ route('pajak-published-file-cari-data-pajak') }}"
                  method="post">
                  @csrf
                  <input type="hidden"
                    name="id"
                    value="{{ $publish->id }}">
                </form>
              </div>
              <div class="py-2">
                <form action="{{ route('pajak-published-file-aone-cari-data-pajak') }}"
                  method="post">
                  @csrf
                  <input type="hidden"
                    name="id"
                    value="{{ $publish->id }}">
                  <input type="hidden"
                    name="isReset"
                    value="false">
                  <button class="btn btn-info btn-sm mx-4">
                    Cari A1 (Metode 1)
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                  </button>
                </form>
              </div>
              <div class="py-2">
                <form action="{{ route('pajak-published-file-aone-cari-data-pajak') }}"
                  method="post">
                  @csrf
                  <input type="hidden"
                    name="id"
                    value="{{ $publish->id }}">
                  <input type="hidden"
                    name="isMetode2"
                    value="true">
                  <button class="btn btn-secondary btn-sm mx-4">
                    Cari A1 (Metode 2)
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                  </button>
                </form>
              </div>
            </div>
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