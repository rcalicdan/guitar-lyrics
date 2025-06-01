<div class="row">
    <div class="col-md-8 offset-md-2">
        <!-- Card -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Update Profile Image</h3>
            </div>
            <!-- Form -->
            <form id="updateProfileImageForm" action="{{ route_to('profile.update-profile-image.post') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!-- Profile Image Preview -->
                    <div class="text-center mb-4">
                        <img id="profileImagePreview" src="{{ $userImage ?? '/placeholder/no-profile.png' }}"
                            alt="Profile Image" class="rounded-circle shadow"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <!-- File Input -->
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Upload New Profile Image</label>
                        <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                            id="profile_image" name="profile_image" accept="image/*" required>
                        <small class="text-muted">Choose a square image (e.g., 300x300 pixels) for best results.</small>

                        @error('profile_image')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <!-- Card Footer -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('stacks.user-toggle.update-profile-image-stack')
