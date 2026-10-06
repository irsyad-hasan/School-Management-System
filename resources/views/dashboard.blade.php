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

            {{-- Siswa --}}
            <div class="col-xl col-md-6 mb-4">
                <div class="dashboard-stat-card border-start border-4 border-primary">
                    <div class="stat-content">
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-person-vcard"></i>
                        </div>

                        <div>
                            <h3 class="stat-number">{{ $studentCount }}</h3>
                            <p class="stat-label">Siswa</p>
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
                            <p class="stat-label">Guru</p>
                        </div>
                    </div>

                    <a href="{{ route('teachers.index') }}" class="stat-link">
                        Data Guru
                        <i class="bi bi-arrow-right float-end"></i>
                    </a>
                </div>
            </div>

            {{-- Kelases --}}
            <div class="col-xl col-md-6 mb-4">
                <div class="dashboard-stat-card border-start border-4 border-warning">
                    <div class="stat-content">
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="bi bi-building"></i>
                        </div>

                        <div>
                            <h3 class="stat-number">{{ $classCount }}</h3>
                            <p class="stat-label">Kelas</p>
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
                            <p class="stat-label">Mapel</p>
                        </div>
                    </div>

                    <a href="{{ route('subjects.index') }}" class="stat-link">
                        Mata Pelajaran
                        <i class="bi bi-arrow-right float-end"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- Recent Siswa --}}
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

            <div class="card-body datatable-container">
                <table id="recentSiswaTable" class="table table-hover align-middle mb-0">
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
                <h3 class="card-title">Dashboard Guru</h3>
            </div>

            <div class="card-body">
                @php($teacherGreeting = session('teacher_greeting'))
                @if ($teacherGreeting)
                    <div class="alert alert-primary border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3"><i class="bi bi-hand-wave"></i></div>
                            <div>
                                <h5 class="mb-1">
                                    {{ $teacherGreeting['type'] === 'new' ? 'Selamat datang' : 'Selamat datang kembali' }}, {{ $teacherGreeting['name'] }}
                                </h5>
                                <p class="mb-0 text-body-secondary">Selamat bekerja dan semoga aktivitas mengajar hari ini berjalan lancar.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row g-3">
                    <div class="col-md-6"><div class="small-box text-bg-primary"><div class="inner"><h3>{{ $teacherStudentCount ?? 0 }}</h3><p>Jumlah Siswa yang Diampu</p></div><div class="small-box-icon"><i class="bi bi-people"></i></div><a href="{{ route('students.index') }}" class="small-box-footer">Lihat Data Siswa <i class="bi bi-arrow-right"></i></a></div></div>
                    <div class="col-md-6"><div class="small-box text-bg-success"><div class="inner"><h3>{{ $teacherScheduleCount ?? 0 }}</h3><p>Jumlah Jadwal Mengajar</p></div><div class="small-box-icon"><i class="bi bi-calendar-week"></i></div><a href="{{ route('schedules.index') }}" class="small-box-footer">Lihat Jadwal <i class="bi bi-arrow-right"></i></a></div></div>
                </div>
            </div>
        </div>
    @elseif (Auth::user()->role === 'student')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dashboard Siswa</h3>
            </div>

            <div class="card-body">
                <p>
                    Selamat datang di <strong>Rungsek</strong>.
                    Anda masuk sebagai <strong>Siswa</strong>.
                </p>

                @if ($student)
                    <hr>

                    <h5>Informasi Siswa Saya</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Nama Lengkap</th>
                                <td>{{ $student->full_name }}</td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td>{{ $student->nis }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $student->schoolClass->class_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>
                                    {{ $student->date_of_birth ? $student->date_of_birth->locale('id')->translatedFormat('j M Y') : '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @else
                    <hr>

                    <div class="alert alert-info mb-0">
                        Profil siswa Anda belum dibuat.
                        Silakan hubungi administrator.
                    </div>
                @endif
            </div>
        </div>

    @endif

@push('scripts')
<script>document.addEventListener('DOMContentLoaded', function () { const t = document.querySelector('#recentSiswaTable'); if (t) new DataTable(t, { paging: false, searching: false, info: false, ordering: false, language: { zeroRecords: 'Data tidak ditemukan' } }); });</script>
@endpush

@endsection
