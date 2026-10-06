@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('page-title', 'Tambah Siswa')

@section('breadcrumb-parent')
    <a href="{{ route('students.index') }}">Siswa</a>
@endsection

@section('breadcrumb', 'Tambah Siswa')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Siswa</h3>
        </div>

        <form action="{{ route('students.store') }}" method="POST">
            @csrf

            <div class="card-body">

                <h5 class="mb-3">Informasi Siswa</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name" class="form-control"
                            value="{{ old('full_name') }}" placeholder="Masukkan nama lengkap" autofocus required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nis" class="form-label">
                            NIS <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis') }}"
                            placeholder="Masukkan NIS siswa" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="class_id" class="form-label">
                            Kelas <span class="text-danger">*</span>
                        </label>
                        <select name="class_id" id="class_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>

                            @foreach ($classes as $class)
                                <option value="{{ $class->class_id }}"
                                    {{ old('class_id') == $class->class_id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth" class="form-label">
                            Tanggal Lahir (Tanggal Lahir) <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                            value="{{ old('date_of_birth') }}" required>
                    </div>
                </div>

                <hr>

                <h5 class="mb-3">Akun Login</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">
                            Username <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="username" id="username" class="form-control"
                            value="{{ old('username') }}" placeholder="Masukkan username" autocomplete="username" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                            placeholder="Masukkan alamat email" autocomplete="email" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            Kata Sandi (Password) <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan kata sandi" autocomplete="new-password" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Kata Sandi (Confirm Password) <span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Konfirmasi kata sandi" autocomplete="new-password" required>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Simpan Siswa
                </button>
            </div>
        </form>
    </div>

@endsection
