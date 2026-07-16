@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.manajemen.instansi.header')

            @include('dashboard.manajemen.instansi.tabel')

        </div>
    </div>
@endsection
