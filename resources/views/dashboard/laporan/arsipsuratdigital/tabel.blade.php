<style>
    .card-arsip {
        transition: .3s;
        cursor: pointer;
    }

    .card-arsip:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
    }

    .arsip-card {
        border-radius: 16px;
        transition: .3s;
        overflow: hidden;
    }

    .arsip-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, .15);
    }

    .arsip-header {
        color: #fff;
        padding: 12px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }

    .pdf-icon {
        font-size: 70px;
        color: #dc3545;
        transition: .3s;
    }

    .arsip-card:hover .pdf-icon {
        transform: scale(1.1);
    }

    .nomor-surat {
        font-weight: 700;
        text-align: center;
        margin-bottom: 12px;
        font-size: 15px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .perihal {
        text-align: center;
        min-height: 48px;
        line-height: 22px;
        font-size: 14px;
        font-weight: 500;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .info {
        font-size: 13px;
    }

    .info div {
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-footer {
        border-top: 1px solid #eee;
        padding: 12px;
    }

    .card-footer .btn {
        border-radius: 10px;
    }

    .card-footer .btn:hover {
        background: #0d6efd;
        color: #fff;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{-- button  --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <button type="button" id="btnMasuk" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-inbox me-2"></i>
                            Arsip Digital Surat Masuk
                        </button>
                    </div>

                    <div class="col-md-6">
                        <button type="button" id="btnKeluar" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            Arsip Digital Surat Keluar
                        </button>
                    </div>
                </div>

                <input type="hidden" id="jenis_surat" value="masuk">

                {{-- form filter --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-search me-2"></i>
                            Pencarian Arsip
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nomor Surat</label>
                                <input type="text" class="form-control" id="nomor_surat">
                            </div>

                            <div class="col-md-3">
                                <label>Tanggal Surat</label>
                                <input type="date" class="form-control" id="tanggal_surat">
                            </div>

                            <div class="col-md-3">
                                <label>Perihal</label>
                                <input type="text" class="form-control" id="perihal">
                            </div>

                            <div class="col-md-3">
                                <label>Instansi</label>
                                <select class="form-select" id="instansi_id">
                                    <option value="">-- Semua Instansi --</option>
                                    @foreach ($instansi as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama_instansi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="button" id="btnCari" class="btn btn-primary">
                                <i class="fa fa-search"></i> Cari
                            </button>

                            <button type="button" id="btnReset" class="btn btn-secondary">
                                Reset
                            </button>
                        </div>
                    </div>

                </div>

                {{-- rown menampilkan data surat --}}
                <div class="row" id="dataArsip">
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt"></i>
                    Detail Arsip Surat
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nomor Surat</th>
                        <td id="d_no_surat"></td>
                    </tr>
                    <tr>
                        <th>Jenis Surat</th>
                        <td id="d_jenis"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Surat</th>
                        <td id="d_tanggal"></td>
                    </tr>
                    <tr>
                        <th>No Agenda</th>
                        <td id="d_agenda"></td>
                    </tr>
                    <tr>
                        <th>Instansi</th>
                        <td id="d_instansi"></td>
                    </tr>
                    <tr>
                        <th>Sifat Surat</th>
                        <td id="d_sifat"></td>
                    </tr>
                    <tr>
                        <th>Perihal</th>
                        <td id="d_perihal"></td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td id="d_lampiran"></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td id="d_keterangan"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


@push('myscript')
    <script>
        $(document).ready(function() {

            // Default halaman pertama
            aktifSuratMasuk();
            loadArsip();

            // button surat masuk
            $('#btnMasuk').click(function() {
                $('#jenis_surat').val('masuk');
                aktifSuratMasuk();
                loadArsip();
            });

            // button surat keluar
            $('#btnKeluar').click(function() {
                $('#jenis_surat').val('keluar');
                aktifSuratKeluar();
                loadArsip();
            });

            // button cari
            $('#btnCari').click(function() {
                loadArsip();
            });

            // enter text box
            $('#nomor_surat,#tanggal_surat,#perihal').keypress(function(e) {
                if (e.which == 13) {
                    loadArsip();
                }
            });

            // instansi berubah
            $('#instansi_id').change(function() {
                loadArsip();
            });

            // reset
            $('#btnReset').click(function() {
                $('#nomor_surat').val('');
                $('#tanggal_surat').val('');
                $('#perihal').val('');
                $('#instansi_id').val('');
                loadArsip();
            });
        });


        // load arsip
        function loadArsip() {
            $('#dataArsip').html(`
        <div class="col-md-12">
            <div class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                <br><br>
                Memuat data...
            </div>
        </div>
    `);

            $.ajax({
                url: "{{ route('get.ArsipDigital') }}",
                type: "GET",
                data: {
                    jenis_surat: $('#jenis_surat').val(),
                    nomor_surat: $('#nomor_surat').val(),
                    tgl_surat: $('#tanggal_surat').val(),
                    perihal: $('#perihal').val(),
                    instansi_id: $('#instansi_id').val()
                },

                success: function(response) {
                    let html = '';
                    if (response.length == 0) {
                        html = `
                <div class="col-md-12">
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                        <br>
                        Data arsip tidak ditemukan.
                    </div>
                </div>
                `;
                    } else {
                        $.each(response, function(i, item) {
                            html += `
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
    <div class="card arsip-card border-0 shadow-sm h-100">
        <!-- Header -->
        <div class="arsip-header
            ${item.jenis_surat=='masuk' ? 'bg-primary' : 'bg-success'}">
            <span>
                <i class="fas ${item.jenis_surat=='masuk'
                    ? 'fa-inbox'
                    : 'fa-paper-plane'} me-1"></i>

                ${item.jenis_surat.toUpperCase()}
            </span>
            <span class="badge bg-warning text-dark">
                ${item.sifat_surat.nama_sifat}
            </span>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="text-center mb-3">
                <a href="/storage/${item.file_surat}" target="_blank">
                    <i class="fas fa-file-pdf pdf-icon"></i>
                </a>
            </div>
            <div class="nomor-surat">
                ${item.no_surat}
            </div>
            <div class="perihal">
                ${item.perihal}
            </div>

            <hr>

            <div class="info">
                <div>
                    <i class="fas fa-building text-primary"></i>
                    ${item.instansi.nama_instansi}
                </div>
                <div>
                    <i class="fas fa-calendar-alt text-success"></i>
                    ${item.tgl_surat}
                </div>
            </div>
        </div>

        <!-- Footer -->
       <div class="card-footer bg-light">
    <div class="row g-2">

        <div class="col-3">
            <button
                class="btn btn-warning btn-sm w-100 btn-detail"
                data-id="${item.id}"
                title="Detail Surat">

                <i class="fas fa-info-circle"></i>

            </button>
        </div>

        <div class="col-3">
            <a href="/storage/${item.file_surat}"
                target="_blank"
                class="btn btn-primary btn-sm w-100"
                title="Lihat PDF">

                <i class="fas fa-eye"></i>

            </a>
        </div>

        <div class="col-3">
            <a href="/storage/${item.file_surat}"
                download
                class="btn btn-success btn-sm w-100"
                title="Download">

                <i class="fas fa-download"></i>

            </a>
        </div>

        <div class="col-3">
            <button
                class="btn btn-danger btn-sm w-100 btn-print"
                data-file="${item.file_surat}"
                title="Cetak">

                <i class="fas fa-print"></i>

            </button>
        </div>

    </div>
</div>
    </div>
</div>
`;
                        });
                    }
                    $('#dataArsip').html(html);

                },
                error: function() {
                    $('#dataArsip').html(`
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        Terjadi kesalahan saat mengambil data.
                    </div>
                </div>
            `);
                }
            });
        }

        // button aktif
        function aktifSuratMasuk() {
            $('#btnMasuk')
                .removeClass('btn-outline-primary')
                .addClass('btn-primary');
            $('#btnKeluar')
                .removeClass('btn-success')
                .addClass('btn-outline-success');
        }

        function aktifSuratKeluar() {
            $('#btnKeluar')
                .removeClass('btn-outline-success')
                .addClass('btn-success');
            $('#btnMasuk')
                .removeClass('btn-primary')
                .addClass('btn-outline-primary');
        }
    </script>

    <script>
        $(document).on('click', '.btn-print', function() {
            let file = $(this).data('file');
            window.open('/storage/' + file, '_blank');
        });
    </script>


    {{-- menampilkan detail surat --}}
    <script>
        $(document).on('click', '.btn-detail', function() {

            let id = $(this).data('id');

            $.ajax({

                url: "{{ url('arsip-digital/detail') }}/" + id,

                type: "GET",

                success: function(data) {

                    $('#d_no_surat').text(data.no_surat);

                    $('#d_jenis').text(
                        data.jenis_surat == 'masuk' ?
                        'Surat Masuk' :
                        'Surat Keluar'
                    );

                    $('#d_tanggal').text(data.tgl_surat);

                    $('#d_agenda').text(data.no_agenda ?? '-');

                    $('#d_instansi').text(data.instansi.nama_instansi);

                    $('#d_sifat').text(data.sifat_surat.nama_sifat);

                    $('#d_perihal').text(data.perihal);

                    $('#d_lampiran').text(data.lampiran ?? '-');

                    $('#d_keterangan').text(data.keterangan ?? '-');

                    $('#btnLihatPdf')
                        .attr('href', '/storage/' + data.file_surat);

                    $('#modalDetail').modal('show');

                }

            });

        });
    </script>
@endpush
