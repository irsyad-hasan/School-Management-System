@extends('layouts.admin')

@section('title', 'Detail Mata Pelajaran')

@section('page-title', 'Detail Mata Pelajaran')

@section('breadcrumb-parent')
    <a href="{{ route('subjects.index') }}">Mata Pelajaran</a>
@endsection

@section('breadcrumb', $subject->subject_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Mata Pelajaran
            </h3>
        </div>

        <div class="card-body">
            <div class="row">

                {{-- Mata Pelajaran Name --}}
                <div class="col-md-6 mb-3">
                    <strong>Nama Mata Pelajaran</strong>
                    <p class="mb-0">
                        {{ $subject->subject_name }}
                    </p>
                </div>

                {{-- Mata Pelajaran Code --}}
                <div class="col-md-6 mb-3">
                    <strong>Kode Mata Pelajaran</strong>
                    <p class="mb-0">
                        {{ $subject->subject_code }}
                    </p>
                </div>

                {{-- JP --}}
                <div class="col-md-6 mb-3">
                    <strong>Jam Pelajaran (JP)</strong>
                    <p class="mb-0">
                        {{ number_format($subject->jp, 0, ',', '.') }}
                    </p>
                </div>

            </div>
        </div>

        <div class="card-footer">

            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Ubah Mata Pelajaran (Ubah Mata Pelajaran)
                </a>
            @endif

        </div>
    </div>

@endsection
