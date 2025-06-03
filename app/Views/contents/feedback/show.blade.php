<div class="card shadow-sm mt-0 pt-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-light">
        <h4 class="mb-0">Feedback Details</h4>
        <span class="badge bg-info">
            {{ $feedback->created_at->format('M j, Y g:i A') }}
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Feedback Meta Information -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="card border shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong class="text-muted d-block">Name:</strong>
                            <span class="fs-6">{{ $feedback->name ?: 'Anonymous' }}</span>
                        </div>

                        <div class="mb-3">
                            <strong class="text-muted d-block">Email:</strong>
                            @if ($feedback->email)
                                <a href="mailto:{{ $feedback->email }}" class="text-decoration-none">
                                    {{ $feedback->email }}
                                </a>
                            @else
                                <span class="text-muted">Not provided</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <strong class="text-muted d-block">Submitted:</strong>
                            <span class="fs-6">{{ $feedback->created_at->format('F j, Y') }}</span>
                            <small class="text-muted d-block">{{ $feedback->created_at->format('g:i A') }}</small>
                        </div>

                        <div class="mb-0">
                            <strong class="text-muted d-block">Time Ago:</strong>
                            <span class="fs-6">{{ $feedback->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Content -->
            <div class="col-md-8">
                <div class="card border shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-comment-dots me-2"></i>Feedback Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="feedback-content" style="white-space: pre-wrap; line-height: 1.6;">
                            {{ $feedback->content }}
                        </div>
                    </div>
                </div>

                <!-- Additional Actions -->
                <div class="mt-4">
                    <div class="row g-3">
                        @if ($feedback->email)
                            <div class="col-md-6">
                                <a href="mailto:{{ $feedback->email }}?subject=Re: Your Feedback"
                                    class="btn btn-outline-primary w-100">
                                    <i class="fas fa-reply me-2"></i>Reply via Email
                                </a>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <button class="btn btn-outline-secondary w-100" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Print Feedback
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent">
        <div class="d-flex justify-content-between">
            <a href="{{ back_url('feedbacks.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Feedback List
            </a>
            <div>
                @can('delete', $feedback)
                    @include('components.utils.delete-button', [
                        'route' => 'feedbacks.delete',
                        'id' => $feedback->id,
                        'itemName' => 'feedback',
                    ])
                @endcan
            </div>
        </div>
    </div>
</div>

@push('custom-styles')
    <style>
        .feedback-content {
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            min-height: 200px;
        }

        @media print {

            .btn,
            .card-footer {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
@endpush
