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
</div>