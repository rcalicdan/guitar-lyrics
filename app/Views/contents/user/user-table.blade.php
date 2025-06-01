<div class="card mt-2">
    <!-- Card Header -->
    @component('x-partials.card-header', ['header_name' => 'User List'])
        <div class="col-6 d-grid">
            @include('components.utils.search-modal-button', [
                'route' => 'users.index',
                'button_name' => 'Search Users',
            ])
        </div>
        @can('create', App\Models\User::class)
            <div class="col-6 d-grid">
                @include('components.utils.create-button', [
                    'route' => 'users.create',
                    'button_name' => 'Add New User',
                ])
            </div>
        @endcan
    @endcomponent

    <div class="card-body">
        @if ($users->isEmpty())
            <p class="text-center">No users found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @can('update', $user)
                                            @include('components.utils.edit-button', [
                                                'route' => 'users.edit',
                                                'id' => $user->id,
                                                'itemName' => 'user',
                                            ])
                                        @endcan
                                        @can('delete', $user)
                                            @include('components.utils.delete-button', [
                                                'route' => 'users.delete',
                                                'id' => $user->id,
                                                'itemName' => 'user',
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
    </div>

    <div class="d-flex justify-content-center mt-3">
        {!! $users->links() !!}
    </div>
</div>

@component('x-modals.search-modal', ['modal_title' => 'Search Users', 'url' => 'users'])
    <div class="mb-3">
        <label for="searchId" class="form-label">User ID</label>
        <input type="number" class="form-control" id="searchId" name="id" value="{{ get('id') }}"
            placeholder="Exact user ID">
    </div>

    <div class="mb-3">
        <label for="searchName" class="form-label">Name</label>
        <input type="text" class="form-control" id="searchName" name="name" value="{{ get('name') }}"
            placeholder="First, last, or full name">
    </div>

    <div class="mb-3">
        <label for="searchEmail" class="form-label">Email</label>
        <input type="email" class="form-control" id="searchEmail" name="email" value="{{ get('email') }}"
            placeholder="Email address">
    </div>
@endcomponent
