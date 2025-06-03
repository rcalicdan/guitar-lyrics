<style>
    /* Comments Section Styles */
    .views-counter {
        font-weight: 500;
    }

    .views-counter i {
        opacity: 0.8;
    }

    .placeholder-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, transparent 37%, transparent 63%, #f0f0f0 75%);
        background-size: 400% 100%;
        animation: shimmer 1.5s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .song-meta-header .text-white-75 {
        color: rgba(255, 255, 255, 0.75) !important;
    }

    .song-meta-header .text-white-50 {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    .comments-section {
        background: #f8f9fa;
        padding: 3rem 0;
    }

    .comments-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .comment-form textarea {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: border-color 0.3s ease;
    }

    .comment-form textarea:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .comment-item {
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem 0;
    }

    .comment-item:last-child {
        border-bottom: none;
    }

    .comment-content {
        margin-bottom: 1rem;
    }

    .comment-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .comment-meta {
        flex: 1;
    }

    .comment-actions {
        display: flex;
        gap: 0.5rem;
    }

    .comment-text {
        margin-left: 3rem;
        margin-bottom: 1rem;
    }

    .comment-footer {
        margin-left: 3rem;
    }

    .reply-form {
        margin-left: 3rem;
        margin-top: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .edit-comment-form {
        margin-left: 3rem;
        margin-bottom: 1rem;
    }

    .replies {
        margin-left: 3rem;
        margin-top: 1rem;
        border-left: 3px solid #e9ecef;
        padding-left: 1rem;
    }

    .reply-item {
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .reply-item:last-child {
        border-bottom: none;
    }

    .reply-item .comment-header {
        margin-bottom: 0.5rem;
    }

    .reply-item .comment-avatar {
        width: 32px;
        height: 32px;
    }

    .reply-item .comment-text {
        margin-left: 2.5rem;
        margin-bottom: 0;
    }

    .reply-item .comment-actions {
        margin-left: auto;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .comment-text,
        .comment-footer,
        .reply-form,
        .edit-comment-form {
            margin-left: 0;
        }

        .replies {
            margin-left: 1rem;
            padding-left: 0.5rem;
        }

        .reply-item .comment-text {
            margin-left: 0;
        }
    }

    .artist-dropdown {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        background: white;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .artist-option {
        transition: background-color 0.15s ease-in-out;
        cursor: pointer;
    }

    .artist-option:hover,
    .artist-option.highlighted {
        background-color: #f8f9fa;
    }

    .artist-option.selected {
        background-color: #e7f3ff;
        color: #0066cc;
    }

    .artist-option:not(:last-child) {
        border-bottom: 1px solid #f1f3f4;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Style the search input when an artist is selected */
    .artist-selected {
        background-color: #e7f3ff;
        border-color: #0066cc;
    }

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
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
    }

    .song-image:hover {
        transform: translateY(-5px);
    }

    .image-loading-placeholder {
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
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
        0% {
            opacity: 0.5;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0.5;
        }
    }

    .image-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .btn-favorite {
        background: rgba(255, 255, 255, 0.9);
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
        color: rgba(255, 255, 255, 0.75);
    }

    .header-actions {
        margin-top: 1.5rem;
    }

    .song-meta-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-top: -2rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .floating-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
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
        background: rgba(0, 0, 0, 0.8);
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