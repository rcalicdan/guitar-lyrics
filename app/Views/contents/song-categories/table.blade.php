<div class="card mt-2">
    <!-- Card Header -->
    @component('x-partials.card-header', ['header_name' => 'Song Category List'])
        <div class="col-6">
            @include('components.utils.search-modal-button', [
                'button_name' => 'Search Categories',
                'class' => 'w-100',
            ])
        </div>
        <div class="col-6">
            @can('create', \App\Models\SongCategory::class)
                @include('components.utils.create-button', [
                    'route' => 'songs.categories.create',
                    'button_name' => 'Add New Category',
                    'class' => 'w-100',
                ])
            @endcan
        </div>
    @endcomponent

    <!-- Card Body -->
    <div class="card-body">
        @if ($songCategories->isEmpty())
            <p class="text-center">No Song Categories found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            @if (!auth()->user()->isUser())
                                <th class="text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($songCategories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @can('update', $category)
                                            @include('components.utils.edit-button', [
                                                'route' => 'songs.categories.edit',
                                                'id' => $category->id,
                                            ])
                                        @endcan
                                        @can('update', $category)
                                            @include('components.utils.delete-button', [
                                                'route' => 'songs.categories.delete',
                                                'id' => $category->id,
                                                'itemName' => 'category',
                                            ])
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {!! $songCategories->links() !!}
        </div>
    </div>
</div>

@component('x-modals.search-modal', ['modal_title' => 'Search Category', 'url' => 'song/categories'])
    <div class="mb-3">
        <label for="searchId" class="form-label">Artist ID</label>
        <input type="number" class="form-control" id="searchId" name="id" value="{{ get('id') }}"
            placeholder="Exact category ID">
    </div>

    <div class="mb-3">
        <label for="searchName" class="form-label">Name</label>
        <input type="text" class="form-control" id="searchName" name="name" value="{{ get('name') }}"
            placeholder="Artist Name">
    </div>
@endcomponent
