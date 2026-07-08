@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Input Surat</h3>
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
                        <a href="#">Input Surat</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xl-7">
                            <div class="card">
                                <form action="{{ route('store.Surat') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

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
                                                            {{ old('jenis_surat') == 'masuk' ? 'selected' : '' }}>
                                                            Surat Masuk
                                                        </option>

                                                        <option value="keluar"
                                                            {{ old('jenis_surat') == 'keluar' ? 'selected' : '' }}>
                                                            Surat Keluar
                                                        </option>
                                                    </select>
                                                    @error('jenis_surat')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- No Agenda -->
                                            <div class="col-md-6" id="div_no_agenda">
                                                <div class="form-group">
                                                    <label>No Agenda</label>
                                                    <input type="text" name="no_agenda" id="no_agenda"
                                                        class="form-control" readonly
                                                        placeholder="Akan digenerate otomatis saat simpan">
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
                                                                {{ old('sifat_surat_id') == $item->id ? 'selected' : '' }}>
                                                                {{ $item->nama_sifat }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('sifat_surat_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Nomor Surat -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor Surat <span class="text-danger">*</span></label>
                                                    <input type="text" name="no_surat" class="form-control"
                                                        placeholder="Masukkan nomor surat" required
                                                        value="{{ old('no_surat') }}">
                                                </div>
                                            </div>

                                            <!-- Tanggal Surat -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Surat <span class="text-danger">*</span></label>
                                                    <input type="date" name="tgl_surat" class="form-control" required
                                                        value="{{ old('tgl_surat') }}">

                                                    @error('tgl_surat')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Tanggal Diterima -->
                                            <div class="col-md-6" id="div_tgl_diterima">
                                                <div class="form-group">
                                                    <label>Tanggal Diterima</label>
                                                    <input type="date" name="tgl_diterima" id="tgl_diterima"
                                                        class="form-control" value="{{ old('tgl_diterima') }}">
                                                    @error('tgl_diterima')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
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
                                                        placeholder="Masukkan pengirim atau tujuan surat"
                                                        value="{{ old('instansi', isset($surat) ? $surat->instansi : '') }}"
                                                        required value="{{ old('instansi') }}">
                                                    @error('instansi')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Perihal -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Perihal <span class="text-danger">*</span></label>
                                                    <input type="text" name="perihal" class="form-control"
                                                        placeholder="Masukkan perihal surat" required
                                                        value="{{ old('perihal') }}">
                                                    @error('perihal')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Lampiran -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lampiran</label>
                                                    <input type="text" name="lampiran" class="form-control"
                                                        placeholder="Contoh : 1 Berkas" value="{{ old('lampiran') }}">
                                                </div>
                                            </div>

                                            <!-- Upload File -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>File Surat <span class="text-danger">*</span></label>
                                                    <input type="file" name="file_surat" class="form-control"
                                                        value="{{ old('file_surat') }}" required accept=".pdf">
                                                    @error('file_surat')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" rows="2" class="form-control" placeholder="Keterangan tambahan">{{ old('keterangan') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-action text-center">
                                        <a href="{{ route('index.Surat') }}" class="btn btn-danger">
                                            <i class="fa fa-times"></i> Batal
                                        </a>

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-save"></i> Simpan
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
@endsection


@push('myscript')
    <script>
        $(document).ready(function() {
            function toggleJenisSurat() {
                let jenis = $('#jenis_surat').val();
                if (jenis === 'masuk') {
                    // Tampilkan field khusus surat masuk
                    $('#div_no_agenda').slideDown(200);
                    $('#div_tgl_diterima').slideDown(200);
                    $('#no_agenda').prop('disabled', false);
                    $('#tgl_diterima').prop('disabled', false);
                    // Ubah label
                    $('#label_instansi').html('Pengirim <span class="text-danger">*</span>');
                    // Ubah placeholder
                    $('#instansi').attr('placeholder', 'Masukkan nama pengirim');

                } else if (jenis === 'keluar') {
                    // Sembunyikan field khusus surat masuk
                    $('#div_no_agenda').slideUp(200);
                    $('#div_tgl_diterima').slideUp(200);
                    $('#no_agenda').prop('disabled', true).val('');
                    $('#tgl_diterima').prop('disabled', true).val('');
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

            // Jalankan saat halaman dibuka
            toggleJenisSurat();

            // Jalankan saat jenis surat berubah
            $('#jenis_surat').on('change', function() {
                toggleJenisSurat();
            });
        });
    </script>
@endpush
