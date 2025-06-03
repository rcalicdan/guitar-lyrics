<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function songsFilter() {
        return {
            loading: false,
            filters: {
                search: '{{ $currentFilters["search"] }}',
                artist: '{{ $currentFilters["artist"] }}',
                category: '{{ $currentFilters["category"] }}',
                sort: '{{ $currentFilters["sort"] }}'
            },
            
            init() {
                console.log('Songs filter initialized');
            },
            
            submitForm() {
                this.loading = true;
                this.$refs.filterForm.submit();
            },
            
            autoSubmit() {
                if (this.filters.search.length > 2 || this.filters.search.length === 0) {
                    this.submitForm();
                }
            },
            
            clearAllFilters() {
                this.filters = {
                    search: '',
                    artist: '',
                    category: '',
                    sort: 'latest'
                };
                // Also clear artist search
                const artistSearchElements = document.querySelectorAll('[x-data*="artistSearch"]');
                artistSearchElements.forEach(el => {
                    const component = Alpine.$data(el);
                    if (component) {
                        component.clearSelection();
                    }
                });
                this.submitForm();
            },
            
            hasActiveFilters() {
                return this.filters.search || 
                       this.filters.artist || 
                       this.filters.category || 
                       this.filters.sort !== 'latest';
            },
            
            resetForm() {
                this.loading = false;
            }
        }
    }

    function artistSearch() {
        return {
            searchTerm: '',
            selectedArtistId: '{{ $currentFilters["artist"] }}',
            selectedArtistName: '',
            artists: [],
            loading: false,
            showDropdown: false,
            highlightedIndex: -1,
            searchTimeout: null,
            
            async init() {
                console.log('Artist search initialized');
                // If there's a pre-selected artist, load its name
                if (this.selectedArtistId) {
                    await this.loadSelectedArtistName();
                }
            },
            
            async loadSelectedArtistName() {
                try {
                    console.log('Loading selected artist name for ID:', this.selectedArtistId);
                    const response = await axios.get('{{ route_to("songs.artists.search") }}', {
                        params: { term: '' },
                        timeout: 10000
                    });
                    console.log('All artists response:', response.data);
                    
                    const selectedArtist = response.data.find(artist => artist.id == this.selectedArtistId);
                    if (selectedArtist) {
                        this.selectedArtistName = selectedArtist.name;
                        this.searchTerm = selectedArtist.name;
                        console.log('Found selected artist:', selectedArtist);
                    }
                } catch (error) {
                    console.error('Error loading selected artist:', error);
                }
            },
            
            async searchArtists() {
                // Clear previous timeout
                if (this.searchTimeout) {
                    clearTimeout(this.searchTimeout);
                }
                
                if (this.searchTerm.length === 0) {
                    this.artists = [];
                    this.showDropdown = false;
                    return;
                }
                
                // Set a new timeout for debouncing
                this.searchTimeout = setTimeout(async () => {
                    await this.performSearch();
                }, 300);
            },
            
            async performSearch() {
                this.loading = true;
                this.highlightedIndex = -1;
                
                try {
                    console.log('Searching for artists with term:', this.searchTerm);
                    const response = await axios.get('{{ route_to("songs.artists.search") }}', {
                        params: { term: this.searchTerm },
                        timeout: 10000,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    console.log('Search API Response:', response.data);
                    this.artists = response.data || [];
                    this.showDropdown = true;
                } catch (error) {
                    console.error('Error searching artists:', error);
                    if (error.response) {
                        console.error('Response status:', error.response.status);
                        console.error('Response data:', error.response.data);
                    }
                    this.artists = [];
                    this.showDropdown = false;
                } finally {
                    this.loading = false;
                }
            },
            
            selectArtist(artist) {
                console.log('Selecting artist:', artist);
                this.selectedArtistId = artist.id;
                this.selectedArtistName = artist.name;
                this.searchTerm = artist.name;
                this.hideDropdown();
                
                // Update the main filter and submit
                const mainComponent = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
                if (mainComponent) {
                    mainComponent.filters.artist = artist.id;
                    setTimeout(() => {
                        mainComponent.submitForm();
                    }, 100);
                }
            },
            
            clearSelection() {
                console.log('Clearing artist selection');
                this.selectedArtistId = '';
                this.selectedArtistName = '';
                this.searchTerm = '';
                this.artists = [];
                this.hideDropdown();
                
                // Update the main filter and submit
                const mainComponent = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
                if (mainComponent) {
                    mainComponent.filters.artist = '';
                    setTimeout(() => {
                        mainComponent.submitForm();
                    }, 100);
                }
            },
            
            hideDropdown() {
                this.showDropdown = false;
                this.highlightedIndex = -1;
            },
            
            navigateDown() {
                const maxIndex = this.artists.length - 1;
                if (this.highlightedIndex < maxIndex) {
                    this.highlightedIndex++;
                } else {
                    this.highlightedIndex = -1; // Go to clear option
                }
            },
            
            navigateUp() {
                if (this.highlightedIndex > -1) {
                    this.highlightedIndex--;
                } else {
                    this.highlightedIndex = this.artists.length - 1;
                }
            },
            
            selectHighlighted() {
                if (this.highlightedIndex === -1) {
                    this.clearSelection();
                } else if (this.artists[this.highlightedIndex]) {
                    this.selectArtist(this.artists[this.highlightedIndex]);
                }
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
            console.log('Attempting to load image:', this.imageSrc, 'Attempt:', this.retryCount + 1);
            
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
                    // Retry after a short delay with exponential backoff
                    setTimeout(() => {
                        this.preloadImage();
                    }, 1000 * this.retryCount);
                } else {
                    // All retries failed, show error state
                    this.imageError = true;
                    this.imageLoaded = false;
                    this.imageSrc = '/placeholder/no-image.png';
                    
                    // Try loading the fallback image
                    const fallbackImg = new Image();
                    fallbackImg.onload = () => {
                        this.imageLoaded = true;
                        this.imageError = false;
                    };
                    fallbackImg.onerror = () => {
                        // Even fallback failed, just show error state
                        this.imageError = true;
                        this.imageLoaded = false;
                    };
                    fallbackImg.src = this.imageSrc;
                }
            };
            
            // Add cache busting for retries to avoid cached failures
            const cacheBuster = this.retryCount > 0 ? `?v=${Date.now()}` : '';
            img.src = this.imageSrc + cacheBuster;
        }
    }
}

    // Initialize components when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing components');
        
        Alpine.nextTick(() => {
            const songsComponent = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
            if (songsComponent) {
                songsComponent.loading = false;
                console.log('Songs filter component initialized');
            }
        });
    });

    // Handle browser back/forward navigation
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            const songsComponent = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
            if (songsComponent) {
                songsComponent.loading = false;
            }
        }
    });
</script>