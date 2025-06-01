<div class="card mt-2">
    <!-- Card Header -->
    @component('x-partials.card-header', ['header_name' => 'Song List'])
        <div class="col-6 d-grid">
            @include('components.utils.search-modal-button', [
                'button_name' => 'Search Songs',
                'class' => 'w-100',
            ])
        </div>
        <div class="col-6 d-6">
            @include('components.utils.create-button', [
                'route' => 'songs.create',
                'button_name' => 'Publish New Song',
                'class' => 'w-100',
            ])
        </div>
    @endcomponent

    <!-- Card Body -->
    <div class="card-body">
        @if ($songs->isEmpty())
            <p class="text-center">No Songs found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($songs as $song)
                            <tr>
                                <td>{{ $song->id }}</td>
                                <td>{{ $song->title }}</td>
                                <td>{{ $song->artist_name }}</td>
                                <td>{{ $song->category_name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @include('components.utils.view-button', [
                                            'route' => 'songs.show',
                                            'id' => $song->slug,
                                        ])
                                        @can('update', $song)
                                            @include('components.utils.edit-button', [
                                                'route' => 'songs.edit',
                                                'id' => $song->slug,
                                            ])
                                        @endcan
                                        @can('delete', $song)
                                            @include('components.utils.delete-button', [
                                                'route' => 'songs.delete',
                                                'id' => $song->slug,
                                                'itemName' => 'song',
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
            {!! $songs->links() !!}
        </div>
    </div>
</div>

@component('x-modals.search-modal', ['modal_title' => 'Search Song', 'url' => 'songs'])
    <div class="mb-3">
        <label for="searchId" class="form-label">Song Name</label>
        <input type="text" class="form-control" id="searchId" name="song_name" value="{{ get('song_name') }}"
            placeholder="Exact song name">
    </div>
    <div class="mb-3">
        <label for="searchId" class="form-label">Artist Name</label>
        <input type="text" class="form-control" id="searchId" name="id" value="{{ get('artist_name') }}"
            placeholder="Exact song ID">
    </div>

    {{-- <div class="mb-3">
        <label for="searchName" class="form-label">Song Category</label>
        <input type="text" class="form-control" id="searchName" name="name" value="{{ get('name') }}"
            placeholder="Artist Name">
    </div> --}}
@endcomponent
