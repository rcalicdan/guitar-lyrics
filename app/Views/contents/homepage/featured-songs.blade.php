<!-- Featured Songs Section -->
<section id="featured" class="py-5">
    <div class="container">
        <div class="section-title text-center">
            <h2>Featured Songs</h2>
            <p>Discover the latest and most popular guitar songs.</p>
        </div>
        <div class="row g-4">
            @if(isset($featuredSongs) && count($featuredSongs) > 0)
                @foreach($featuredSongs as $song)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="{{ $song['image'] ?? '/placeholder/song-default.png' }}" class="card-img-top" alt="{{ $song['title'] }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $song['title'] }}</h5>
                                <p class="card-text">{{ $song['artist'] }}</p>
                                <a href="{{ route_to('home.songs.show', $song['slug'] ?? '#') }}" class="btn btn-custom">View Chords</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default songs -->
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
            @endif
        </div>
    </div>
</section>