@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between flex-row">
      <h4>File Bukti Potong Pajak</h4>
      <div class="my-auto">
        <a href="{{ route('pajak-file-index') }}"
           class="btn btn-outline-secondary">
          <i class="fa-solid fa-chevron-left mr-2"></i>
          Kembali
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="container">
        <form action="{{ route('pajak-file-published') }}"
              method="post"
              class="row">
          @csrf
          <div class="row mb-3">
            <div class="col">
              <label for="namaFile">Nama File</label>
              <div class="input-group">
                <input id="namaFile"
                       type="text"
                       name="namaFile"
                       class="form-control"
                       value="{{ $nama_file }}"
                       readonly>
                @error('namaFile')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-6">
              <label for="bulan">Pilih Bulan</label>
              <select id="bulan"
                      name="bulan"
                      @if ($errors->has('bulan'))
                      class="form-select is-invalid"
                      @else
                      class="form-select"
                      @endif
                      >
                <option selected
                        hidden
                        value="">Pilih Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Febuari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
              @if ($errors->has('bulan'))
                <div id="bulan"
                     class="invalid-feedback">
                  {{ $errors->first('bulan') }}
                </div>
              @endif
            </div>
            <div class="col-6">
              <label for="tahun">Pilih Tahun</label>
              <select id="tahun"
                      name="tahun"
                      @if ($errors->has('tahun'))
                      class="form-select is-invalid"
                      @else
                      class="form-select"
                      @endif
                      >
                <option selected
                        hidden
                        value="">Pilih Tahun</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
              </select>
              @if ($errors->has('tahun'))
                <div id="tahun"
                     class="invalid-feedback">
                  {{ $errors->first('tahun') }}
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <button type="submit"
                      class="btn btn-primary">
                Publish
                <i class="fa-solid fa-share-nodes"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
