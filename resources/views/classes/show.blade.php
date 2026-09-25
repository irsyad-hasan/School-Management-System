@extends('layouts.admin')

@section('title', 'Detail Kelas (Class Details)')

@section('page-title', 'Detail Kelas (Class Details)')

@section('breadcrumb-parent')
    <a href="{{ route('classes.index') }}">Kelas (Classes)</a>
@endsection

@section('breadcrumb', $class->class_name)

@section('content')

    {{-- Class Information --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Kelas (Class Information)
            </h3>
        </div>

        <div class="card-body">
            <div class="row">

                {{-- Class Name --}}
                <div class="col-md-6 mb-3">
                    <strong>Nama Kelas (Class Name)</strong>
                    <p class="mb-0">
                        {{ $class->class_name }}
                    </p>
                </div>

                {{-- Academic Year --}}
                <div class="col-md-6 mb-3">
                    <strong>Tahun Ajaran (Academic Year)</strong>
                    <p class="mb-0">
                        {{ $class->academic_year }}
                    </p>
                </div>

                {{-- Homeroom Teacher --}}
                <div class="col-md-6 mb-3">
                    <strong>Wali Kelas (Homeroom Teacher)</strong>
                    <p class="mb-0">
                        {{ $class->homeroomTeacher->full_name ?? '-' }}
                    </p>
                </div>

                {{-- Subject --}}
                <div class="col-md-6 mb-3">
                    <strong>Mata Pelajaran (Subject)</strong>
                    <p class="mb-0">
                        {{ $class->homeroomTeacher->subject->subject_name ?? '-' }}
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- Student List --}}
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                Siswa di Kelas Ini (Students in This Class)
            </h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Lengkap (Full Name)</th>
                        <th class="text-end">NIS</th>
                        <th>Tanggal Lahir (Date of Birth)</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($class->students as $student)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $student->full_name }}
                            </td>

                            <td class="text-end">
                                {{ $student->nis }}
                            </td>

                            <td>
                                {{ $student->date_of_birth
                                    ? \Carbon\Carbon::parse($student->date_of_birth)->locale('id')->translatedFormat('j M Y')
                                    : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                Belum ada siswa di kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="card-footer">

            <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali (Back)
            </a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Kelas (Edit Class)
                </a>
            @endif

        </div>

    </div>

@endsection
