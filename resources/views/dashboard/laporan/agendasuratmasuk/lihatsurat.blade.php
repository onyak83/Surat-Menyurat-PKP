@if ($row->file_surat)
    <button type="button" class="btn btn-success btn-icon btn-round btn-preview-surat" data-bs-toggle="modal"
        data-bs-target="#modalPreviewSurat" data-file="{{ asset('storage/' . $row->file_surat) }}" title="Lihat Surat">

        <i class="fa fa-eye"></i>
    </button>
@else
    <span class="badge bg-secondary">
        Tidak Ada
    </span>
@endif

<div class="modal fade" id="modalPreviewSurat" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa fa-file-pdf"></i>
                    Preview Surat
                </h5>

                <button class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body p-0">

                <iframe id="previewSurat" width="100%" height="700" style="border:none;">
                </iframe>

            </div>

        </div>
    </div>
</div>
