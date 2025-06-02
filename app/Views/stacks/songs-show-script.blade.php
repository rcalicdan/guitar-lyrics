<script>
    function songShow() {
    return {
        isFavorite: false,
        viewCount: Math.floor(Math.random() * 1000) + 100,
        fontSize: 'medium',
        autoScrolling: false,
        isFullscreen: false,
        showFloatingActions: false,
        showScrollTop: false,
        scrollInterval: null,
        relatedSongs: [],
        
        init() {
            this.loadRelatedSongs();
            this.setupScrollListeners();
            this.loadUserPreferences();
            
            setTimeout(() => {
                this.showFloatingActions = true;
            }, 1000);
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
            this.relatedSongs = [
                {
                    id: 1,
                    title: 'Sample Song 1',
                    artist_name: '{{ $song->artist_name }}',
                    image_path:  '{{ $song->image_path }}'
                },
                {
                    id: 2,
                    title: 'Sample Song 2',
                    artist_name: '{{ $song->artist_name }}',
                    image_path: '{{ $song->image_path }}'
                }
            ].filter(song => song.id !== {{ $song->id }});
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
            // In a real app, you'd make an API call here
            // this.updateFavoriteStatus();
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
</script>