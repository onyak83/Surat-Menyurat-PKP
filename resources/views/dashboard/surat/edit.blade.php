@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Edit Surat</h3>
                </div>

                <ul class="breadcrumbs mb-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('index.Surat') }}">Semua Surat</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Surat</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xl-7">
                            <div class="card">
                                <form action="{{ route('update.Surat', $surat->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Jenis Surat -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Surat <span class="text-danger">*</span></label>

                                                    <select name="jenis_surat" id="jenis_surat" class="form-select"
                                                        required>
                                                        <option value="">-- Pilih Jenis Surat --</option>

                                                        <option value="masuk"
                                                            {{ old('jenis_surat', $surat->jenis_surat) == 'masuk' ? 'selected' : '' }}>
                                                            Surat Masuk
                                                        </option>

                                                        <option value="keluar"
                                                            {{ old('jenis_surat', $surat->jenis_surat) == 'keluar' ? 'selected' : '' }}>
                                                            Surat Keluar
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Sifat Surat -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sifat Surat <span class="text-danger">*</span></label>

                                                    <select name="sifat_surat_id" class="form-select" required>
                                                        <option value="">-- Pilih Sifat Surat --</option>

                                                        @foreach ($sifatSurat as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('sifat_surat_id', $surat->sifat_surat_id) == $item->id ? 'selected' : '' }}>
                                                                {{ $item->nama_sifat }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- No Agenda -->
                                            <div class="col-md-6" id="div_no_agenda">
                                                <div class="form-group">
                                                    <label>No Agenda</label>
                                                    <input type="text" name="no_agenda" id="no_agenda"
                                                        class="form-control"
                                                        value="{{ old('no_agenda', $surat->no_agenda) }}">
                                                </div>
                                            </div>

                                            <!-- Nomor Surat -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor Surat <span class="text-danger">*</span></label>
                                                    <input type="text" name="no_surat" class="form-control"
                                                        value="{{ old('no_surat', $surat->no_surat) }}" required>
                                                </div>
                                            </div>

                                            <!-- Tanggal Surat -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Surat <span class="text-danger">*</span></label>
                                                    <input type="date" name="tgl_surat" class="form-control"
                                                        value="{{ old('tgl_surat', $surat->tgl_surat) }}" required>
                                                </div>
                                            </div>

                                            <!-- Tanggal Diterima -->
                                            <div class="col-md-6" id="div_tgl_diterima">
                                                <div class="form-group">
                                                    <label>Tanggal Diterima</label>
                                                    <input type="date" name="tgl_diterima" id="tgl_diterima"
                                                        class="form-control"
                                                        value="{{ old('tgl_diterima', $surat->tgl_diterima) }}">
                                                </div>
                                            </div>

                                            <!-- Pengirim / Tujuan -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label id="label_instansi">
                                                        Pengirim / Tujuan <span class="text-danger">*</span>
                                                    </label>

                                                    <input type="text" name="instansi" id="instansi"
                                                        class="form-control"
                                                        value="{{ old('instansi', $surat->instansi) }}"
                                                        placeholder="Masukkan pengirim atau tujuan surat" required>
                                                </div>
                                            </div>

                                            <!-- Perihal -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Perihal <span class="text-danger">*</span></label>
                                                    <input type="text" name="perihal" class="form-control"
                                                        value="{{ old('perihal', $surat->perihal) }}" required>
                                                </div>
                                            </div>

                                            <!-- Lampiran -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lampiran</label>
                                                    <input type="text" name="lampiran" class="form-control"
                                                        value="{{ old('lampiran', $surat->lampiran) }}">
                                                </div>
                                            </div>

                                            <!-- Upload File -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>File Surat <b>(Kosongkan jika tidak ingin mengganti)</b></label>

                                                    <input type="file" name="file_surat" class="form-control"
                                                        accept=".pdf">

                                                    @if ($surat->file_surat)
                                                        <small class="text-success d-block mt-2">
                                                            File saat ini :
                                                            <a href="javascript:void(0)" class="btn-view-file"
                                                                data-bs-toggle="modal" data-bs-target="#modalFileSurat"
                                                                data-file="{{ asset('storage/' . $surat->file_surat) }}">
                                                                <i class="fa fa-eye"></i> Lihat File
                                                            </a>
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" rows="2" class="form-control">{{ old('keterangan', $surat->keterangan) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-action text-center">
                                        <a href="{{ route('index.Surat') }}" class="btn btn-danger">
                                            <i class="fa fa-times"></i> Batal
                                        </a>

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-save"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modalFileSurat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-file-pdf text-danger"></i>
                        Preview File Surat
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body p-0">

                    <iframe id="pdfViewer" src="" width="100%" height="700" style="border:none;">
                    </iframe>

                </div>

            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {

            function toggleJenisSurat() {

                let jenis = $('#jenis_surat').val();

                if (jenis == 'masuk') {

                    // Tampilkan field khusus Surat Masuk
                    $('#div_no_agenda').slideDown(200);
                    $('#div_tgl_diterima').slideDown(200);

                    $('#no_agenda').prop('disabled', false);
                    $('#tgl_diterima').prop('disabled', false);

                    // Ubah label
                    $('#label_instansi').html('Pengirim <span class="text-danger">*</span>');

                    // Ubah placeholder
                    $('#instansi').attr('placeholder', 'Masukkan nama pengirim');

                } else if (jenis == 'keluar') {

                    // Sembunyikan field khusus Surat Keluar
                    $('#div_no_agenda').slideUp(200);
                    $('#div_tgl_diterima').slideUp(200);

                    $('#no_agenda').prop('disabled', true);
                    $('#tgl_diterima').prop('disabled', true);

                    // Ubah label
                    $('#label_instansi').html('Tujuan <span class="text-danger">*</span>');

                    // Ubah placeholder
                    $('#instansi').attr('placeholder', 'Masukkan nama tujuan');

                } else {

                    $('#div_no_agenda').hide();
                    $('#div_tgl_diterima').hide();

                    $('#no_agenda').prop('disabled', true);
                    $('#tgl_diterima').prop('disabled', true);

                    $('#label_instansi').html('Pengirim / Tujuan <span class="text-danger">*</span>');
                    $('#instansi').attr('placeholder', 'Masukkan pengirim atau tujuan surat');
                }
            }

            // Jalankan saat halaman pertama kali dibuka
            toggleJenisSurat();

            // Jalankan ketika Jenis Surat berubah
            $('#jenis_surat').on('change', function() {
                toggleJenisSurat();
            });

        });
    </script>

    <script>
        $(document).on('click', '.btn-view-file', function() {
            let file = $(this).data('file');
            $('#pdfViewer').attr('src', file);
        });

        // Bersihkan iframe saat modal ditutup
        $('#modalFileSurat').on('hidden.bs.modal', function() {
            $('#pdfViewer').attr('src', '');
        });
    </script>
@endpush
