<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Brand Logo -->
    <div class="sidebar-brand mb-3 pt-3">
        <a href="{{ route_to('home') }}" class="brand-link d-flex align-items-center text-decoration-none">
            <i class="fas fa-guitar me-2"
                style="font-size: 2.5rem; background: linear-gradient(45deg, #8B5CF6, #A78BFA); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"></i>
            <span class="brand-text fw-light fs-4 text-white">Guitar Lyrics</span>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                @can('view-dashboard')
                <li class="nav-item mb-1">
                    <a href="{{ route_to('dashboard') }}" class="nav-link rounded {{ active_class('dashboard*') }}">
                        <i class="nav-icon bi bi-speedometer me-2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @endcan

                <!-- Link for All Songs -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('songs.index') }}"
                        class="nav-link rounded {{ active_class(['song', 'song/edit*', 'song/create*', 'song/view*']) }}">
                        <i class="nav-icon bi bi-music-note-list me-2"></i>
                        <p>All Songs</p>
                    </a>
                </li>

                <!-- Link for My Published Songs -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('my-songs.index') }}" class="nav-link rounded {{ active_class('my-songs*') }}">
                        <i class="nav-icon bi bi-file-earmark-music me-2"></i>
                        <p>My Published Songs</p>
                    </a>
                </li>

                <!-- Link for Song Categories -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('songs.categories.index') }}"
                        class="nav-link rounded {{ active_class('song/categories*') }}">
                        <i class="nav-icon bi bi-tags me-2"></i>
                        <p>Song Category</p>
                    </a>
                </li>

                <!-- Link for Song Artists -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('songs.artists.index') }}"
                        class="nav-link rounded {{ active_class('song/artists*') }}">
                        <i class="nav-icon bi bi-person-badge me-2"></i>
                        <p>Song Artist</p>
                    </a>
                </li>

                <!-- Users -->
                @can('viewAny', App\Models\User::class)
                <li class="nav-item mb-1">
                    <a href="{{ route_to('users.index') }}" class="nav-link rounded {{ active_class('users*') }}">
                        <i class="nav-icon bi bi-people me-2"></i>
                        <p>Users</p>
                    </a>
                </li>
                @endcan

                @can('viewAny', App\Models\Feedback::class)
                <!-- Feedbacks -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('feedbacks.index') }}"
                        class="nav-link rounded {{ active_class('user-feedbacks*') }}">
                        <i class="nav-icon bi bi-chat-dots me-2"></i>
                        <p>Feedbacks</p>
                    </a>
                </li>
                @endcan

                <!-- Audit Logs -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('audit-logs.index') }}" class="nav-link rounded {{ active_class('audit-log*') }}">
                        <i class="nav-icon bi bi-gear me-2"></i>
                        <p>Audit Logs</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>