@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.manajemen.sifatsurat.header')

            @include('dashboard.manajemen.sifatsurat.tabel')

        </div>
    </div>
@endsection
