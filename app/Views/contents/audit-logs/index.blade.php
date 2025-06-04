@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Audit Logs</h3>
            </div>
            
            <!-- Search Filters -->
            <div class="card-body border-bottom">
                <form method="GET" action="{{ route_to('audit-logs.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ get('search') }}" 
                                   placeholder="Search by type, event, or user">
                        </div>
                        
                        <div class="col-md-2">
                            <label for="event" class="form-label">Event</label>
                            <select class="form-select" id="event" name="event">
                                <option value="">All Events</option>
                                @foreach($events as $event)
                                    <option value="{{ $event }}" {{ get('event') == $event ? 'selected' : '' }}>
                                        {{ ucfirst($event) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="auditable_type" class="form-label">Type</label>
                            <select class="form-select" id="auditable_type" name="auditable_type">
                                <option value="">All Types</option>
                                @foreach($auditableTypes as $type)
                                    <option value="{{ $type }}" {{ get('auditable_type') == $type ? 'selected' : '' }}>
                                        {{ class_basename($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ get('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="date_from" 
                                   name="date_from" 
                                   value="{{ get('date_from') }}">
                        </div>
                        
                        <div class="col-md-1">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="date_to" 
                                   name="date_to" 
                                   value="{{ get('date_to') }}">
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="{{ route_to('audit-logs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
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
                                <th>User</th>
                                <th>Date</th>
                                <th>Actions</th>
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
                                            @if($log->event === 'created') bg-success
                                            @elseif($log->event === 'updated') bg-warning
                                            @elseif($log->event === 'deleted') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($log->event) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->user->name ?? 'System' }}</td>
                                    <td>{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route_to('audit-logs.show', $log->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
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
            @if($auditLogs->hasPages())
                <div class="card-footer">
                    {{ $auditLogs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection