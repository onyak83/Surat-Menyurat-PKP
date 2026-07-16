@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Arsip Digital Surat</h3>

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
                        <a href="#">Arsip Digital Surat</a>
                    </li>
                </ul>
            </div>

            @include('dashboard.laporan.arsipsuratdigital.tabel')

        </div>
    </div>
@endsection
