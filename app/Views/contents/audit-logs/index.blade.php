@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @include('contents.audit-logs.search-modal')

            @component('x-partials.card-header', ['header_name' => 'Audit Logs'])
            <div class="col-12 d-grid">
                @include('components.utils.search-modal-button', [
                'button_name' => 'Search Audit Logs',
                ])
            </div>
            @endcomponent

            <!-- Audit Logs Table -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Record ID</th>
                                <th>Event</th>
                                <th>User Id</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($auditLogs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ class_basename($log->auditable_type) }}
                                    </span>
                                </td>
                                <td>{{ $log->auditable_id }}</td>
                                <td>
                                    <span class="badge 
                                            @if ($log->event === 'created' || $log->event === 'user-registered') bg-success
                                            @elseif($log->event === 'updated') bg-warning
                                            @elseif($log->event === 'deleted') bg-danger
                                            @else bg-secondary @endif">
                                        {{ ucfirst($log->event) }}
                                    </span>
                                </td>
                                <td>{{ $log->user->id ?? 'System' }}</td>
                                <td>{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                                <td class="text center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @include('components.utils.view-button', [
                                        'route' => 'audit-logs.show',
                                        'id' => $log->id,
                                        ])
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>No audit logs found.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if ($auditLogs->hasPages())
            <div class="card-footer">
                {!! $auditLogs->links() !!}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection