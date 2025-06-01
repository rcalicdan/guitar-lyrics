<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <!-- Profile Header -->
                    <div class="text-center position-relative mb-5">
                        <div class="profile-image-container">
                            <img src="{{ $user->image_path ?? '/placeholder/no-profile.png' }}"
                                alt="Profile Image" class="profile-image">
                            <div class="edit-overlay">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <h3 class="mt-4 mb-1">{{ $user->full_name }}</h3>
                        <p class="text-muted">{{ $user['role'] ?? 'Member' }}</p>
                    </div>

                    <!-- Profile Information -->
                    <div class="profile-info mb-5">
                        <div class="info-item">
                            <i class="fas fa-envelope text-primary"></i>
                            <div class="info-content">
                                <label>Email</label>
                                <p>{{ $user->email ?? 'john.doe@example.com' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            <div class="info-content">
                                <label>Address</label>
                                <p>{{ $user['address'] ?? '123 Main St, City, Country' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bio Section -->
                    <div class="bio-section mb-5">
                        <h5 class="section-title">About Me</h5>
                        <div class="bio-content p-4 bg-light rounded">
                            <p class="mb-0">{{ $user['bio'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Nulla vitae elit libero, a pharetra augue.' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route_to('profile.update-personal-information') }}" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route_to('profile.update-password') }}" class="btn btn-outline-primary px-4 py-2">
                            <i class="fas fa-key me-2"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('stacks.user-toggle.user-profile-stack')