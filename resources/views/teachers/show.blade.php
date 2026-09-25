@extends('layouts.admin')

@section('title', 'Detail Guru (Teacher Details)')

@section('page-title', 'Detail Guru (Teacher Details)')

@section('breadcrumb-parent')
    <a href="{{ route('teachers.index') }}">Guru (Teachers)</a>
@endsection

@section('breadcrumb', $teacher->full_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Guru (Teacher Information)
            </h3>
        </div>

        <div class="card-body">
            <div class="row">

                {{-- Full Name --}}
                <div class="col-md-6 mb-3">
                    <strong>Nama Lengkap (Full Name)</strong>
                    <p class="mb-0">
                        {{ $teacher->full_name }}
                    </p>
                </div>

                {{-- NIP --}}
                <div class="col-md-6 mb-3">
                    <strong>NIP</strong>
                    <p class="mb-0">
                        {{ $teacher->nip }}
                    </p>
                </div>

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
                    <strong>Mata Pelajaran (Subject)</strong>
                    <p class="mb-0">
                        {{ $teacher->subject->subject_name ?? '-' }}
                    </p>
                </div>

                {{-- Homeroom Class --}}
                <div class="col-md-6 mb-3">
                    <strong>Wali Kelas (Homeroom Class)</strong>
                    <p class="mb-0">
                        {{ $teacher->homeroomClass->class_name ?? '-' }}
                    </p>
                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali (Back)
            </a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Guru (Edit Teacher)
                </a>
            @endif
        </div>
    </div>

@endsection
