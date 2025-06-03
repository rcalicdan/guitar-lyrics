<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route_to('home') }}">
            <i class="fas fa-guitar me-2"></i>
            GuitarLyrics
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route_to('home.songs.index') }}">Songs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route_to('about-us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route_to('feedback') }}">Send Feedback</a>
                </li>
                @auth
                    @if (auth()->user()->isUser())
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-outline-light" href="{{ route_to('songs.index') }}">
                                <i class="fas fa-user me-2"></i>Go to Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-outline-light" href="{{ route_to('dashboard') }}">
                                <i class="fas fa-user me-2"></i>Go to Dashboard
                            </a>
                        </li>
                    @endif
                @endauth
                @guest
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light" href="{{ route_to('login') }}">
                            <i class="fas fa-user me-2"></i>Login
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
