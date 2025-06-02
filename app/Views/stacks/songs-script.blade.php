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

document.addEventListener('DOMContentLoaded', function() {
    Alpine.nextTick(() => {
        const component = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
        if (component) {
            component.loading = false;
        }
    });
});

window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        const component = Alpine.$data(document.querySelector('[x-data*="songsFilter"]'));
        if (component) {
            component.loading = false;
        }
    }
});
</script>