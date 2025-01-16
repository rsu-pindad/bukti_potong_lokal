@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between flex-row">
      <h4>Edit Epin Data Pegawai</h4>
    </div>
    <div class="card-body">
      <div class="card-title">
        <a href="{{ route('pajak-employee-index') }}"
           class="btn btn-outline-secondary">
          <i class="fa-solid fa-chevron-left mr-2"></i>
          Kembali
        </a>
      </div>
      <div>
        <form action="{{ route('pajak-employee-epin-update', ['id' => $pegawai->id]) }}"
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
                <label for="npwp"
                       class="form-label">NPWP</label>
                <input id="npwp"
                       type="text"
                       class="form-control @error('npwp') is-invalid @enderror"
                       name="npwp"
                       value="{{ $pegawai->npwp }}"
                       placeholder="NPWP"
                       >
                @error('npwp')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="epin"
                       class="form-label">EPIN</label>
                <input id="epin"
                       class="form-control @error('epin') is-invalid @enderror"
                       list="datalistOptions"
                       value="{{ $pegawai->epin ?? '' }}"
                       name="epin"
                       placeholder="Masukan Epin">
                @error('epin')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
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
      });
    </script>
  @endpush
@endonce
