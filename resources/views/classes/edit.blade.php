@extends('layouts.admin')

@section('title', 'Edit Kelas (Edit Class)')

@section('page-title', 'Edit Kelas (Edit Class)')

@section('breadcrumb-parent')
    <a href="{{ route('classes.index') }}">Kelas (Classes)</a>
@endsection

@section('breadcrumb', $class->class_name)

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Informasi Kelas (Class Information)
            </h3>
        </div>

        <form action="{{ route('classes.update', $class) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Class Name --}}
                <div class="mb-3">
                    <label for="class_name" class="form-label">
                        Nama Kelas (Class Name)
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="class_name" id="class_name"
                        class="form-control @error('class_name') is-invalid @enderror"
                        value="{{ old('class_name', $class->class_name) }}" placeholder="Masukkan nama kelas" autofocus
                        required>

                    @error('class_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Homeroom Teacher --}}
                <div class="mb-3">
                    <label for="homeroom_teacher_id" class="form-label">
                        Wali Kelas (Homeroom Teacher)
                    </label>

                    <select name="homeroom_teacher_id" id="homeroom_teacher_id"
                        class="form-select @error('homeroom_teacher_id') is-invalid @enderror">

                        <option value="">
                            -- Pilih Wali Kelas --
                        </option>

                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->teacher_id }}" @selected(old('homeroom_teacher_id', $class->homeroom_teacher_id) == $teacher->teacher_id)>
                                {{ $teacher->full_name }}
                                - {{ $teacher->subject->subject_name ?? 'Tanpa Mata Pelajaran' }}
                            </option>
                        @endforeach

                    </select>

                    @error('homeroom_teacher_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Academic Year --}}
                <div class="mb-3">
                    <label for="academic_year" class="form-label">
                        Tahun Ajaran (Academic Year)
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="academic_year" id="academic_year"
                        class="form-control @error('academic_year') is-invalid @enderror"
                        value="{{ old('academic_year', $class->academic_year) }}" placeholder="Contoh: 2026/2027" required>

                    @error('academic_year')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali (Back)
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Perbarui Kelas (Update Class)
                </button>
            </div>
        </form>
    </div>

@endsection
