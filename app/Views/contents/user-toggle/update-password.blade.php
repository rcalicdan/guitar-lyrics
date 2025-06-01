<div class="row">
    <div class="col-md-8 offset-md-2">
        <!-- Card -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Update Password</h3>
            </div>
            <!-- Form -->
            <form id="updatePasswordForm" action="{{ route_to('profile.update-password.post') }}" method="POST">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <!-- Old Password -->
                    <div class="mb-3 position-relative">
                        <label for="old_password" class="form-label">Old Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="old_password" name="old_password"
                                placeholder="Enter your current password" value="{{ old('old_password') }}" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="old_password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('old_password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- New Password -->
                    <div class="mb-3 position-relative">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Enter a new password" value="{{ old('new_password') }}" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="new_password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Password must be at least 8 characters long.</small>
                        @error('new_password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Confirm Password -->
                    <div class="mb-3 position-relative">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Re-enter your new password" value="{{ old('confirm_password') }}" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="confirm_password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('confirm_password')
                            <div class="text-danger mt-1">{{ $message }}</div>
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

@include('stacks.user-toggle.update-password-stack')
