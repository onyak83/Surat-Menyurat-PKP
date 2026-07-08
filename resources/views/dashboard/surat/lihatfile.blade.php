<button type="button" class="btn btn-success btn-icon btn-round btn-view-file" data-bs-toggle="modal" title="Lihat File"
    data-bs-target="#modalFileSurat" data-file="{{ asset('storage/' . $surat->file_surat) }}">
    <i class="fa fa-eye"></i>
</button>

<div class="modal fade" id="modalFileSurat">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Preview File Surat

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body p-0">

                <iframe id="pdfViewer" src="" width="100%" height="700" style="border:none">

                </iframe>

            </div>

        </div>

    </div>

</div>
