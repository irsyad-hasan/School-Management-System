@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Ringkasan Sistem')

@section('breadcrumb', 'Dashboard')

@section('content')

    @if (Auth::user()->role === 'admin')
        {{-- Statistics --}}
        <div class="row">

            {{-- Users --}}
            <div class="col-xl col-md-6 mb-4">
                <div class="dashboard-stat-card border-start border-4 border-info">
                    <div class="stat-content">
                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>
                            <h3 class="stat-number">{{ $userCount }}</h3>
                            <p class="stat-label">Pengguna (User)</p>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="stat-link">
                        Profil
                        <i class="bi bi-arrow-right float-end"></i>
                    </a>
                </div>
            </div>

            {{-- Students --}}
            <div class="col-xl col-md-6 mb-4">
                <div class="dashboard-stat-card border-start border-4 border-primary">
                    <div class="stat-content">
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-person-vcard"></i>
                        </div>

                        <div>
                            <h3 class="stat-number">{{ $studentCount }}</h3>
                            <p class="stat-label">Siswa (Students)</p>
                        </div>
                    </div>

                    <a href="{{ route('students.index') }}" class="stat-link">
                        Data Siswa
                        <i class="bi bi-arrow-right float-end"></i>
                    </a>
                </div>
            </div>

            {{-- Teachers --}}
            <div class="col-xl col-md-6 mb-4">
                <div class="dashboard-stat-card border-start border-4 border-success">
                    <div class="stat-content">
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-person-workspace"></i>
                        </div>

                        <div>
                            <h3 class="stat-number">{{ $teacherCount }}</h3>
                            <p class="stat-label">Guru (Teachers)</p>
                        </div>
                    </div>

                    <a href="{{ route('teachers.index') }}" class="stat-link">
                        Data Guru
                        <i class="bi bi-arrow-right float-end"></i>
                    </a>
                </div>
            </div>

            {{-- Classes --}}
            <div class="col-xl col-md-6 mb-4">
                <div class="dashboard-stat-card border-start border-4 border-warning">
                    <div class="stat-content">
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="bi bi-building"></i>
                        </div>

                        <div>
                            <h3 class="stat-number">{{ $classCount }}</h3>
                            <p class="stat-label">Kelas (Classes)</p>
                        </div>
                    </div>

                    <a href="{{ route('classes.index') }}" class="stat-link">
                        Data Kelas
                        <i class="bi bi-arrow-right float-end"></i>
                    </a>
                </div>
            </div>

            {{-- Subjects --}}
            <div class="col-xl col-md-6 mb-4">
                <div class="dashboard-stat-card border-start border-4 border-danger">
                    <div class="stat-content">
                        <div class="stat-icon bg-danger-subtle text-danger">
                            <i class="bi bi-book"></i>
                        </div>

                        <div>
                            <h3 class="stat-number">{{ $subjectCount }}</h3>
                            <p class="stat-label">Mapel (Subjects)</p>
                        </div>
                    </div>

                    <a href="{{ route('subjects.index') }}" class="stat-link">
                        Mata Pelajaran
                        <i class="bi bi-arrow-right float-end"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- Recent Students --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    Data Siswa Terbaru
                </h3>

                <div class="card-tools">
                    <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($recentStudents as $student)
                            <tr>
                                <td>
                                    STD-{{ str_pad($student->student_id, 3, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>{{ $student->full_name }}</td>

                                <td>
                                    {{ $student->schoolClass->class_name ?? '-' }}
                                </td>

                                <td>
                                    @if ($student->archived)
                                        <span class="badge text-bg-secondary">
                                            Diarsipkan
                                        </span>
                                    @else
                                        <span class="badge text-bg-success">
                                            Aktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @elseif (Auth::user()->role === 'teacher')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Welcome, Teacher</h3>
            </div>

            <div class="card-body">
                Welcome to the <strong>School Management System</strong>.
                You are logged in as a <strong>Teacher</strong>.
            </div>
        </div>
    @elseif (Auth::user()->role === 'student')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Welcome, Student</h3>
            </div>

            <div class="card-body">
                <p>
                    Welcome to the <strong>School Management System</strong>.
                    You are logged in as a <strong>Student</strong>.
                </p>

                @if ($student)
                    <hr>

                    <h5>My Student Information</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Full Name</th>
                                <td>{{ $student->full_name }}</td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td>{{ $student->nis }}</td>
                            </tr>
                            <tr>
                                <th>Class</th>
                                <td>{{ $student->schoolClass->class_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>
                                    {{ $student->date_of_birth ? $student->date_of_birth->locale('id')->translatedFormat('j M Y') : '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @else
                    <hr>

                    <div class="alert alert-info mb-0">
                        Your student profile has not been created yet.
                        Please contact the administrator.
                    </div>
                @endif
            </div>
        </div>

    @endif

@endsection
