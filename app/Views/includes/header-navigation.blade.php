<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Left Navbar -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="/" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right Navbar -->
        <ul class="navbar-nav ms-auto">
            <!-- User Menu -->
            @include('includes.user-toggle')
        </ul>
    </div>
</nav>