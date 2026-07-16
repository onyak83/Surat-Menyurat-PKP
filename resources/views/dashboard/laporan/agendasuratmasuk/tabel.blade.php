<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="formFilterAgenda">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold">
                                <i class="fa fa-filter text-primary me-2"></i>
                                Filter Laporan
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <!-- Tanggal Awal -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
                                </div>
                                <!-- Tanggal Akhir -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                                </div>
                                <!-- Tanggal Surat -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Surat</label>
                                    <input type="date" name="tgl_surat" id="tgl_surat" class="form-control">
                                </div>
                                <!-- Sifat Surat -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Sifat Surat</label>
                                    <select name="sifat_surat" id="sifat_surat" class="form-select">
                                        <option value="">Semua Sifat Surat</option>
                                        @foreach ($sifatSurat as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama_sifat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- instansi -->
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Instansi</label>
                                    <select name="instansi_id" id="instansi_id" class="form-select">
                                        <option value="">Semua Instansi</option>

                                        @foreach ($instansiview as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama_instansi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Tombol -->
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="button" id="btnFilter" class="btn btn-primary" title="Lihat">
                                            <i class="fa fa-search me-1"></i>
                                        </button>

                                        <button type="button" id="btnDownload" class="btn btn-success"
                                            title="Download ">
                                            <i class="fa fa-download me-1"></i>
                                        </button>

                                        <button type="button" id="btnReset" class="btn btn-secondary" title="Reset">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

                <div class="alert alert-light border mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Periode</strong><br>
                            <span id="periode">-</span>
                        </div>

                        <div class="col-md-3">
                            <strong>Sifat Surat</strong><br>
                            <span id="info_sifat">Semua</span>
                        </div>

                        <div class="col-md-3">
                            <strong>Instansi</strong><br>
                            <span id="info_instansi">Semua</span>
                        </div>

                        <div class="col-md-2 text-end">
                            <strong>Jumlah Surat</strong><br>
                            <span class="badge bg-primary fs-6" id="jumlah_surat">
                                0 Surat
                            </span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="agendasuratmasuk" class="table table-bordered table-striped table-hover table-sm w-100">
                        <thead class="table-primary text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">No. Agenda</th>
                                <th width="12%">Tgl. Terima</th>
                                <th width="18%">No. & Tgl.Surat</th>
                                <th width="18%">Sifat Surat</th>
                                <th width="20%">Pengirim</th>
                                <th>Perihal</th>
                                <th width="8%" class="text-center">File</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('myscript')
    <script>
        $(document).ready(function() {
            let table = $('#agendasuratmasuk').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('get.AgendaSuratMasuk') }}",
                    data: function(d) {
                        d.tgl_awal = $('#tgl_awal').val();
                        d.tgl_akhir = $('#tgl_akhir').val();
                        d.sifat_surat = $('#sifat_surat').val();
                        d.tgl_surat = $('#tgl_surat').val();
                        d.instansi_id = $('#instansi_id').val();
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        width: '5%'
                    },
                    {
                        data: 'no_agenda',
                        className: 'text-center'
                    },
                    {
                        data: 'tgl_diterima',
                        className: 'text-center'
                    },
                    {
                        data: 'no_surat'
                    },
                    {
                        data: 'sifat_surat',
                        className: 'text-center'
                    },
                    {
                        data: 'instansi'
                    },
                    {
                        data: 'perihal'
                    },
                    {
                        data: 'lihatsurat',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '8%'
                    }

                ],

                language: {
                    search: "",
                    searchPlaceholder: "",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Belum ada data",
                    processing: "Memuat data...",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });

            // btn filter
            $('#btnFilter').click(function() {
                table.ajax.reload();
                updateInformasi();
            });

            // btn reset
            $('#btnReset').click(function() {
                $('#formFilterAgenda')[0].reset();
                table.ajax.reload();
                $('#periode').html('-');
                $('#info_sifat').html('Semua');
                $('#info_instansi').html('Semua');
                $('#jumlah_surat').html('0 Surat');
            });


            function updateInformasi() {
                let awal = $('#tgl_awal').val();
                let akhir = $('#tgl_akhir').val();

                if (awal != '' && akhir != '') {
                    $('#periode').html(awal + ' s.d ' + akhir);
                } else {
                    $('#periode').html('-');
                }

                let sifat = $('#sifat_surat option:selected').text();

                if ($('#sifat_surat').val() == '') {
                    sifat = 'Semua';
                }

                $('#info_sifat').html(sifat);

                let instansi = $('#instansi_id option:selected').text();

                if ($('#instansi_id').val() == '') {
                    instansi = 'Semua';
                }

                $('#info_instansi').html(instansi);

            }

            // update jumlah surat
            table.on('xhr.dt', function() {
                let json = table.ajax.json();
                if (json.recordsFiltered !== undefined) {
                    $('#jumlah_surat').html(json.recordsFiltered + ' Surat');
                }
            });

        });
    </script>

    <script>
        $(document).on('click', '.btn-preview-surat', function() {
            let file = $(this).data('file');
            $('#previewSurat').attr('src', file);

        });

        $('#modalPreviewSurat').on('hidden.bs.modal', function() {
            $('#previewSurat').attr('src', '');
        });
    </script>
@endpush
