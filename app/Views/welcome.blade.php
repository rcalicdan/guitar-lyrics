<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guitar Lyrics & Chords</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="/">
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
                        <a class="nav-link" href="#featured">Songs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feedback">Send Feedback</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light" href="{{route_to('login')}}">
                            <i class="fas fa-user me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Hero Landing Section -->
    <section class="landing-hero">
        <div class="landing-overlay"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6">
                    <div class="landing-content">
                        <h1 class="display-3 fw-bold mb-4">Learn Guitar with Us</h1>
                        <p class="lead mb-4">Discover thousands of guitar chords and lyrics. Start your musical
                            journey today with our comprehensive collection.</p>
                        <div class="landing-cta">
                            <a href="#featured" class="btn btn-custom me-3">Get Started</a>
                            <a href="#" class="btn btn-outline-light">Learn More</a>
                        </div>
                        <div class="landing-stats mt-5">
                            <div class="row g-4">
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h3>10K+</h3>
                                        <p>Songs</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h3>5K+</h3>
                                        <p>Artists</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h3>50K+</h3>
                                        <p>Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="landing-image">
                        <img src="/placeholder/guitar-hero.png" alt="Guitar Player" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-content">
            <div class="container text-center">
                <h1>Welcome to GuitarLyrics</h1>
                <p class="mx-auto">Your Ultimate Destination for Guitar Lyrics & Chords</p>
                <a href="#featured" class="btn btn-custom">Explore Now</a>
            </div>
        </div>
    </header>

    <!-- Featured Songs Section -->
    <section id="featured" class="py-5">
        <div class="container">
            <div class="section-title text-center">
                <h2>Featured Songs</h2>
                <p>Discover the latest and most popular guitar songs.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="/placeholder/hey-jude.png" class="card-img-top" alt="Hey Jude">
                        <div class="card-body text-center">
                            <h5 class="card-title">Hey Jude</h5>
                            <p class="card-text">The Beatles</p>
                            <a href="#" class="btn btn-custom">View Chords</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="/placeholder/hello-goodbye.png" class="card-img-top" alt="Hello Goodbye">
                        <div class="card-body text-center">
                            <h5 class="card-title">Hello Goodbye</h5>
                            <p class="card-text">The Beatles</p>
                            <a href="#" class="btn btn-custom">View Chords</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="/placeholder/we-are-the-champion.png" class="card-img-top" alt="We are the Champions">
                        <div class="card-body text-center">
                            <h5 class="card-title">We are the Champions</h5>
                            <p class="card-text">Queen</p>
                            <a href="#" class="btn btn-custom">View Chords</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="section-title text-center">
                <h2>Browse by Category</h2>
                <p>Find your favorite genre and start playing!</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="category-card text-center">
                        <i class="fas fa-music category-icon"></i>
                        <h5>Pop</h5>
                        <a href="#" class="btn btn-link">Explore Pop Songs</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card text-center">
                        <i class="fas fa-guitar category-icon"></i>
                        <h5>Rock</h5>
                        <a href="#" class="btn btn-link">Explore Rock Songs</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card text-center">
                        <i class="fas fa-heart category-icon"></i>
                        <h5>Love Songs</h5>
                        <a href="#" class="btn btn-link">Explore Love Songs</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card text-center">
                        <i class="fas fa-microphone category-icon"></i>
                        <h5>Classical</h5>
                        <a href="#" class="btn btn-link">Explore Classical Songs</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2>Ready to Start Playing?</h2>
            <p class="mx-auto" style="max-width: 600px;">Join thousands of guitar enthusiasts sharing and learning
                chords every day.</p>
            <a href="#" class="btn btn-custom">Get Started</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
            <p class="text-center mb-0">&copy; 2023 GuitarLyrics. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Homepage Js -->
    <script src="js/homepage.js"></script>
    @vite(['resources/js/app.js'])
</body>

</html>