@extends('layouts.homepage')

@section('title', 'Feedback - Guitar Lyrics & Chords')

@push('styles')
<style>
    .feedback-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px 0 80px;
    }

    .feedback-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .feedback-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 2rem;
        text-align: center;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        transform: translateY(-1px);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        color: #dc3545;
        font-weight: 500;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .feedback-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .char-counter {
        font-size: 0.875rem;
        color: #6c757d;
        text-align: right;
        margin-top: 0.25rem;
    }

    .char-counter.warning {
        color: #fd7e14;
    }

    .char-counter.danger {
        color: #dc3545;
    }

    .row.justify-content-center {
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .feedback-container {
            padding: 100px 15px 60px;
        }

        .feedback-card {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 576px) {
        .feedback-container {
            padding: 80px 10px 40px;
        }

        .feedback-header {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="feedback-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="feedback-card">
                    <!-- Header -->
                    <div class="feedback-header">
                        <i class="fas fa-comments feedback-icon"></i>
                        <h1 class="h2 mb-0">We'd Love Your Feedback</h1>
                        <p class="mb-0 mt-2 opacity-90">Help us improve your experience with Guitar Lyrics & Chords</p>
                    </div>

                    <!-- Form Body -->
                    <div class="p-4">
                        <!-- Success Message -->
                        @if(session('success'))
                        <div class="alert alert-success" x-data="{ show: true }" x-show="show"
                            x-init="setTimeout(() => show = false, 5000)">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                        @endif

                        <!-- General Error Message -->
                        @if(session('error'))
                        <div class="alert alert-danger" x-data="{ show: true }" x-show="show"
                            x-init="setTimeout(() => show = false, 5000)">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                        @endif

                        <form action="{{ route_to('feedback.post') }}" method="POST" x-data="feedbackForm()">
                            @csrf

                            <div class="row">
                                <!-- Name Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Your Name *
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Enter your full name" maxlength="100" required>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>
                                        Email Address *
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="your.email@example.com" maxlength="255" required>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Feedback Content -->
                            <div class="mb-4">
                                <label for="content" class="form-label">
                                    <i class="fas fa-comment-alt me-1"></i>
                                    Your Feedback *
                                </label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content"
                                    name="content" rows="6"
                                    placeholder="Please share your thoughts, suggestions, or any issues you've encountered..."
                                    maxlength="1000" x-model="content" required>{{ old('content') }}</textarea>

                                <!-- Character Counter -->
                                <div class="char-counter" :class="{ 
                                        'warning': content.length > 800, 
                                        'danger': content.length > 950 
                                    }">
                                    <span x-text="content.length"></span> / 1000 characters
                                </div>

                                @error('content')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-submit px-5">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Send Feedback
                                </button>
                            </div>
                        </form>

                        <!-- Additional Info -->
                        <div class="mt-4 pt-4 border-top text-center text-muted">
                            <small>
                                <i class="fas fa-shield-alt me-1"></i>
                                Your information is secure and will only be used to improve our service.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function feedbackForm() {
        return {
            content: '{{ old("content") }}',
            
            init() {
                this.$nextTick(() => {
                    const textarea = document.getElementById('content');
                    if (textarea) {
                        this.autoResize(textarea);
                        textarea.addEventListener('input', () => this.autoResize(textarea));
                    }
                });
            },
            
            autoResize(textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            }
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>
@endpush