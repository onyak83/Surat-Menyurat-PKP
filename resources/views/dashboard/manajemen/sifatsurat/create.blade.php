@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Input Sifat Surat</h3>
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
                        <a href="#">Input Sifat Surat</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <form action="{{ route('store.SifatSurat') }}" method="POST">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label>Nama Sifat Surat</label>
                                            <input type="text" name="nama_sifat" class="form-control"
                                                value="{{ old('nama_sifat') }}" required>
                                        </div>

                                        <div class="text-center mt-4">
                                            <a href="{{ route('index.SifatSurat') }}" class="btn btn-danger">
                                                Batal
                                            </a>

                                            <button type="submit" class="btn btn-success">
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
