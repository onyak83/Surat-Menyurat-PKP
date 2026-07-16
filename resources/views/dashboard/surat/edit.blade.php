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
                        <div class="col-lg-10 col-xl-10">
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
                                                        value="{{ old('no_agenda', $surat->no_agenda) }}" readonly>
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
                                                    <label id="label_instansi">Instansi <span
                                                            class="text-danger">*</span></label>

                                                    <div class="input-group">
                                                        <select name="instansi_id" id="instansi_id" class="form-select"
                                                            required>
                                                            <option value="">-- Pilih Instansi --</option>
                                                            @foreach ($instansi as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ old('instansi_id', $surat->instansi_id) == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->nama_instansi }}
                                                                </option>
                                                            @endforeach

                                                        </select>

                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#modalInstansi">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                    @error('instansi_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

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

                                                    <label>
                                                        File Surat
                                                        <small class="text-muted">
                                                            (Kosongkan jika tidak ingin mengganti)
                                                        </small>
                                                    </label>

                                                    <input type="file" name="file_surat" class="form-control"
                                                        accept=".pdf">

                                                    @if ($surat->file_surat)
                                                        <div class="mt-2">

                                                            <a href="javascript:void(0)"
                                                                class="btn btn-sm btn-outline-primary btn-view-file"
                                                                data-bs-toggle="modal" data-bs-target="#modalFileSurat"
                                                                data-file="{{ asset('storage/' . $surat->file_surat) }}">

                                                                <i class="fa fa-eye"></i>
                                                                Lihat File Saat Ini

                                                            </a>

                                                        </div>
                                                    @endif

                                                </div>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" rows="3" class="form-control" placeholder="Masukkan keterangan tambahan...">{{ old('keterangan', $surat->keterangan) }}</textarea>
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

    <!-- Modal Tambah Instansi -->
    <div class="modal fade" id="modalInstansi" tabindex="-1" aria-labelledby="modalInstansiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formInstansi">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalInstansiLabel"><i class="fa fa-building"></i>
                            Tambah Instansi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- Kode Instansi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Instansi</label>
                                    <input type="text" name="kode_instansi" class="form-control" maxlength="30"
                                        placeholder="Contoh : BKPSDM">
                                    <small class="text-danger error-kode_instansi"></small>
                                </div>
                            </div>

                            <!-- Jenis Instansi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Jenis Instansi
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="jenis_instansi" class="form-control">
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        <option value="Kementerian">Kementerian</option>
                                        <option value="Lembaga">Lembaga</option>
                                        <option value="Pemerintah Provinsi">Pemerintah Provinsi</option>
                                        <option value="Pemerintah Kabupaten/Kota">Pemerintah Kabupaten/Kota</option>
                                        <option value="OPD">OPD</option>
                                        <option value="Kecamatan">Kecamatan</option>
                                        <option value="Kelurahan">Kelurahan</option>
                                        <option value="BUMN">BUMN</option>
                                        <option value="BUMD">BUMD</option>
                                        <option value="Swasta">Swasta</option>
                                        <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                        <option value="Organisasi">Organisasi</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <small class="text-danger error-jenis_instansi"></small>

                                </div>
                            </div>

                            <!-- Nama Instansi -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Instansi<span class="text-danger">*</span></label>
                                    <input type="text" name="nama_instansi" class="form-control"
                                        placeholder="Masukkan Nama Instansi">
                                    <small class="text-danger error-nama_instansi"></small>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" rows="3" class="form-control" placeholder="Masukkan Alamat"></textarea>
                                    <small class="text-danger error-alamat"></small>
                                </div>
                            </div>

                            <!-- Telepon -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input type="text" name="telepon" class="form-control" maxlength="30"
                                        placeholder="08xxxxxxxxxx">
                                    <small class="text-danger error-telepon"></small>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="contoh@email.com">
                                    <small class="text-danger error-email"></small>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="statusModal"
                                            name="status" value="1" checked>
                                        <label class="custom-control-label" for="statusModal">
                                            Status Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>

                        <button type="submit" id="btnSimpanInstansi" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            function toggleJenisSurat() {
                let jenis = $('#jenis_surat').val();
                if (jenis == 'masuk') {
                    $('#div_no_agenda').slideDown();
                    $('#div_tgl_diterima').slideDown();
                    $('#no_agenda').prop('disabled', false);
                    $('#tgl_diterima').prop('disabled', false);
                    $('#label_instansi').html(
                        'Instansi Asal <span class="text-danger">*</span>'
                    );

                } else if (jenis == 'keluar') {
                    $('#div_no_agenda').slideUp();
                    $('#div_tgl_diterima').slideUp();
                    $('#no_agenda').prop('disabled', true);
                    $('#tgl_diterima').prop('disabled', true);
                    $('#label_instansi').html(
                        'Instansi Tujuan <span class="text-danger">*</span>'
                    );

                } else {
                    $('#label_instansi').html(
                        'Instansi <span class="text-danger">*</span>'
                    );
                }
            }

            toggleJenisSurat();
            $('#jenis_surat').change(toggleJenisSurat);
        });
    </script>

    <script>
        function reloadInstansiDropdown(selected = '') {
            $.ajax({
                url: "{{ route('get.InstansiDropdown') }}",
                type: "GET",
                dataType: "json",

                success: function(response) {
                    let html = '<option value="">-- Pilih Instansi --</option>';
                    $.each(response, function(i, item) {
                        html += `
                    <option value="${item.id}">
                        ${item.nama_instansi}
                    </option>
                `;
                    });
                    $('#instansi_id').html(html);
                    if (selected != '') {
                        $('#instansi_id').val(selected);
                    }
                },

                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat memuat data Instansi.'
                    });
                }
            });
        }
    </script>

    <script>
        $(function() {
            $('#formInstansi').submit(function(e) {
                e.preventDefault();
                $('[class^="error-"]').text('');
                $('#btnSimpanInstansi')
                    .prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

                $.ajax({
                    url: "{{ route('store.Instansi') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $('#btnSimpanInstansi')
                            .prop('disabled', false)
                            .html('<i class="fa fa-save"></i> Simpan');

                        if (response.success) {
                            reloadInstansiDropdown(response.data.id);
                            $('#formInstansi')[0].reset();
                            const modalElement = document.getElementById('modalInstansi');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            if (modal) {
                                modal.hide();
                            }

                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                html: '<b>Instansi berhasil ditambahkan.</b><br>Silakan lanjutkan memilih instansi.',
                                timer: 1800,
                                showConfirmButton: false
                            });
                        }
                    },

                    error: function(xhr) {
                        $('#btnSimpanInstansi')
                            .prop('disabled', false)
                            .html('<i class="fa fa-save"></i> Simpan');

                        if (xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('.error-' + key).text(value[0]);
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    }
                });
            });
        });
    </script>


    <script>
        $(document).on('click', '.btn-view-file', function() {
            let file = $(this).data('file');
            $('#pdfViewer').attr('src', file);
        });

        $('#modalFileSurat').on('hidden.bs.modal', function() {
            $('#pdfViewer').attr('src', '');
        });
    </script>
@endpush
