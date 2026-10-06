@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran (Add Mata Pelajaran)')

@section('page-title', 'Tambah Mata Pelajaran (Add Mata Pelajaran)')

@section('breadcrumb-parent')
    <a href="{{ route('subjects.index') }}">Mata Pelajaran</a>
@endsection

@section('breadcrumb', 'Tambah Mata Pelajaran (Add Mata Pelajaran)')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Mata Pelajaran
            </h3>
        </div>

        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf

            <div class="card-body">

                {{-- Mata Pelajaran Name --}}
                <div class="mb-3">
                    <label for="subject_name" class="form-label">
                        Nama Mata Pelajaran
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="subject_name" id="subject_name"
                        class="form-control @error('subject_name') is-invalid @enderror" value="{{ old('subject_name') }}"
                        placeholder="Masukkan nama mata pelajaran" autofocus required>

                    @error('subject_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Mata Pelajaran Code --}}
                <div class="mb-3">
                    <label for="subject_code" class="form-label">
                        Kode Mata Pelajaran
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="subject_code" id="subject_code"
                        class="form-control @error('subject_code') is-invalid @enderror" value="{{ old('subject_code') }}"
                        placeholder="Contoh: MAT" required>

                    @error('subject_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- JP --}}
                <div class="mb-3">
                    <label for="jp" class="form-label">
                        Jam Pelajaran (JP)
                        <span class="text-danger">*</span>
                    </label>

                    <input type="number" name="jp" id="jp"
                        class="form-control @error('jp') is-invalid @enderror" value="{{ old('jp') }}"
                        placeholder="Masukkan jumlah JP" min="1" max="20" required>

                    @error('jp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Mata Pelajaran (Save Mata Pelajaran)
                </button>
            </div>
        </form>
    </div>

@endsection
