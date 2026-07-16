@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Input Instansi</h3>
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
                        <a href="{{ route('index.Instansi') }}">Instansi</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Input Instansi</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            <div class="card shadow-sm">
                                <div class="card-body">

                                    <form action="{{ route('store.Instansi') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <!-- Kode Instansi -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kode Instansi</label>
                                                    <input type="text" name="kode_instansi"
                                                        class="form-control @error('kode_instansi') is-invalid @enderror"
                                                        value="{{ old('kode_instansi') }}" maxlength="30"
                                                        placeholder="Contoh : BKPSDM">

                                                    @error('kode_instansi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Jenis Instansi -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Instansi <span class="text-danger">*</span></label>

                                                    <select name="jenis_instansi"
                                                        class="form-control @error('jenis_instansi') is-invalid @enderror"
                                                        required>
                                                        <option value="">-- Pilih Jenis Instansi --</option>
                                                        @foreach (['Kementerian', 'Lembaga', 'Pemerintah Provinsi', 'Pemerintah Kabupaten/Kota', 'OPD', 'Kecamatan', 'Kelurahan', 'BUMN', 'BUMD', 'Swasta', 'Perguruan Tinggi', 'Organisasi', 'Lainnya'] as $jenis)
                                                            <option value="{{ $jenis }}"
                                                                {{ old('jenis_instansi') == $jenis ? 'selected' : '' }}>
                                                                {{ $jenis }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('jenis_instansi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Nama Instansi -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nama Instansi <span class="text-danger">*</span></label>
                                                    <input type="text" name="nama_instansi"
                                                        class="form-control @error('nama_instansi') is-invalid @enderror"
                                                        value="{{ old('nama_instansi') }}"
                                                        placeholder="Masukkan Nama Instansi" required>

                                                    @error('nama_instansi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Alamat -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                                                        placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>

                                                    @error('alamat')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Telepon -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor Telepon</label>
                                                    <input type="text" name="telepon"
                                                        class="form-control @error('telepon') is-invalid @enderror"
                                                        value="{{ old('telepon') }}" maxlength="30"
                                                        placeholder="08xxxxxxxxxx">

                                                    @error('telepon')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email') }}" placeholder="contoh@email.com">

                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="status"
                                                            name="status" value="1"
                                                            {{ old('status', 1) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="status">
                                                            Status Aktif
                                                        </label>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="text-center">
                                            <a href="{{ route('index.Instansi') }}" class="btn btn-danger">
                                                <i class="fas fa-times"></i>
                                                Batal
                                            </a>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i>
                                                Simpan
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
    </div>
@endsection
