@extends('layouts.admin')

@section('title', 'Siswa')
@section('page-title', 'Siswa')
@section('breadcrumb', 'Siswa')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Siswa</h3>

            <div class="card-tools">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Siswa
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body datatable-container">
            <table id="studentsTable" class="display table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Lengkap</th>
                        <th class="text-end">NIS</th>
                        <th>Kelas</th>
                        <th>Tanggal Lahir</th>
                        <th class="text-end">Detail</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>{{ $student->full_name }}</td>

                            <td class="text-end">{{ $student->nis }}</td>

                            <td>{{ $student->schoolClass->class_name ?? '-' }}</td>

                            <td>{{ $student->date_of_birth->locale('id')->translatedFormat('j M Y') }}</td>

                            <td class="text-end">
                                <a href="{{ route('students.show', $student) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan siswa ini?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initDataTable('#studentsTable');
        });
    </script>
@endpush
