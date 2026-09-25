@extends('layouts.admin')

@section('title', 'Edit Guru (Edit Teacher)')

@section('page-title', 'Edit Guru (Edit Teacher)')

@section('breadcrumb-parent')
    <a href="{{ route('teachers.index') }}">Guru (Teachers)</a>
@endsection

@section('breadcrumb', $teacher->full_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Informasi Guru (Edit Teacher Information)</h3>
        </div>

        <form action="{{ route('teachers.update', $teacher) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Account Information --}}
                <h5 class="mb-3">Informasi Akun (Account Information)</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">
                            Username <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="username" id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $teacher->user->username) }}" placeholder="Masukkan username"
                            autocomplete="username" required autofocus>

                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $teacher->user->email) }}" placeholder="Masukkan alamat email"
                            autocomplete="email" required>

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            Kata Sandi Baru (New Password)
                        </label>

                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Kosongkan jika tidak ingin mengubah kata sandi" autocomplete="new-password">

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Kata Sandi Baru (Confirm New Password)
                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Masukkan kembali kata sandi baru" autocomplete="new-password">
                    </div>
                </div>

                <hr>

                {{-- Teacher Information --}}
                <h5 class="mb-3">Informasi Guru (Teacher Information)</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">
                            Nama Lengkap (Full Name) <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="full_name" id="full_name"
                            class="form-control @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name', $teacher->full_name) }}" placeholder="Masukkan nama lengkap"
                            required>

                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nip" class="form-label">
                            NIP <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nip" id="nip"
                            class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $teacher->nip) }}"
                            placeholder="Masukkan NIP" required>

                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="subject_id" class="form-label">
                            Mata Pelajaran (Subject) <span class="text-danger">*</span>
                        </label>

                        <select name="subject_id" id="subject_id"
                            class="form-select @error('subject_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>

                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->subject_id }}" @selected(old('subject_id', $teacher->subject_id) == $subject->subject_id)>
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Kosongkan kolom kata sandi jika tidak ingin mengubah kata sandi.
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali (Back)
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Perbarui Guru (Update Teacher)
                </button>
            </div>
        </form>
    </div>

@endsection
