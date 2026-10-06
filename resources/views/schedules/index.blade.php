@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')
@section('breadcrumb', 'Jadwal Pelajaran')

@section('content')
<div class="card shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title mb-0">Daftar Jadwal Pelajaran</h3>
    @if(auth()->user()->role === 'admin')<a href="{{ route('schedules.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Jadwal</a>@endif
  </div>
  <div class="card-body datatable-container">
    <table id="schedulesTable" class="table table-hover align-middle">
      <thead><tr><th>No.</th><th>Hari</th><th>Jam</th><th>Kelas</th><th>Mata Pelajaran</th><th>Guru</th><th>JP</th><th>Detail</th></tr></thead>
      <tbody>@forelse($schedules as $schedule)<tr>
        <td>{{ $loop->iteration }}</td><td>{{ $schedule->day }}</td>
        <td>{{ substr($schedule->start_time,0,5) }} - {{ substr($schedule->end_time,0,5) }}</td>
        <td>{{ $schedule->schoolClass->class_name ?? '-' }}</td><td>{{ $schedule->subject->subject_name ?? '-' }}</td><td>{{ $schedule->teacher->full_name ?? '-' }}</td><td>{{ $schedule->jp }}</td>
        <td class="text-nowrap"><a class="btn btn-info btn-sm" href="{{ route('schedules.show',$schedule) }}" title="Detail Jadwal"><i class="bi bi-eye"></i></a>
        @if(auth()->user()->role === 'admin')<a class="btn btn-warning btn-sm" href="{{ route('schedules.edit',$schedule) }}" title="Ubah Jadwal"><i class="bi bi-pencil"></i></a>
        <form class="d-inline" method="POST" action="{{ route('schedules.destroy',$schedule) }}" onsubmit="return confirm('Arsipkan jadwal ini?')">@csrf @method('DELETE')<button class="btn btn-danger btn-sm" title="Arsipkan"><i class="bi bi-archive"></i></button></form>@endif</td>
      </tr>@empty<tr><td colspan="8" class="text-center py-4">Belum ada jadwal.</td></tr>@endforelse</tbody>
    </table>
  </div>
</div>
@endsection
@push('scripts')
<script>document.addEventListener('DOMContentLoaded', function () { initDataTable('#schedulesTable'); });</script>
@endpush
