@extends('layouts.admin')

@section('title', 'Guru (Teachers)')

@section('page-title', 'Guru (Teachers)')

@section('breadcrumb', 'Guru (Teachers)')

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Daftar Guru (Teacher List)</h3>

            <div class="card-tools">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Guru
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Lengkap (Full Name)</th>
                        <th class="text-end">NIP</th>
                        <th>Mata Pelajaran (Subject)</th>
                        <th style="width: 180px;" class="text-end">
                            Aksi (Actions)
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr>
                            <td>
                                {{ $teachers->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $teacher->full_name }}
                            </td>

                            <td class="text-end">
                                {{ $teacher->nip }}
                            </td>

                            <td>
                                {{ $teacher->subject->subject_name ?? '-' }}
                            </td>

                            <td class="text-end">
                                <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-info btn-sm"
                                    title="Lihat Guru">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning btn-sm"
                                        title="Edit Guru">
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
                            <td colspan="5" class="text-center py-4">
                                Belum ada data guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($teachers->hasPages())
            <div class="card-footer">
                {{ $teachers->links() }}
            </div>
        @endif

    </div>

@endsection
