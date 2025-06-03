@use('Illuminate\Support\Str')

<!-- Card -->
<div class="card mt-2">
    <!-- Card Header -->
    @component('x-partials.card-header', ['header_name' => 'Feedback List'])
        <div class="col-12 d-grid">
            @include('components.utils.search-modal-button', [
                'button_name' => 'Search Feedback',
                'class' => 'w-100',
            ])
        </div>
    @endcomponent

    <!-- Card Body -->
    <div class="card-body">
        @if ($feedbacks->isEmpty())
            <p class="text-center">No feedback found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Content Preview</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->id }}</td>
                                <td>{{ $feedback->name ?: 'Anonymous' }}</td>
                                <td>{{ $feedback->email ?: 'Not provided' }}</td>
                                <td>{{ Str::limit($feedback->content, 50) }}</td>
                                <td>{{ $feedback->created_at->format('M j, Y g:i A') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @can('view', $feedback)
                                            @include('components.utils.view-button', [
                                                'route' => 'feedbacks.show',
                                                'id' => $feedback->id,
                                            ])
                                        @endcan
                                        @can('delete', $feedback)
                                            @include('components.utils.delete-button', [
                                                'route' => 'feedbacks.delete',
                                                'id' => $feedback->id,
                                                'itemName' => 'feedback',
                                            ])
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {!! $feedbacks->links() !!}
        </div>
    </div>
</div>

@component('x-modals.search-modal', ['modal_title' => 'Search Feedback', 'url' => 'feedback'])
    <div class="mb-3">
        <label for="searchName" class="form-label">Name</label>
        <input type="text" class="form-control" id="searchName" name="name" value="{{ get('name') }}"
            placeholder="Enter name">
    </div>

    <div class="mb-3">
        <label for="searchEmail" class="form-label">Email</label>
        <input type="email" class="form-control" id="searchEmail" name="email" value="{{ get('email') }}"
            placeholder="Enter email">
    </div>

    <div class="mb-3">
        <label for="searchContent" class="form-label">Content</label>
        <input type="text" class="form-control" id="searchContent" name="content" value="{{ get('content') }}"
            placeholder="Search in content">
    </div>

    <div class="mb-3">
        <label for="searchDateFrom" class="form-label">Date From</label>
        <input type="date" class="form-control" id="searchDateFrom" name="date_from" value="{{ get('date_from') }}">
    </div>

    <div class="mb-3">
        <label for="searchDateTo" class="form-label">Date To</label>
        <input type="date" class="form-control" id="searchDateTo" name="date_to" value="{{ get('date_to') }}">
    </div>
@endcomponent

@push('custom-styles')
<style>
    .cursor-pointer {
        cursor: pointer;
    }

    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
    }
</style>
@endpush