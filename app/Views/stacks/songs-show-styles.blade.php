<style>
.song-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    position: relative;
    overflow: hidden;
}

.song-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.song-image-wrapper {
    position: relative;
    display: inline-block;
}

.song-image {
    width: 100%;
    max-width: 300px;
    height: 300px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    transition: transform 0.3s ease;
}

.song-image:hover {
    transform: translateY(-5px);
}

.image-loading-placeholder {
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.placeholder-shimmer {
    animation: shimmer 1.5s infinite linear;
}

@keyframes shimmer {
    0% { opacity: 0.5; }
    50% { opacity: 1; }
    100% { opacity: 0.5; }
}

.image-overlay {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.btn-favorite {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #666;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-favorite:hover,
.btn-favorite.active {
    background: #dc3545;
    color: white;
    transform: scale(1.1);
}

.song-meta-header .artist-name {
    font-weight: 600;
}

.text-white-75 {
    color: rgba(255,255,255,0.75);
}

.header-actions {
    margin-top: 1.5rem;
}

.song-meta-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-top: -2rem;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    position: relative;
    z-index: 10;
}

.detail-item {
    margin-bottom: 1rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-item:last-child {
    border-bottom: none;
}

.content-controls {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
}

.controls-group {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: flex-end;
    align-items: center;
}

.control-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.control-label {
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0;
    color: #666;
}

.content-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.chord-content {
    font-family: 'Courier New', monospace;
    line-height: 1.8;
    white-space: pre-wrap;
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 12px;
    border-left: 4px solid #667eea;
    transition: font-size 0.3s ease;
}

.chord-content.font-size-small {
    font-size: 0.9rem;
}

.chord-content.font-size-medium {
    font-size: 1.1rem;
}

.chord-content.font-size-large {
    font-size: 1.3rem;
}

.related-songs {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 2rem;
}

.related-song-link {
    text-decoration: none;
    color: inherit;
}

.related-song-card {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.related-song-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.related-song-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.floating-actions {
    position: fixed;
    right: 2rem;
    bottom: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    z-index: 1000;
}

.floating-btn {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    cursor: pointer;
}

.floating-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

.floating-btn-primary {
    background: #667eea;
    color: white;
}

.floating-btn-secondary {
    background: #6c757d;
    color: white;
}

.floating-btn-success {
    background: #28a745;
    color: white;
}

.floating-btn-info {
    background: #17a2b8;
    color: white;
}

.floating-btn-warning {
    background: #ffc107;
    color: #212529;
}

.fullscreen-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #1a1a1a;
    z-index: 9999;
    display: flex;
    flex-direction: column;
}

.fullscreen-header {
    background: rgba(0,0,0,0.8);
    padding: 1rem 2rem;
    backdrop-filter: blur(10px);
}

.fullscreen-content {
    flex: 1;
    overflow-y: auto;
    padding: 2rem;
}

.fullscreen-content .chord-content {
    background: #2d2d2d;
    color: #f8f9fa;
    border-left-color: #667eea;
    max-width: none;
}

.social-share .btn {
    flex: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .floating-actions {
        right: 1rem;
        bottom: 1rem;
    }
    
    .floating-btn {
        width: 3rem;
        height: 3rem;
        font-size: 1rem;
    }
    
    .controls-group {
        justify-content: center;
    }
    
    .control-item {
        flex-direction: column;
        text-align: center;
        gap: 0.25rem;
    }
}

/* Print styles */
@media print {
    .song-header,
    .floating-actions,
    .content-controls,
    .action-buttons {
        display: none !important;
    }
    
    .song-meta-card {
        margin-top: 0;
        box-shadow: none;
        border: 1px solid #ddd;
    }
    
    .chord-content {
        background: white !important;
        color: black !important;
        border: 1px solid #ddd;
        font-size: 12pt !important;
    }
}
</style>