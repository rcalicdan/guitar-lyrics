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
                                    <h3>{{ $songsCount ?? '10K+' }}</h3>
                                    <p>Songs</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3>{{ $artistsCount ?? '5K+' }}</h3>
                                    <p>Artists</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3>{{ $usersCount ?? '50K+' }}</h3>
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