@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Edit User</h3>
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
                        <a href="{{ route('index.User') }}">Semua User</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit User</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-10">
                            <div class="card">

                                <form action="{{ route('update.User', $editUser->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">

                                        <div class="row">

                                            <!-- Nama -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ old('name', $editUser->name) }}" required>

                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email', $editUser->email) }}" required>

                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Password Baru</label>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Kosongkan jika tidak ingin mengubah password">

                                                    <small class="text-muted">
                                                        Biarkan kosong jika password tidak ingin diubah.
                                                    </small>

                                                    @error('password')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Role -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Role <span class="text-danger">*</span></label>

                                                    <select name="role_id" class="form-select" required>

                                                        <option value="">-- Pilih Role --</option>

                                                        @foreach ($role as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('role_id', $editUser->role_id) == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name_role }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                    @error('role_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="card-action text-center">

                                        <a href="{{ route('index.User') }}" class="btn btn-danger">
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
@endsection
