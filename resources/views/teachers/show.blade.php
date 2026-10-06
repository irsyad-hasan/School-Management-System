@extends('layouts.admin')

@section('title', 'Detail Guru')

@section('page-title', 'Detail Guru')

@section('breadcrumb-parent')
    <a href="{{ route('teachers.index') }}">Guru</a>
@endsection

@section('breadcrumb', $teacher->full_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Guru
            </h3>
        </div>

        <div class="card-body">
            <div class="row">

                {{-- Nama Lengkap --}}
                <div class="col-md-6 mb-3">
                    <strong>Nama Lengkap</strong>
                    <p class="mb-0">
                        {{ $teacher->full_name }}
                    </p>
                </div>

                @if (auth()->user()->role === 'admin' || auth()->user()->teacher?->teacher_id === $teacher->teacher_id)
                {{-- NIP --}}
                <div class="col-md-6 mb-3">
                    <strong>NIP</strong>
                    <p class="mb-0">
                        {{ $teacher->nip }}
                    </p>
                </div>

                @endif

                {{-- Username --}}
                <div class="col-md-6 mb-3">
                    <strong>Username</strong>
                    <p class="mb-0">
                        {{ $teacher->user->username ?? '-' }}
                    </p>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <strong>Email</strong>
                    <p class="mb-0">
                        {{ $teacher->user->email ?? '-' }}
                    </p>
                </div>

                {{-- Subject --}}
                <div class="col-md-6 mb-3">
                    <strong>Mata Pelajaran</strong>
                    <p class="mb-0">
                        {{ $teacher->subject->subject_name ?? '-' }}
                    </p>
                </div>

                {{-- Berandaroom Kelas --}}
                <div class="col-md-6 mb-3">
                    <strong>Wali Kelas</strong>
                    <p class="mb-0">
                        @if ($teacher->homeroomClasses->isNotEmpty())
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($teacher->homeroomClasses as $class)
                                    <a href="{{ route('classes.show', $class) }}" class="badge text-bg-light border text-decoration-none">
                                        {{ $class->class_name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted">Bukan wali kelas</span>
                        @endif
                    </p>
                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Ubah Guru
                </a>
            @endif
        </div>
    </div>

@endsection
