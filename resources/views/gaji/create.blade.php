<!-- Modal -->
<div class="modal fade" id="modalCreateSalary" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('gaji/store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Tambah / Perbarui Data Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" name="month" value="{{ $getMonth }}">
                    <input type="hidden" name="year" value="{{ $getYear }}">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="nppDataList" class="form-label">NPP</label>
                            <input class="form-control @error('npp') is-invalid @enderror" list="datalistOptions"
                                id="nppDataList" name="npp" placeholder="Cari NPP">
                            <datalist id="datalistOptions">
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->npp }}">{{ $p->nama }}</option>
                                @endforeach
                            </datalist>
                            <small id="helpNPP" class="invalid-feedback">NPP tidak ditemukan!</small>
                            @error('npp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama</label>
                            <input type="text" class="form-control bg-light @error('nama') is-invalid @enderror"
                                name="nama" id="nama" placeholder="Nama" value="{{ old('nama') }}" readonly>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Status PTKP</label>
                            <select class="form-select @error('st_ptkp') is-invalid @enderror" name="st_ptkp"
                                id="st_ptkp">
                                <option value="">Pilih Status PTKP</option>
                                <option value="TK0">TK0</option>
                                <option value="TK1">TK1</option>
                                <option value="TK2">TK2</option>
                                <option value="TK3">TK3</option>
                                <option value="K0">K0</option>
                                <option value="K1">K1</option>
                                <option value="K2">K2</option>
                                <option value="K3">K3</option>
                            </select>
                            @error('st_ptkp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Gaji Pokok</label>
                            <input type="text" class="form-control @error('gapok') is-invalid @enderror"
                                name="gapok" id="gapok" placeholder="Gaji Pokok" value="{{ old('gapok', 0) }}">
                            @error('gapok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr class="text-info m-auto" style="border-width: 7px; width: 90%;">
                    <strong for="tunjangan" class="my-2">Tunjangan</strong>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Keluarga</label>
                            <input type="text" class="form-control @error('tj_kelu') is-invalid @enderror"
                                name="tj_kelu" id="tj_kelu" placeholder="Tunjangan Keluarga"
                                value="{{ old('tj_kelu', 0) }}">
                            @error('tj_kelu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Pendidikan</label>
                            <input type="text" class="form-control @error('tj_pend') is-invalid @enderror"
                                name="tj_pend" id="tj_pend" placeholder="Tunjangan Pendidikan"
                                value="{{ old('tj_pend', 0) }}">
                            @error('tj_pend')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Jabatan</label>
                            <input type="text" class="form-control @error('tj_jbt') is-invalid @enderror"
                                name="tj_jbt" id="tj_jbt" placeholder="Tunjangan Jabatan"
                                value="{{ old('tj_jbt', 0) }}">
                            @error('tj_jbt')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Kesejahteraan</label>
                            <input type="text" class="form-control @error('tj_kesja') is-invalid @enderror"
                                name="tj_kesja" id="tj_kesja" placeholder="Tunjangan Kesejahteraan"
                                value="{{ old('tj_kesja', 0) }}">
                            @error('tj_kesja')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Makan</label>
                            <input type="text" class="form-control @error('tj_makan') is-invalid @enderror"
                                name="tj_makan" id="tj_makan" placeholder="Tunjangan Makan"
                                value="{{ old('tj_makan', 0) }}">
                            @error('tj_makan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Kesehatan</label>
                            <input type="text" class="form-control @error('tj_kes') is-invalid @enderror"
                                name="tj_kes" id="tj_kes" placeholder="Tunjangan Kesehatan"
                                value="{{ old('tj_kes', 0) }}">
                            @error('tj_kes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Ketenagakerjaan</label>
                            <input type="text" class="form-control @error('tj_sostek') is-invalid @enderror"
                                name="tj_sostek" id="tj_sostek" placeholder="Tunjangan Ketenagakerjaan"
                                value="{{ old('tj_sostek', 0) }}">
                            @error('tj_sostek')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Dapen</label>
                            <input type="text" class="form-control @error('tj_dapen') is-invalid @enderror"
                                name="tj_dapen" id="tj_dapen" placeholder="Tunjangan Dapen"
                                value="{{ old('tj_dapen', 0) }}">
                            @error('tj_dapen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Kehadiran</label>
                            <input type="text" class="form-control @error('tj_hadir') is-invalid @enderror"
                                name="tj_hadir" id="tj_hadir" placeholder="Tunjangan Kehadiran"
                                value="{{ old('tj_hadir', 0) }}">
                            @error('tj_hadir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Tunjangan Lainnya</label>
                            <input type="text" class="form-control @error('tj_lainnya') is-invalid @enderror"
                                name="tj_lainnya" id="tj_lainnya" placeholder="Tunjangan Lainnya"
                                value="{{ old('tj_lainnya', 0) }}">
                            @error('tj_lainnya')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">THR</label>
                            <input type="text" class="form-control @error('thr') is-invalid @enderror"
                                name="thr" id="thr" placeholder="THR" value="{{ old('thr', 0) }}">
                            @error('thr')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Bonus</label>
                            <input type="text" class="form-control @error('bonus') is-invalid @enderror"
                                name="bonus" id="bonus" placeholder="Bonus" value="{{ old('bonus', 0) }}">
                            @error('bonus')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Lembur</label>
                            <input type="text" class="form-control @error('lembur') is-invalid @enderror"
                                name="lembur" id="lembur" placeholder="Lembur" value="{{ old('lembur', 0) }}">
                            @error('lembur')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Kurang</label>
                            <input type="text" class="form-control @error('kurang') is-invalid @enderror"
                                name="kurang" id="kurang" placeholder="Kurang" value="{{ old('kurang', 0) }}">
                            @error('kurang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr class="text-warning m-auto" style="border-width: 7px; width: 90%;">
                    <strong for="potongan" class="my-2">Potongan</strong>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Potongan Dapen</label>
                            <input type="text" class="form-control @error('pot_dapen') is-invalid @enderror"
                                name="pot_dapen" id="pot_dapen" placeholder="Potongan Dapen"
                                value="{{ old('pot_dapen', 0) }}">
                            @error('pot_dapen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Potongan Ketenagakerjaan</label>
                            <input type="text" class="form-control @error('pot_sostek') is-invalid @enderror"
                                name="pot_sostek" id="pot_sostek" placeholder="Potongan Ketenagakerjaan"
                                value="{{ old('pot_sostek', 0) }}">
                            @error('pot_sostek')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Potongan Kesehatan</label>
                            <input type="text" class="form-control @error('pot_kes') is-invalid @enderror"
                                name="pot_kes" id="pot_kes" placeholder="Potongan Kesehatan"
                                value="{{ old('pot_kes', 0) }}">
                            @error('pot_kes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Potongan SWK</label>
                            <input type="text" class="form-control @error('pot_swk') is-invalid @enderror"
                                name="pot_swk" id="pot_swk" placeholder="Potongan SWK"
                                value="{{ old('pot_swk', 0) }}">
                            @error('pot_swk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
