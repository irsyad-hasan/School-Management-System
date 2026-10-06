@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')
@section('breadcrumb', 'Log Aktivitas')

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title mb-1">Riwayat Aktivitas</h3>
                <p class="text-muted mb-0 small">Catatan aktivitas pengguna dan perubahan data dalam sistem.</p>
            </div>
        </div>

        <div class="card-body datatable-container">
            <div class="table-responsive">
                <table id="activityLogsTable" class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Aktivitas</th>
                            <th>Keterangan</th>
                            <th>Alamat IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activityLogs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td data-order="{{ $log->created_at?->timestamp }}">
                                    {{ $log->created_at?->locale('id')->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td>{{ $log->user?->username ?? 'Sistem' }}</td>
                                <td>
                                    @php
                                        $badge = match ($log->action) {
                                            'created' => 'success',
                                            'updated' => 'primary',
                                            'archived' => 'warning',
                                            'deleted' => 'danger',
                                            'login' => 'info',
                                            'logout' => 'secondary',
                                            default => 'dark',
                                        };
                                    @endphp
                                    <span class="badge text-bg-{{ $badge }}">
                                        {{ match ($log->action) {
                                            'created' => 'Tambah',
                                            'updated' => 'Ubah',
                                            'archived' => 'Nonaktifkan',
                                            'deleted' => 'Hapus',
                                            'login' => 'Masuk',
                                            'logout' => 'Keluar',
                                            default => ucfirst($log->action),
                                        } }}
                                    </span>
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->ip_address ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada aktivitas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    initDataTable('#activityLogsTable', {
        order: [[1, 'desc']],
        columnDefs: [{ targets: 0, orderable: false }]
    });
});
</script>
@endpush
