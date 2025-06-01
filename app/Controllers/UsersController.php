<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRoles;
use App\Models\User;
use App\Requests\User\StoreUserRequest;
use App\Requests\User\UpdateUserRequest;
use App\Services\UserService;

class UsersController extends BaseController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->userService->getUsers()->paginateWithQueryString(20);

        return blade_view('contents.user.index', ['users' => $users,]);
    }

    public function editPage($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        return blade_view('contents.user.index', [
            'user' => $user,
        ]);
    }

    public function update($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->update(UpdateUserRequest::validateRequest());

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $addingUser = true;
        $validRoles = UserRoles::getRolesExcept([UserRoles::ADMIN->value]);

        return blade_view('contents.user.index', [
            'addingUser' => $addingUser,
            'validRoles' => $validRoles,
        ]);
    }


    public function store()
    {
        $this->authorize('create', User::class);
        User::create(StoreUserRequest::validateRequest());

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }
}
