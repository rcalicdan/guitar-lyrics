<div class="card mt-2">
    <!-- Card Header -->
    @component('x-partials.card-header', ['header_name' => 'Artist List'])
        <div class="col-6 d-grid">
            @include('components.utils.search-modal-button', [
                'button_name' => 'Search Artist',
            ])
        </div>
        <div class="col-6 d-grid">
            @can('create', App\Models\Artist::class)
                @include('components.utils.create-button', [
                    'route' => 'songs.artists.create',
                    'button_name' => 'Add New Artist',
                ])
            @endcan
        </div>
    @endcomponent

    <!-- Card Body -->
    <div class="card-body">
        @if ($artists->isEmpty())
            <p class="text-center">No Artists found.</p>
        @else
            <div class="table-responsive" id="artists">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($artists as $artist)
                            <tr>
                                <td>{{ $artist->id }}</td>
                                <td>{{ $artist->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @include('components.utils.view-button', [
                                            'route' => 'songs.artists.show',
                                            'id' => $artist->id,
                                        ])
                                        @can('update', $artist)
                                            @include('components.utils.edit-button', [
                                                'route' => 'songs.artists.edit',
                                                'id' => $artist->id,
                                            ])
                                        @endcan
                                        @can('update', $artist)
                                            @include('components.utils.delete-button', [
                                                'route' => 'songs.artists.delete',
                                                'id' => $artist->id,
                                                'itemName' => 'artist',
                                            ])
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {!! $artists->links() !!}
                </div>
            </div>
        @endif


    </div>
</div>

@component('x-modals.search-modal', ['modal_title' => 'Search Artists', 'url' => 'songs/artists',   'x_target' => 'artists'])
    <div class="mb-3">
        <label for="searchId" class="form-label">Artist ID</label>
        <input type="number" class="form-control" id="searchId" name="id" value="{{ get('id') }}"
            placeholder="Exact artists ID">
    </div>

    <div class="mb-3">
        <label for="searchName" class="form-label">Name</label>
        <input type="text" class="form-control" id="searchName" name="name" value="{{ get('name') }}"
            placeholder="Artist Name">
    </div>
@endcomponent
