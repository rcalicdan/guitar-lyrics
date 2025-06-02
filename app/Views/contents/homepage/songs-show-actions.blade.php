<!-- Floating Action Buttons -->
<div class="floating-actions" x-show="showFloatingActions" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-full"
    x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-full">

    <!-- Scroll to Top -->
    <button @click="scrollToTop()" class="floating-btn floating-btn-secondary" x-show="showScrollTop" x-transition
        title="Scroll to Top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Toggle Auto Scroll -->
    <button @click="toggleAutoScroll()" class="floating-btn"
        :class="autoScrolling ? 'floating-btn-warning' : 'floating-btn-primary'"
        :title="autoScrolling ? 'Pause Auto Scroll' : 'Start Auto Scroll'">
        <i :class="autoScrolling ? 'fas fa-pause' : 'fas fa-play'"></i>
    </button>

    <!-- Share -->
    <button @click="shareContent()" class="floating-btn floating-btn-info" title="Share Song">
        <i class="fas fa-share"></i>
    </button>

    <!-- Print -->
    <button @click="printContent()" class="floating-btn floating-btn-success" title="Print Song">
        <i class="fas fa-print"></i>
    </button>
</div>

<!-- Share Modal -->
<div class="modal fade" x-ref="shareModal" tabindex="-1" x-show="showShareModal"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share "{{ $song->title }}"</h5>
                <button type="button" @click="closeShareModal()" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Copy Link:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" :value="shareUrl" x-ref="shareUrlInput" readonly>
                        <button @click="copyToClipboard()" class="btn btn-outline-secondary" :disabled="copying">
                            <i :class="copying ? 'fas fa-spinner fa-spin' : 'fas fa-copy'" class="me-2"></i>
                            <span x-text="copying ? 'Copying...' : (copied ? 'Copied!' : 'Copy')"></span>
                        </button>
                    </div>
                </div>

                <div class="social-share">
                    <p class="mb-2">Share on social media:</p>
                    <div class="d-flex gap-2">
                        <a :href="socialLinks.facebook" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fab fa-facebook-f me-2"></i>Facebook
                        </a>
                        <a :href="socialLinks.twitter" target="_blank" class="btn btn-info btn-sm">
                            <i class="fab fa-twitter me-2"></i>Twitter
                        </a>
                        <a :href="socialLinks.whatsapp" target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen overlay -->
<div x-show="isFullscreen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" class="fullscreen-overlay" @keydown.escape="exitFullscreen()">
    <div class="fullscreen-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="text-white mb-0">{{ $song->title }} - {{ $song->artist_name }}</h4>
            <button @click="exitFullscreen()" class="btn btn-outline-light btn-sm">
                <i class="fas fa-times me-2"></i>Exit Fullscreen
            </button>
        </div>
    </div>
    <div class="fullscreen-content">
        <div class="chord-content font-size-large" x-html="$refs.chordContent.innerHTML"></div>
    </div>
</div>