@extends('layouts.admin')
@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal')
@section('breadcrumb', 'Tambah Jadwal')
@section('content')
<div class="card shadow-sm"><div class="card-body"><form method="POST" action="{{ route('schedules.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Kelas</label><select name="class_id" class="form-select" required>@foreach($classes as $class)<option value="{{ $class->class_id }}" @selected(old('class_id',$schedule->class_id)==$class->class_id)>{{ $class->class_name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Guru</label><select name="teacher_id" class="form-select" required>@foreach($teachers as $teacher)<option value="{{ $teacher->teacher_id }}" @selected(old('teacher_id',$schedule->teacher_id)==$teacher->teacher_id)>{{ $teacher->full_name }}{{ $teacher->subject ? ' - '.$teacher->subject->subject_name : '' }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Mata Pelajaran</label><select name="subject_id" class="form-select" required>@foreach($subjects as $subject)<option value="{{ $subject->subject_id }}" @selected(old('subject_id',$schedule->subject_id)==$subject->subject_id)>{{ $subject->subject_name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Hari</label><select name="day" class="form-select" required>@foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)<option value="{{ $day }}" @selected(old('day',$schedule->day)==$day)>{{ $day }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Jam Mulai</label><input type="time" name="start_time" class="form-control" value="{{ old('start_time',$schedule->start_time) }}" required></div>
<div class="col-md-4"><label class="form-label">Jam Selesai</label><input type="time" name="end_time" class="form-control" value="{{ old('end_time',$schedule->end_time) }}" required></div>
<div class="col-md-4"><label class="form-label">JP</label><input type="number" name="jp" min="1" max="12" class="form-control" value="{{ old('jp',$schedule->jp ?? 1) }}" required></div>
</div><div class="mt-4"><a href="{{ route('schedules.index') }}" class="btn btn-secondary">Kembali</a><button class="btn btn-primary">Simpan</button></div>
</form></div></div>@endsection
