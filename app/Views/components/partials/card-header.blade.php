<div class="card-header">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
        <h3 class="card-title mb-2 mb-sm-0">{{ $header_name ?? 'Table List' }}</h3>
        <div class="card-tools d-grid gap-2 d-sm-flex">
            <div class="row g-2 w-100">
                {!! $slot !!}
            </div>
        </div>
    </div>
</div>
