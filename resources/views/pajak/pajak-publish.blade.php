@extends('layout.main')
@section('content')
  <div class="card">
    <div class="card-header">
      <h3>File Pajak</h3>
    </div>
    <div class="card-body">
      <div class="card-title mb-4">
        <a href="{{ route('pajak-index') }}"
           class="btn btn-outline-secondary">
          <i class="fa-solid fa-chevron-left mr-2"></i>
          Kembali
        </a>
      </div>
      <form class="row g-2"
            action="{{ route('pajak-published') }}"
            method="post">
        @csrf
        <div class="row mb-3">
          <div class="col">
            <label for="namaFile">Nama File</label>
            <input id="namaFile"
                   type="text"
                   name="namaFile"
                   class="form-control"
                   value="{{ $nama_file }}"
                   readonly
                   required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <label for="bulan">Pilih Bulan</label>
            <select id="bulan"
                    name="bulan"
                    class="form-select">
              <option selected
                      hidden>Pilih Bulan</option>
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
            @error('bulan')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="col-6">
            <label for="tahun">Pilih Tahun</label>
            <select id="tahun"
                    name="tahun"
                    class="form-select">
              <option selected
                      hidden>Pilih Tahun</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
              <option value="2026">2026</option>
              <option value="2027">2027</option>
            </select>
            @error('tahun')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
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
@endsection
