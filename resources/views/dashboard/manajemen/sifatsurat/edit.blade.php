@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Edit Sifat Surat</h3>
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
                        <a href="{{ route('index.SifatSurat') }}">Sifat Surat</a>
                    </li>

                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>

                    <li class="nav-item">
                        <a href="#">Edit Sifat Surat</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            + <div class="card shadow-sm">
                                <div class="card-body">
                                    <form action="{{ route('update.SifatSurat', $editSifatsurat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group mb-3">
                                            <label>Nama Sifat Surat<span class="text-danger">*</span></label>

                                            <input type="text" name="nama_sifat"
                                                class="form-control @error('nama_sifat') is-invalid @enderror"
                                                value="{{ old('nama_sifat', $editSifatsurat->nama_sifat) }}"
                                                placeholder="Masukkan Nama Sifat Surat" required>

                                            @error('nama_sifat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="text-center mt-4">

                                            <a href="{{ route('index.SifatSurat') }}" class="btn btn-danger">
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
    </div>
@endsection
