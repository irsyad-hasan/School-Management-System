@extends('layouts.admin')

@section('title', 'Detail Mata Pelajaran (Subject Details)')

@section('page-title', 'Detail Mata Pelajaran (Subject Details)')

@section('breadcrumb-parent')
    <a href="{{ route('subjects.index') }}">Mata Pelajaran (Subjects)</a>
@endsection

@section('breadcrumb', $subject->subject_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Mata Pelajaran (Subject Information)
            </h3>
        </div>

        <div class="card-body">
            <div class="row">

                {{-- Subject Name --}}
                <div class="col-md-6 mb-3">
                    <strong>Nama Mata Pelajaran (Subject Name)</strong>
                    <p class="mb-0">
                        {{ $subject->subject_name }}
                    </p>
                </div>

                {{-- Subject Code --}}
                <div class="col-md-6 mb-3">
                    <strong>Kode Mata Pelajaran (Subject Code)</strong>
                    <p class="mb-0">
                        {{ $subject->subject_code }}
                    </p>
                </div>

                {{-- Credits --}}
                <div class="col-md-6 mb-3">
                    <strong>SKS (Credits)</strong>
                    <p class="mb-0">
                        {{ number_format($subject->credits, 0, ',', '.') }}
                    </p>
                </div>

            </div>
        </div>

        <div class="card-footer">

            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali (Back)
            </a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Mata Pelajaran (Edit Subject)
                </a>
            @endif

        </div>
    </div>

@endsection
