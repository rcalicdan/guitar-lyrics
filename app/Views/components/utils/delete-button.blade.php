<form action="{{ route_to($route, $id) }}" method="POST" class="d-inline {{ $class ?? '' }}"
    onsubmit="return confirm('Are you sure you want to delete this {{ $itemName ?? 'item' }}?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" title="{{ $buttonTitle ?? 'Delete' }}">
        <i class="bi bi-trash"></i>
        {{ $slot ?? '' }}
    </button>
</form>
