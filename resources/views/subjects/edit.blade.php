@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran (Edit Subject)')

@section('page-title', 'Edit Mata Pelajaran (Edit Subject)')

@section('breadcrumb-parent')
    <a href="{{ route('subjects.index') }}">Mata Pelajaran (Subjects)</a>
@endsection

@section('breadcrumb', $subject->subject_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Mata Pelajaran (Subject Information)
            </h3>
        </div>

        <form action="{{ route('subjects.update', $subject) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Subject Name --}}
                <div class="mb-3">
                    <label for="subject_name" class="form-label">
                        Nama Mata Pelajaran (Subject Name)
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="subject_name" id="subject_name"
                        class="form-control @error('subject_name') is-invalid @enderror"
                        value="{{ old('subject_name', $subject->subject_name) }}" placeholder="Masukkan nama mata pelajaran"
                        autofocus required>

                    @error('subject_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Subject Code --}}
                <div class="mb-3">
                    <label for="subject_code" class="form-label">
                        Kode Mata Pelajaran (Subject Code)
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="subject_code" id="subject_code"
                        class="form-control @error('subject_code') is-invalid @enderror"
                        value="{{ old('subject_code', $subject->subject_code) }}" placeholder="Contoh: MAT" required>

                    @error('subject_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Credits --}}
                <div class="mb-3">
                    <label for="credits" class="form-label">
                        SKS (Credits)
                        <span class="text-danger">*</span>
                    </label>

                    <input type="number" name="credits" id="credits"
                        class="form-control @error('credits') is-invalid @enderror"
                        value="{{ old('credits', $subject->credits) }}" placeholder="Masukkan jumlah SKS" min="1"
                        max="20" required>

                    @error('credits')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali (Back)
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Perbarui Mata Pelajaran (Update Subject)
                </button>
            </div>
        </form>
    </div>

@endsection
