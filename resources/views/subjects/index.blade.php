@extends('layouts.admin')

@section('title', 'Mata Pelajaran')

@section('page-title', 'Mata Pelajaran')

@section('breadcrumb', 'Mata Pelajaran')

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                Daftar Mata Pelajaran
            </h3>

            <div class="card-tools">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Mata Pelajaran
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body datatable-container">
            <table id="subjectsTable" class="display table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Kode</th>
                        <th class="text-end">Jam Pelajaran (JP)</th>
                        <th style="width: 180px;" class="text-end">
                            Detail (Detail)
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($subjects as $subject)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $subject->subject_name }}
                            </td>

                            <td>
                                {{ $subject->subject_code }}
                            </td>

                            <td class="text-end">
                                {{ number_format($subject->jp, 0, ',', '.') }}
                            </td>

                            <td class="text-end">

                                <a href="{{ route('subjects.show', $subject) }}" class="btn btn-info btn-sm"
                                    title="Lihat Mata Pelajaran">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning btn-sm"
                                        title="Ubah Mata Pelajaran">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan mata pelajaran ini?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm"
                                            title="Arsipkan Mata Pelajaran">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Belum ada data mata pelajaran.
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
            initDataTable('#subjectsTable');
        });
    </script>
@endpush
