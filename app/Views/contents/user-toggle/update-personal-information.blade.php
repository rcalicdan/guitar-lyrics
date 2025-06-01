<div class="row">
    <div class="col-md-8 offset-md-2">
        <!-- Card -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Update Personal Information</h3>
            </div>
            <!-- Form -->
            <form action="{{ route_to('profile.update-profile-information.post') }}" method="POST">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            placeholder="Enter first name" value="{{ $user->first_name }}" required>
                    </div>
                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            placeholder="Enter last name" value="{{ $user->last_name }}" required>
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter email address" value="{{ $user->email }}" required>
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

@include('stacks.user-toggle.update-personal-information-stack')
