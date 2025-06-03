<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function songShow(songId, songSlug) {
        return {
            songId: songId,
            songSlug: songSlug,
            isFavorite: false,
            viewCount: {{ $song->views_count ?? 0 }},
            formattedViewCount: '{{ $song->formatted_views ?? "0" }}',
            fontSize: 'medium',
            autoScrolling: false,
            isFullscreen: false,
            showFloatingActions: false,
            showScrollTop: false,
            scrollInterval: null,
            relatedSongs: [],
            viewCounted: false,
            
            init() {
                this.loadRelatedSongs();
                this.setupScrollListeners();
                this.loadUserPreferences();
                this.trackView();
                
                setTimeout(() => {
                    this.showFloatingActions = true;
                }, 1000);
            },

            async trackView() {
                setTimeout(async () => {
                    if (!this.viewCounted) {
                        try {
                            const response = await axios.post(`/api/songs/${this.songId}/increment-view`, {}, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            });
                            
                            if (response.data.success) {
                                this.viewCount = response.data.views_count;
                                this.formattedViewCount = response.data.formatted_views;
                                this.viewCounted = true;
                                console.log('View count updated:', this.formattedViewCount);
                            }
                        } catch (error) {
                            console.error('Error tracking view:', error);
                        }
                    }
                }, 3000); 
            },

            formatNumber(num) {
                if (num >= 1000000) {
                    return (num / 1000000).toFixed(1) + 'M';
                } else if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'K';
                }
                return num.toString();
            },
            
            loadRelatedSongs() {
                const serverRelatedSongs = @json($relatedSongs);

                this.relatedSongs = serverRelatedSongs.map(song => ({
                    id: song.id,
                    title: song.title,
                    slug: song.slug,
                    artist_name: song.artist ? song.artist.name : 'Unknown Artist',
                    image_path: song.image_path || '/placeholder/no-image.png'
                }));
            },
            
            setupScrollListeners() {
                window.addEventListener('scroll', () => {
                    this.showScrollTop = window.pageYOffset > 300;
                    
                    clearTimeout(this.scrollTimeout);
                    this.scrollTimeout = setTimeout(() => {
                        this.showFloatingActions = true;
                    }, 150);
                });
            },
            
            loadUserPreferences() {
                const savedFontSize = localStorage.getItem('songFontSize');
                if (savedFontSize) {
                    this.fontSize = savedFontSize;
                }
                
                const savedAutoScroll = localStorage.getItem('autoScrolling');
                if (savedAutoScroll) {
                    this.autoScrolling = savedAutoScroll === 'true';
                }
            },
            
            saveUserPreferences() {
                localStorage.setItem('songFontSize', this.fontSize);
                localStorage.setItem('autoScrolling', this.autoScrolling.toString());
            },
            
            changeFontSize(size) {
                this.fontSize = size;
                this.saveUserPreferences();
            },
            
            toggleFavorite() {
                this.isFavorite = !this.isFavorite;
            },
            
            toggleAutoScroll() {
                this.autoScrolling = !this.autoScrolling;
                
                if (this.autoScrolling) {
                    this.startAutoScroll();
                } else {
                    this.stopAutoScroll();
                }
                
                this.saveUserPreferences();
            },
            
            startAutoScroll() {
                this.scrollInterval = setInterval(() => {
                    window.scrollBy(0, 1);
                    
                    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
                        this.stopAutoScroll();
                    }
                }, 50); 
            },
            
            stopAutoScroll() {
                if (this.scrollInterval) {
                    clearInterval(this.scrollInterval);
                    this.scrollInterval = null;
                }
                this.autoScrolling = false;
            },
            
            toggleFullscreen() {
                if (!this.isFullscreen) {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
                this.isFullscreen = !this.isFullscreen;
            },
            
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            },
            
            destroy() {
                this.stopAutoScroll();
                window.removeEventListener('scroll', this.setupScrollListeners);
            }
        }
    }

    function imageLoader(imagePath) {
        return {
            imageSrc: imagePath,
            imageLoaded: false,
            imageError: false,
            retryCount: 0,
            maxRetries: 3,
            
            init() {
                this.preloadImage();
            },
            
            preloadImage() {
                const img = new Image();
                
                img.onload = () => {
                    console.log('Image loaded successfully:', this.imageSrc);
                    this.imageLoaded = true;
                    this.imageError = false;
                };
                
                img.onerror = () => {
                    console.log('Image failed to load:', this.imageSrc, 'Retry:', this.retryCount);
                    
                    if (this.retryCount < this.maxRetries) {
                        this.retryCount++;
                        setTimeout(() => {
                            this.preloadImage();
                        }, 1000 * this.retryCount);
                    } else {
                        this.imageError = true;
                        this.imageLoaded = false;
                        this.imageSrc = '/placeholder/no-image.png';
                    }
                };
                
                const cacheBuster = this.retryCount > 0 ? `?v=${Date.now()}` : '';
                img.src = this.imageSrc + cacheBuster;
            }
        }
    }
</script>