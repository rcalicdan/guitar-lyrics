<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Brand Logo -->
    <div class="sidebar-brand mb-3 pt-3">
        <a href="{{ route_to('home') }}" class="brand-link d-flex align-items-center text-decoration-none">
            <img src="/admin-lte/dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3 opacity-75 shadow me-2" width="40" height="40" />
            <span class="brand-text fw-light fs-4 text-white">Guitar Lyrics</span>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('dashboard') }}" class="nav-link rounded {{ active_class('dashboard*') }}">
                        <i class="nav-icon bi bi-speedometer me-2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Songs -->
                <li class="nav-item mb-1">
                    <a href="#"
                        class="nav-link rounded {{ active_class(['songs', 'songs/categories*', 'songs/artist*', 'songs/view*']) }}">
                        <i class="nav-icon bi bi-music-note-list me-2"></i>
                        <p>
                            Songs
                            <i class="right bi bi-chevron-down ms-auto"></i>
                        </p>
                    </a>

                    <!-- Submenu -->
                    <ul class="nav nav-treeview ps-3 mt-1">
                        <li class="nav-item mb-1">
                            <a href="{{ route_to('songs.index') }}"
                                class="nav-link rounded {{ active_class(['songs', 'songs/edit*', 'songs/create*', 'songs/view*']) }}">
                                <i class="nav-icon bi bi-dot me-2"></i>
                                <p>All Songs</p>
                            </a>
                        </li>

                        <li class="nav-item mb-1">
                            <a href="{{ route_to('songs.categories.index') }}"
                                class="nav-link rounded {{ active_class('songs/categories*') }}">
                                <i class="nav-icon bi bi-dot me-2"></i>
                                <p>Song Category</p>
                            </a>
                        </li>

                        <li class="nav-item mb-1">
                            <a href="{{ route_to('songs.artists.index') }}"
                                class="nav-link rounded {{ active_class('songs/artists*') }}">
                                <i class="nav-icon bi bi-dot me-2"></i>
                                <p>Song Artist</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Users -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('users.index') }}" class="nav-link rounded {{ active_class('users*') }}">
                        <i class="nav-icon bi bi-people me-2"></i>
                        <p>Users</p>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-item mb-1">
                    <a href="{{ route_to('settings.index') }}"
                        class="nav-link rounded {{ active_class('settings*') }}">
                        <i class="nav-icon bi bi-gear me-2"></i>
                        <p>Audit Logs</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
