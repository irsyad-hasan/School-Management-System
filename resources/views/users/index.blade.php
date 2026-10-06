@extends('layouts.admin')
@section('title','Manajemen Pengguna')
@section('page-title','Manajemen Pengguna')
@section('breadcrumb','Manajemen Pengguna')
@section('content')<div class="card shadow-sm"><div class="card-header"><h3 class="card-title">Daftar Pengguna Aktif</h3></div><div class="card-body datatable-container"><table id="usersTable" class="table table-hover align-middle"><thead><tr><th>No.</th><th>Username</th><th>Email</th><th>Peran</th><th>Detail</th></tr></thead><tbody>@forelse($users as $user)<tr><td>{{ $loop->iteration }}</td><td>{{ $user->username }}</td><td>{{ $user->email }}</td><td><span class="badge text-bg-{{ $user->role==='admin'?'danger':($user->role==='teacher'?'primary':'success') }}">{{ ucfirst($user->role) }}</span></td><td>@if($user->role==='admin')<span class="text-muted">Akun admin dilindungi</span>@else<form method="POST" action="{{ route('users.destroy',$user) }}" onsubmit="return confirm('Nonaktifkan akun pengguna ini?')">@csrf @method('DELETE')<button class="btn btn-danger btn-sm" title="Nonaktifkan Pengguna"><i class="bi bi-person-x"></i></button></form>@endif</td></tr>@empty<tr><td colspan="5" class="text-center py-4">Belum ada pengguna aktif.</td></tr>@endforelse</tbody></table></div></div>@endsection
@push('scripts')
<script>document.addEventListener('DOMContentLoaded', function () { initDataTable('#usersTable'); });</script>
@endpush
