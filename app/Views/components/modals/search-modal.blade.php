<div class="modal fade" id="searchModal" tabindex="-1" x-headers="{'Custom-Header': 'Shmow-zow!'}" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">{{ $modal_title ?? 'Search Record' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form @isset($x_target) x-target="{{ $x_target }}" @endisset method="GET"
                action="<?= base_url($url) ?>">
                <div class="modal-body">
                    {!! $slot !!}
                </div>
                <div class="modal-footer">
                    <a href="{{ base_url($url) }}" class="btn btn-secondary">Clear Search</a>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
