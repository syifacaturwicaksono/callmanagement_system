@extends('layouts.admin')

@section('content')

<h2 class="mb-4">🗄️ Backup History</h2>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <small class="text-muted">
            ℹ️ File backup dibuat OTOMATIS setiap hari (email_logs, wa_logs, pending_case,
            close_case). Klik nama file untuk download sebagai Excel (.csv).
            Backup lebih lama dari 30 hari otomatis dihapus sendiri oleh sistem.
        </small>
    </div>
</div>

@forelse($folders as $folder)
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h5 class="mb-3">📅 {{ $folder['date'] }}</h5>

            @if($folder['files']->isEmpty())
                <p class="text-muted mb-0">Tidak ada file.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th width="120">Ukuran</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($folder['files'] as $file)
                                <tr>
                                    <td>{{ $file['name'] }}</td>
                                    <td>{{ number_format($file['size'] / 1024, 1) }} KB</td>
                                    <td>
                                        <a href="/backup-history/download?path={{ urlencode($file['path']) }}"
                                           class="btn btn-sm btn-success">
                                            📥 Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@empty
    <div class="card shadow-sm border-0">
        <div class="card-body text-center text-muted py-4">
            Belum ada backup. Backup otomatis akan muncul di sini setelah dijalankan
            (lihat CARA_AKTIFKAN_BACKUP_OTOMATIS.txt untuk aktivasi).
        </div>
    </div>
@endforelse

@endsection
