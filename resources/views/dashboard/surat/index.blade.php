@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.surat.header')

            @include('dashboard.surat.tabel')

        </div>
    </div>
@endsection
