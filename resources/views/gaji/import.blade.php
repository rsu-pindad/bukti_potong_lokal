<!-- Modal -->
<div class="modal fade" id="modalImportSalary" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('gaji/import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Impor Data Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="" class="form-label">File</label>
                        <input type="file" class="form-control @error('fileGaji') is-invalid @enderror"
                            name="fileGaji" id="fileGaji"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        @error('fileGaji')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
