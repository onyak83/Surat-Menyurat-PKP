@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.manajemen.user.header')

            @include('dashboard.manajemen.user.tabel')

        </div>
    </div>
@endsection
