<script>
    function songShow() {
    return {
        // State variables
        isFavorite: false,
        viewCount: Math.floor(Math.random() * 1000) + 100, // Mock view count
        fontSize: 'medium',
        autoScrolling: false,
        isFullscreen: false,
        showFloatingActions: false,
        showScrollTop: false,
        showShareModal: false,
        copying: false,
        copied: false,
        scrollInterval: null,
        relatedSongs: [],
        
        // URLs and links
        shareUrl: window.location.href,
        socialLinks: {
            facebook: '',
            twitter: '',
            whatsapp: ''
        },
        
        init() {
            // Initialize component
            this.setupSocialLinks();
            this.loadRelatedSongs();
            this.setupScrollListeners();
            this.loadUserPreferences();
            
            // Show floating actions after a delay
            setTimeout(() => {
                this.showFloatingActions = true;
            }, 1000);
        },
        
        setupSocialLinks() {
            const songTitle = '{{ $song->title }}';
            const artistName = '{{ $song->artist_name }}';
            const shareText = `Check out "${songTitle}" by ${artistName} - Guitar chords and lyrics`;
            const encodedText = encodeURIComponent(shareText);
            const encodedUrl = encodeURIComponent(this.shareUrl);
            
            this.socialLinks = {
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`,
                twitter: `https://twitter.com/intent/tweet?text=${encodedText}&url=${encodedUrl}`,
                whatsapp: `https://wa.me/?text=${encodedText} ${encodedUrl}`
            };
        },
        
        loadRelatedSongs() {
            // Mock related songs - in real app, this would be an API call
            this.relatedSongs = [
                {
                    id: 1,
                    title: 'Sample Song 1',
                    artist_name: '{{ $song->artist_name }}',
                    image_path: '/placeholder/song1.png'
                },
                {
                    id: 2,
                    title: 'Sample Song 2',
                    artist_name: '{{ $song->artist_name }}',
                    image_path: '/placeholder/song2.png'
                }
            ].filter(song => song.id !== {{ $song->id }});
        },
        
      setupScrollListeners() {
            window.addEventListener('scroll', () => {
                // Show scroll to top button when scrolled down
                this.showScrollTop = window.pageYOffset > 300;
                
                // Auto-hide floating actions when scrolling
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
        
        openShareModal() {
            this.showShareModal = true;
        },
        
        closeShareModal() {
            this.showShareModal = false;
        },
        
        async copyToClipboard() {
            this.copying = true;
            
            try {
                await navigator.clipboard.writeText(this.shareUrl);
                this.copied = true;
                
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch (err) {
                console.error('Failed to copy: ', err);
            } finally {
                this.copying = false;
            }
        },
        
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        },
        
        printSong() {
            window.print();
        },
        
        destroy() {
            this.stopAutoScroll();
            window.removeEventListener('scroll', this.setupScrollListeners);
        }
    }
}
</script>