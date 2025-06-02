<!-- Song Content -->
<section class="py-5">
    <div class="container">
        <!-- Song Meta Card -->
        <div class="song-meta-card mb-4" 
             x-show="true"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="mb-3">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Song Details
                    </h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong><i class="fas fa-user me-2"></i>Artist:</strong> 
                                <span>{{ $song->artist_name }}</span>
                            </div>
                            <div class="detail-item">
                                <strong><i class="fas fa-tag me-2"></i>Category:</strong> 
                                <span>{{ $song->category_name }}</span>
                            </div>
                            <div class="detail-item">
                                <strong><i class="fas fa-user-plus me-2"></i>By:</strong> 
                                <span>{{ $song->user->full_name ?? 'Unknown User' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong><i class="fas fa-calendar-plus me-2"></i>Added:</strong> 
                                <span>{{ $song->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="detail-item">
                                <strong><i class="fas fa-calendar-edit me-2"></i>Updated:</strong> 
                                <span>{{ $song->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="action-buttons">
                        <a href="{{ route_to('songs.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Songs
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rest of the content remains the same -->
        <!-- Content Controls -->
        <div class="content-controls mb-4"
             x-show="true"
             x-transition:enter="transition ease-out duration-500 delay-100"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="mb-0">
                        <i class="fas fa-guitar me-2 text-primary"></i>Chords & Lyrics
                    </h3>
                </div>
                <div class="col-lg-6">
                    <div class="controls-group">
                        <!-- Font Size Control -->
                        <div class="control-item">
                            <label class="control-label">Font Size:</label>
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-outline-secondary btn-sm"
                                        @click="changeFontSize('small')"
                                        :class="{ 'active': fontSize === 'small' }">
                                    <i class="fas fa-font" style="font-size: 0.8em;"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-secondary btn-sm"
                                        @click="changeFontSize('medium')"
                                        :class="{ 'active': fontSize === 'medium' }">
                                    <i class="fas fa-font" style="font-size: 1em;"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-secondary btn-sm"
                                        @click="changeFontSize('large')"
                                        :class="{ 'active': fontSize === 'large' }">
                                    <i class="fas fa-font" style="font-size: 1.2em;"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Auto-scroll Control -->
                        <div class="control-item">
                            <button @click="toggleAutoScroll()" 
                                    class="btn btn-outline-primary btn-sm"
                                    :class="{ 'active': autoScrolling }">
                                <i :class="autoScrolling ? 'fas fa-pause' : 'fas fa-play'" class="me-2"></i>
                                <span x-text="autoScrolling ? 'Pause Scroll' : 'Auto Scroll'"></span>
                            </button>
                        </div>
                        
                        <!-- Fullscreen Control -->
                        <div class="control-item">
                            <button @click="toggleFullscreen()" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-expand me-2"></i>Fullscreen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="content-section" 
             x-show="true"
             x-transition:enter="transition ease-out duration-500 delay-200"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="chord-content" 
                 :class="'font-size-' + fontSize"
                 x-ref="chordContent">
                {!! $song->content !!}
            </div>
        </div>
        
        <!-- Related Songs (if any) -->
        <div class="related-songs mt-5"
             x-show="relatedSongs.length > 0"
             x-transition:enter="transition ease-out duration-500 delay-300"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0">
            <h4 class="mb-4">
                <i class="fas fa-music me-2 text-primary"></i>More from {{ $song->artist_name }}
            </h4>
            <div class="row g-3">
                <template x-for="song in relatedSongs" :key="song.id">
                    <div class="col-md-6 col-lg-4">
                        <a :href="'/songs/' + song.id" class="related-song-link">
                            <div class="related-song-card">
                                <img :src="song.image_path || '/placeholder/no-image.png'" 
                                     :alt="song.title" 
                                     class="related-song-image">
                                <div class="related-song-info">
                                    <h6 x-text="song.title" class="mb-1"></h6>
                                    <small x-text="song.artist_name" class="text-muted"></small>
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>