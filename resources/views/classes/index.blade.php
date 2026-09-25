@extends('layouts.admin')

@section('title', 'Kelas (Classes)')

@section('page-title', 'Kelas (Classes)')

@section('breadcrumb', 'Kelas (Classes)')

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                Daftar Kelas (Class List)
            </h3>

            <div class="card-tools">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Kelas
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Kelas (Class Name)</th>
                        <th>Wali Kelas (Homeroom Teacher)</th>
                        <th>Tahun Ajaran (Academic Year)</th>
                        <th style="width: 180px;" class="text-end">
                            Aksi (Actions)
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($classes as $class)
                        <tr>
                            <td>
                                {{ $classes->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $class->class_name }}
                            </td>

                            <td>
                                {{ $class->homeroomTeacher->full_name ?? '-' }}
                            </td>

                            <td>
                                {{ $class->academic_year }}
                            </td>

                            <td class="text-end">

                                <a href="{{ route('classes.show', $class) }}" class="btn btn-info btn-sm"
                                    title="Lihat Kelas">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning btn-sm"
                                        title="Edit Kelas">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan kelas ini?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm" title="Arsipkan Kelas">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Belum ada data kelas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($classes->hasPages())
            <div class="card-footer">
                {{ $classes->links() }}
            </div>
        @endif

    </div>

@endsection
