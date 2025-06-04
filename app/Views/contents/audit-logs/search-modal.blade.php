@component('x-modals.search-modal', ['modal_title' => 'Search Audit Logs','url' => 'audit-logs'])
<div class="mb-3">
    <label for="search" class="form-label">Search</label>
    <input type="text" class="form-control" id="search" name="search" value="{{ get('search') }}"
        placeholder="Search by type or event">
</div>

<div class="mb-3">
    <label for="event" class="form-label">Event</label>
    <select class="form-select" id="event" name="event">
        <option value="">All Events</option>
        @foreach($events as $event)
        <option value="{{ $event }}" {{ get('event')==$event ? 'selected' : '' }}>
            {{ ucfirst($event) }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="auditable_type" class="form-label">Type</label>
    <select class="form-select" id="auditable_type" name="auditable_type">
        <option value="">All Types</option>
        @foreach($auditableTypes as $type)
        <option value="{{ $type }}" {{ get('auditable_type')==$type ? 'selected' : '' }}>
            {{ class_basename($type) }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="user_id" class="form-label">User ID</label>
    <input type="number" class="form-control" id="user_id" name="user_id" value="{{ get('user_id') }}"
        placeholder="Enter User ID">
</div>

<div class="mb-3">
    <label for="date_from" class="form-label">From Date</label>
    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ get('date_from') }}">
</div>

<div class="mb-3">
    <label for="date_to" class="form-label">To Date</label>
    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ get('date_to') }}">
</div>
@endcomponent