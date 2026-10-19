@extends('layouts.admin')

@section('content')

<h2 class="mb-4">CRM WhatsApp Dashboard</h2>

<div class="row">

<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">

        <form method="GET" action="/wa-dashboard" class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    🔍 Filter
                </button>

                <a href="/wa-dashboard" class="btn btn-secondary">
                    Reset
                </a>
                <a href="{{ route('wa.dashboard.export', request()->query()) }}"
                   class="btn btn-success">
                    Export Excel
                </a>
            </div>

        </form>

    </div>
</div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5>Total WA Terkirim</h5>
                <h2 class="fw-bold text-success">
                    {{ $totalWa }}
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="card mt-4 shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-3">📨 WA Terakhir</h5>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Case ID</th>    
                    <th>Customer</th>
                    <th>PIC</th>
                    <th>Nomor</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentWa as $wa)
                    <tr>
                        <td>{{ $recentWa->firstItem() + $loop->index }}</td>
                        <td>{{ $wa->case_id }}</td>
                        <td>{{ $wa->customer_name }}</td>
                        <td>{{ $wa->pic }}</td>
                        <td>{{ $wa->customer_phone }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($wa->message, 50) }}</td>
                        <td>
                            @if($wa->status == 'sent')
                                <span class="badge bg-success">Sent</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </td>
                        <td>{{ $wa->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada WA terkirim
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
 {{-- PAGINATION --}}
        <div class="mt-3">
           {{ $recentWa->links() }}
        </div>
    </div>
</div>

@endsection