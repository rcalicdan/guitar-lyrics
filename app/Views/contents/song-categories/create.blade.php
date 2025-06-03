<div class="card-body mt-0 pt-0">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New Song Categories</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route_to('songs.categories.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="Enter Category Name" value="{{ old('name') }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create Category</button>
                @include('components.utils.cancel-button', ['route' => 'songs.categories.index'])
            </form>
        </div>
    </div>
</div>
