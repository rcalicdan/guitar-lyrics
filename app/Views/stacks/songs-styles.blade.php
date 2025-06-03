<style>
.songs-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0 2rem;
}

.filter-section {
    background: #f8f9fa;
    padding: 2rem 0;
    border-bottom: 1px solid #dee2e6;
}

.filter-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.song-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.song-card:hover, .song-card.hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.song-image-container {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.song-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.song-card:hover .song-image {
    transform: scale(1.05);
}

.image-placeholder {
    width: 100%;
    height: 200px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.placeholder-content {
    text-align: center;
}

.song-content {
    padding: 1.5rem;
}

.song-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.song-artist {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

.song-category {
    background: #e9ecef;
    color: #495057;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    display: inline-block;
    margin-bottom: 1rem;
}

.search-box {
    border-radius: 25px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.filter-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.results-info {
    color: rgba(255,255,255,0.9);
    font-size: 0.95rem;
}

.pagination-wrapper {
    padding: 3rem 0;
}

.no-results {
    text-align: center;
    padding: 4rem 0;
    color: #6c757d;
}

.clear-filters {
    color: #dc3545;
    text-decoration: none;
    font-size: 0.9rem;
    border: none;
    background: none;
    cursor: pointer;
}

.clear-filters:hover {
    text-decoration: underline;
}

/* Alpine.js transitions */
[x-cloak] {
    display: none !important;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}

/* Views overlay badge on image */
.views-overlay-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.song-card:hover .views-overlay-badge {
    opacity: 1;
}

.views-overlay-badge .badge {
    font-size: 0.75rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

/* Song stats styling */
.song-stats {
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #e9ecef;
}

.song-stats small {
    font-size: 0.75rem;
    line-height: 1.2;
}

.song-meta-info {
    margin-bottom: 15px;
}

.song-category {
    display: inline-block;
    background: #f8f9fa;
    color: #495057;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Enhanced song card styling */
.song-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.song-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.song-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.song-content {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.song-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #212529;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.song-artist {
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 8px;
}

.btn-custom {
    margin-top: auto;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
}

@media (max-width: 768px) {
    .song-stats small {
        flex-direction: column;
        gap: 4px;
    }
    
    .views-overlay-badge {
        opacity: 1; /* Always show on mobile */
    }
}
</style>