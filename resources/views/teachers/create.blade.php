@extends('layouts.admin')

@section('title', 'Tambah Guru (Add Teacher)')

@section('page-title', 'Tambah Guru (Add Teacher)')

@section('breadcrumb-parent')
    <a href="{{ route('teachers.index') }}">Guru (Teachers)</a>
@endsection

@section('breadcrumb', 'Tambah Guru (Add Teacher)')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Guru (Teacher Information)</h3>
        </div>

        <form action="{{ route('teachers.store') }}" method="POST">
            @csrf

            <div class="card-body">

                {{-- Account Information --}}
                <h5 class="mb-3">Informasi Akun (Account Information)</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">
                            Username <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="username" id="username"
                            class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}"
                            placeholder="Masukkan username" autocomplete="username" required autofocus>

                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="Masukkan alamat email" autocomplete="email" required>

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            Kata Sandi (Password) <span class="text-danger">*</span>
                        </label>

                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi"
                            autocomplete="new-password" required>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Kata Sandi (Confirm Password) <span class="text-danger">*</span>
                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Konfirmasi kata sandi" autocomplete="new-password" required>
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
                            class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}"
                            placeholder="Masukkan nama lengkap" required>

                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nip" class="form-label">
                            NIP <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nip" id="nip"
                            class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}"
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
                                <option value="{{ $subject->subject_id }}" @selected(old('subject_id') == $subject->subject_id)>
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali (Back)
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Guru (Save Teacher)
                </button>
            </div>
        </form>
    </div>

@endsection
