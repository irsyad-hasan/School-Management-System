@extends('layouts.admin')

@section('title', 'Detail Siswa (Student Details)')
@section('page-title', 'Detail Siswa (Student Details)')
@section('breadcrumb-parent')
    <a href="{{ route('students.index') }}">Students</a>
@endsection

@section('breadcrumb', $student->full_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Siswa (Student Information)</h3>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Nama Lengkap (Full Name)</strong>
                    <div class="mt-1">
                        {{ $student->full_name }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>NIS</strong>
                    <div class="mt-1">
                        {{ $student->nis }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Kelas (Class)</strong>
                    <div class="mt-1">
                        {{ $student->schoolClass->class_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Tanggal Lahir (Date of Birth)</strong>
                    <div class="mt-1">
                        {{ $student->date_of_birth->locale('id')->translatedFormat('j M Y') }}
                    </div>
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Akun Login (Login Account)</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Username</strong>
                    <div class="mt-1">
                        {{ $student->user->username }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Email</strong>
                    <div class="mt-1">
                        {{ $student->user->email }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali (Back)
            </a>

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i>
                    Edit Siswa (Edit Student)
                </a>
            @endif
        </div>
    </div>

@endsection
