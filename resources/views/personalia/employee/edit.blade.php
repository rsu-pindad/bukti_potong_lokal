@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between flex-row">
      <h4>Edit Data Pegawai</h4>
    </div>
    <div class="card-body">
      <div class="card-title">
        <a href="{{ route('personalia-employee-index') }}"
           class="btn btn-outline-secondary">
          <i class="fa-solid fa-chevron-left mr-2"></i>
          Kembali
        </a>
      </div>
      <div>
        <form action="{{ route('personalia-employee-update', ['id' => $pegawai->id]) }}"
              method="post">
          @csrf
          @method('patch')
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="nikDataList"
                       class="form-label">NIK</label>
                <input id="nikDataList"
                       class="form-control @error('nik') is-invalid @enderror"
                       name="nik"
                       value="{{ $pegawai->nik }}"
                       readonly>
                @error('npp')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nppDataList"
                       class="form-label">NPP</label>
                <input id="nppDataList"
                       class="form-control @error('npp') is-invalid @enderror"
                       list="datalistOptions"
                       value="{{ $pegawai->npp }}"
                       name="npp"
                       placeholder="Masukan Npp">
                @error('npp')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="npwp"
                       class="form-label">NPWP</label>
                <input id="npwp"
                       type="text"
                       class="form-control @error('npwp') is-invalid @enderror"
                       name="npwp"
                       value="{{ $pegawai->npwp }}"
                       placeholder="NPWP">
                @error('npwp')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="nama"
                       class="form-label">Nama</label>
                <input id="nama"
                       type="text"
                       class="form-control @error('nama') is-invalid @enderror"
                       name="nama"
                       value="{{ $pegawai->nama }}"
                       placeholder="Nama"
                       value="{{ old('npp') }}">
                @error('nama')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="email"
                       class="form-label">Email</label>
                <input id="email"
                       type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email"
                       placeholder="email"
                       value="{{ $pegawai->email }}">
                @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="no_hp"
                       class="form-label">No HP</label>
                <input id="no_hp"
                       type="phone"
                       class="form-control @error('no_hp') is-invalid @enderror"
                       name="no_hp"
                       placeholder="No HP"
                       value="{{ $pegawai->no_hp }}">
                @error('no_hp')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for=""
                       class="form-label">Status Pegawai</label>
                <select id="st_peg"
                        class="form-select @error('st_peg') is-invalid @enderror"
                        name="st_peg">
                  <option hidden>Pilih Status Pegawai</option>
                  <option value="Direktur"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_kepegawaian) == 'DIREKTUR') selected="true" @endif>DIREKTUR</option>
                  <option value="KONTRAK"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_kepegawaian) == 'KONTRAK') selected="true" @endif>KONTRAK</option>
                  <option value="TETAP"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_kepegawaian) == 'TETAP') selected="true" @endif>TETAP</option>
                  <option value="OS"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_kepegawaian) == 'OS') selected="true" @endif>OS</option>

                </select>
                @error('st_peg')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-3">

              <div class="mb-3">
                <label for=""
                       class="form-label">Status PTKP</label>
                <select id="st_ptkp"
                        class="form-select @error('st_ptkp') is-invalid @enderror"
                        name="st_ptkp">
                  <option hidden>Pilih Status PTKP</option>
                  <option value="TK0"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'TK0') selected="true" @endif>TK0</option>
                  <option value="TK1"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'TK1') selected="true" @endif>TK1</option>
                  <option value="TK2"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'TK2') selected="true" @endif>TK2</option>
                  <option value="TK3"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'TK3') selected="true" @endif>TK3</option>
                  <option value="K0"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'K0') selected="true" @endif>K0</option>
                  <option value="K1"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'K1') selected="true" @endif>K1</option>
                  <option value="K2"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'K2') selected="true" @endif>K2</option>
                  <option value="K3"
                          @if (\Illuminate\Support\Str::upper($pegawai->status_ptkp) == 'K3') selected="true" @endif>K3</option>
                </select>
                @error('st_ptkp')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="masuk"
                       class="form-label">TMT Masuk</label>
                <input id="masuk"
                       type="date"
                       class="form-control @error('masuk') is-invalid @enderror"
                       name="masuk"
                       @if ($pegawai->tmt_masuk != null) value="{{ old('masuk', Illuminate\Support\Carbon::parse($pegawai->tmt_masuk)->format('Y-m-d')) }}" @endif>
                @error('masuk')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="keluar"
                       class="form-label">TMT Keluar</label>
                <input id="keluar"
                       type="date"
                       class="form-control @error('keluar') is-invalid @enderror"
                       name="keluar"
                       @if ($pegawai->tmt_keluar != null) value="{{ old('keluar', \Illuminate\Support\Carbon::parse($pegawai->tmt_keluar)->format('Y-m-d')) }}" @endif>
                @error('keluar')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-2">
              <button type="submit"
                      class="btn btn-primary">
                Perbarui
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@once
  @push('scripts')
    <script type="module">
      document.addEventListener("DOMContentLoaded", () => {
        var inputNpwp = document.getElementById("npwp");
        var maskNpwp = new Inputmask("99.999.999.9-999.999");
        maskNpwp.mask(inputNpwp);

        var inputHp = document.getElementById("no_hp");
        var maskHp = new Inputmask("08999999[9999]");
        maskHp.mask(inputHp);
      });
    </script>
  @endpush
@endonce
