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
            // Initialize component
            console.log('Songs filter initialized');
        },
        
        submitForm() {
            this.loading = true;
            this.$refs.filterForm.submit();
        },
        
        autoSubmit() {
            // Auto-submit after user stops typing
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

// Handle page load states
document.addEventListener('DOMContentLoaded', function() {
    // Reset loading state when page loads
    Alpine.nextTick(() => {
        const component = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
        if (component) {
            component.loading = false;
        }
    });
});

// Handle browser back/forward navigation
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Page was loaded from cache, reset loading state
        const component = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
        if (component) {
            component.loading = false;
        }
    }
});
</script>