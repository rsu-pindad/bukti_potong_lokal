@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Publish File</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('pajak-file-upload-bukti-potong') }}"
            method="post"
            enctype="multipart/form-data">
        @csrf
        <div class="input-group">
          <input id="buktiPotong"
                 type="file"
                 name="buktiPotong"
                 class="form-control">
          <button class="btn btn-primary">
            Unggah
            <i class="fa-solid fa-upload"></i>
          </button>
        </div>
      </form>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="filePajakTable"
               class="table-light table-bordered table-hover table-striped table-responsive table">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama File</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($zip_files as $item)
              @php
                $itemName = explode('/', $item);
                $folder = Storage::disk('public')->directories('files/shares/pajak/publish/' . $itemName['3']);
                if (count($folder) > 0) {
                    $folderExplode = explode('/', $folder['0']);
                    $folderTanggal = $folderExplode['5'];
                }
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $itemName['3'] }}</td>
                @if (count($folder) > 0)
                  <td class="text-center">
                    <span class="badge rounded-pill text-bg-success p-2">{{ $folderTanggal }}</span>
                  </td>
                  <td class="text-center">
                    <form action="{{ route('pajak-file-unpublish') }}"
                          method="post">
                      @csrf
                      <input type="hidden"
                             name="nama_file"
                             value="{{ $itemName['3'] }}">
                      <input type="hidden"
                             name="folder_target"
                             value="{{ $folderTanggal }}">
                      <button class="btn btn-danger btn-sm">
                        Unpublish
                        <i class="fa-solid fa-ban"></i>
                      </button>
                    </form>
                  </td>
                @else
                  <td class="text-center">
                    <span class="badge rounded-pill text-bg-secondary p-2">Unpublish</span>
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-evenly flex-row">
                      <div>
                        <a href="{{ route('pajak-file-publish', ['filename' => $itemName['3']]) }}"
                           class="btn btn-primary">
                          Set
                          <i class="fa-solid fa-share-nodes"></i>
                        </a>
                      </div>
                      <div>
                        <form action="{{ route('pajak-file-remove-bukti-potong') }}"
                              method="post">
                          @csrf
                          <input type="hidden"
                                 name="filename"
                                 value="{{ $itemName['3'] }}"
                                 readonly>
                          <button class="btn btn-danger"
                                  onclick="return confirm('Hapus file?')">
                            Hapus
                            <i class="fa-solid fa-xmark"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                @endif
              </tr>
            @empty
              <tr>
                <td class="text-center"
                    colspan="4">Belum ada data file pajak</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
