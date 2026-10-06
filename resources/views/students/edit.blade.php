@extends('layouts.admin')

@section('title', 'Ubah Siswa')

@section('page-title', 'Ubah Siswa')

@section('breadcrumb-parent')
    <a href="{{ route('students.index') }}">Siswa</a>
@endsection

@section('breadcrumb', $student->full_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ubah Informasi Siswa (Ubah Siswa Information)</h3>
        </div>

        <form action="{{ route('students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name" class="form-control"
                            value="{{ old('full_name', $student->full_name) }}" placeholder="Enter full name" autofocus
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nis" class="form-label">
                            NIS <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nis" id="nis" class="form-control"
                            value="{{ old('nis', $student->nis) }}" placeholder="Enter student NIS" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="class_id" class="form-label">
                            Kelas <span class="text-danger">*</span>
                        </label>

                        <select name="class_id" id="class_id" class="form-select" required>
                            <option value="">-- Select Kelas --</option>

                            @foreach ($classes as $class)
                                <option value="{{ $class->class_id }}"
                                    {{ old('class_id', $student->class_id) == $class->class_id ? 'selected' : '' }}>
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
                            value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}" required>
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
                            value="{{ old('username', $student->user->username) }}" placeholder="Enter username" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $student->user->email) }}" placeholder="Enter email address" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            Kata Sandi Baru (New Password)
                        </label>

                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Kosongkan jika tidak ingin mengubah kata sandi">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Kata Sandi Baru (Confirm New Password)
                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Masukkan kembali kata sandi baru">
                    </div>
                </div>

                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Kosongkan kolom kata sandi jika tidak ingin mengubah kata sandi.
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Perbarui Siswa
                </button>
            </div>
        </form>
    </div>

@endsection
