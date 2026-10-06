@extends('layouts.admin')

@section('title', 'Guru')

@section('page-title', 'Guru')

@section('breadcrumb', 'Guru')

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Daftar Guru</h3>

            <div class="card-tools">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Guru
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body datatable-container">
            <table id="teachersTable" class="display table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Lengkap</th>
                        @if (auth()->user()->role === 'admin')
                            <th class="text-end">NIP</th>
                        @endif
                        <th>Mata Pelajaran</th>
                        <th>Wali Kelas</th>
                        <th style="width: 180px;" class="text-end">
                            Detail
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $teacher->full_name }}
                            </td>

                            @if (auth()->user()->role === 'admin')
                                <td class="text-end">{{ $teacher->nip }}</td>
                            @endif

                            <td>
                                {{ $teacher->subject->subject_name ?? '-' }}
                            </td>

                            <td>
                                @if ($teacher->homeroomClasses->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($teacher->homeroomClasses as $class)
                                            <span class="badge text-bg-light border">{{ $class->class_name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">Bukan wali kelas</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-info btn-sm"
                                    title="Detail Guru">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning btn-sm"
                                        title="Ubah Guru">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan guru ini?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm" title="Arsipkan Guru">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Belum ada data guru.
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
            initDataTable('#teachersTable');
        });
    </script>
@endpush
