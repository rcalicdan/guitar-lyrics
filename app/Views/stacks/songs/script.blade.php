@push('custom-scripts')
    <script>
        function artistSearchDropdown() {
            return {
                searchTerm: '',
                artists: [],
                selectedArtist: null,
                showDropdown: false,
                loading: false,
                searchTimeout: null,

                searchArtists() {
                    if (this.searchTimeout) {
                        clearTimeout(this.searchTimeout);
                    }

                    if (this.searchTerm.length < 2) {
                        this.artists = [];
                        this.showDropdown = false;
                        return;
                    }

                    this.searchTimeout = setTimeout(() => {
                        this.performSearch();
                    }, 300);
                },

                async performSearch() {
                    this.loading = true;
                    this.showDropdown = true;

                    try {
                        const response = await axios.get('/api/songs/artists/search', {
                            params: {
                                term: this.searchTerm
                            }
                        });

                        this.artists = response.data;
                    } catch (error) {
                        console.error('Error searching artists:', error);
                        this.artists = [];

                        if (error.response) {
                            console.error('Server error:', error.response.data);
                        }
                    } finally {
                        this.loading = false;
                    }
                },

                selectArtist(artist) {
                    this.selectedArtist = artist;
                    this.searchTerm = artist.name;
                    this.showDropdown = false;
                },

                clearArtistSelection() {
                    this.selectedArtist = null;
                    this.searchTerm = '';
                    this.artists = [];
                    this.showDropdown = false;
                }
            }
        }

        function categorySearchDropdown() {
            return {
                searchTerm: '',
                categories: [],
                selectedCategory: null,
                showDropdown: false,
                loading: false,
                searchTimeout: null,

                searchCategories() {
                    if (this.searchTimeout) {
                        clearTimeout(this.searchTimeout);
                    }

                    if (this.searchTerm.length < 1) {
                        this.categories = [];
                        this.showDropdown = false;
                        return;
                    }

                    this.searchTimeout = setTimeout(() => {
                        this.performSearch();
                    }, 300);
                },

                async performSearch() {
                    this.loading = true;
                    this.showDropdown = true;

                    try {
                        const response = await axios.get('/api/songs/categories/search', {
                            params: {
                                term: this.searchTerm
                            }
                        });

                        this.categories = response.data;
                    } catch (error) {
                        console.error('Error searching categories:', error);
                        this.categories = [];

                        if (error.response) {
                            console.error('Server error:', error.response.data);
                        }
                    } finally {
                        this.loading = false;
                    }
                },

                selectCategory(category) {
                    this.selectedCategory = category;
                    this.searchTerm = category.name;
                    this.showDropdown = false;
                },

                clearCategorySelection() {
                    this.selectedCategory = null;
                    this.searchTerm = '';
                    this.categories = [];
                    this.showDropdown = false;
                }
            }
        }
    </script>
@endpush