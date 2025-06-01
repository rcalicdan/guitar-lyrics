<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <img src="{{ auth()->user()->image_path ?? '/placeholder/no-profile.png' }}"
            class="user-image rounded-circle shadow" alt="User Image" />
        <span class="d-none d-md-inline">{{ \Rcalicdan\Ci4Larabridge\Facades\Auth::user()->full_name}}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <!-- User Header -->
        <li class="user-header text-bg-primary">
            <img src="{{ auth()->user()->image_path ?? '/placeholder/no-profile.png' }}" class="rounded-circle shadow"
                alt="User Image" />
            <p>
                {{ auth()->user()->full_name }}
            </p>
            <small>{{ ucfirst(auth()->user()->role) }}</small>
        </li>
        <!-- User Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col">
                    <a href="{{ route_to('profile.update-personal-information') }}"
                        class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-person me-2"></i> Update Personal Information
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="{{ route_to('profile.update-password') }}" class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-lock me-2"></i> Update Password
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="{{ route_to('profile.update-profile-image') }}"
                        class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-image me-2"></i> Update Profile Image
                    </a>
                </div>
            </div>
        </li>
        <!-- User Menu Footer -->
        <li class="user-footer">
            <a href="{{ route_to('profile.page') }}" class="btn btn-default btn-flat">Profile</a>
            <form method="POST" action="{{ route_to('logout.post') }}" class="float-end">
                @csrf
                <button type="submit" class="btn btn-default btn-flat">Sign out</button>
            </form>
        </li>
    </ul>
</li>
