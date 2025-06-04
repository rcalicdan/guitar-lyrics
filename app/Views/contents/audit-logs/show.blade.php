@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Audit Log Details</h3>
                <a href="{{ back_url('songs.artists.index') }}" class="btn btn-outline-secondary"><i
                        class="fas fa-arrow-left me-1"></i> Back
                    toArtists
                </a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">ID:</th>
                                <td>{{ $auditLog->id }}</td>
                            </tr>
                            <tr>
                                <th>Type:</th>
                                <td>
                                    <span class="badge bg-info">
                                        {{ class_basename($auditLog->auditable_type) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Record ID:</th>
                                <td>{{ $auditLog->auditable_id }}</td>
                            </tr>
                            <tr>
                                <th>Event:</th>
                                <td>
                                    <span class="badge 
                                        @if($auditLog->event === 'created') bg-success
                                        @elseif($auditLog->event === 'updated') bg-warning
                                        @elseif($auditLog->event === 'deleted') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($auditLog->event) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>User Id:</th>
                                <td>{{ $auditLog->user->id ?? 'System' }}</td>
                            </tr>
                            <tr>
                                <th>User Id:</th>
                                <td>{{ $auditLog->user->full_name ?? 'System' }}</td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ $auditLog->created_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($auditLog->old_values || $auditLog->new_values)
                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Changes</h5>
                        <div class="row">
                            @if($auditLog->old_values)
                            <div class="col-md-6">
                                <h6 class="text-danger">Old Values</h6>
                                <div class="bg-light p-3 rounded">
                                    <pre class="mb-0">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif

                            @if($auditLog->new_values)
                            <div class="col-md-6">
                                <h6 class="text-success">New Values</h6>
                                <div class="bg-light p-3 rounded">
                                    <pre class="mb-0">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection