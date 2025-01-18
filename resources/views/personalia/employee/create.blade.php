 <!-- Modal -->
 <div id="modalCreateEmployee"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalTitleId"
      aria-hidden="true">
   <div class="modal-dialog modal-sm modal-lg"
        role="document">
     <div class="modal-content">
       <form action="{{ route('pegawai/store') }}"
             method="post">
         @csrf
         <div class="modal-header">
           <h5 id="modalTitleId"
               class="modal-title">Tambah / Perbarui Data Pegawai</h5>
           <button type="button"
                   class="btn-close"
                   data-bs-dismiss="modal"
                   aria-label="Close"></button>

         </div>
         <div class="modal-body row">
           <div class="col-md-6">
             <div class="mb-3">
               <label for="nppDataList"
                      class="form-label">NPP</label>
               <input id="nppDataList"
                      class="form-control @error('npp') is-invalid @enderror"
                      list="datalistOptions"
                      name="npp"
                      placeholder="Cari NPP">
               <datalist id="datalistOptions">
                 @foreach ($pegawai as $p)
                   <option value="{{ $p->npp }}">{{ $p->nama }}</option>
                 @endforeach
               </datalist>
               @error('npp')
                 <div class="invalid-feedback">
                   {{ $message }}
                 </div>
               @enderror
             </div>
           </div>
           <div class="col-md-6">
             <div class="mb-3">
               <label for=""
                      class="form-label">Nama</label>
               <input id="nama"
                      type="text"
                      class="form-control @error('nama') is-invalid @enderror"
                      name="nama"
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
               <label for=""
                      class="form-label">Status Pegawai</label>
               <select id="st_peg"
                       class="form-select @error('st_peg') is-invalid @enderror"
                       name="st_peg">
                 <option value="">Pilih Status Pegawai</option>
                 <option value="KONTRAK">KONTRAK</option>
                 <option value="TETAP">TETAP</option>
               </select>
               @error('st_peg')
                 <div class="invalid-feedback">
                   {{ $message }}
                 </div>
               @enderror
             </div>
           </div>
           <div class="col-md-4">
             <div class="mb-3">
               <label for=""
                      class="form-label">Status PTKP</label>
               <select id="st_ptkp"
                       class="form-select @error('st_ptkp') is-invalid @enderror"
                       name="st_ptkp">
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
           <div class="col-md-4">
             <div class="mb-3">
               <label for=""
                      class="form-label">NPWP</label>
               <input id="npwp"
                      type="text"
                      class="form-control @error('npwp') is-invalid @enderror"
                      name="npwp"
                      placeholder="NPWP">
               @error('npwp')
                 <div class="invalid-feedback">
                   {{ $message }}
                 </div>
               @enderror
             </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="submit"
                   class="btn btn-primary">Simpan</button>
         </div>
       </form>

     </div>
   </div>
 </div>
