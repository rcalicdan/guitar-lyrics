<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function getUsers(): Builder
    {
        $searchId    = request()->getGet('id');
        $searchName  = trim(request()->getGet('name')  ?? '');
        $searchEmail = trim(request()->getGet('email') ?? '');

        $users = User::query()
            ->select(['id', 'first_name', 'last_name', 'email', 'role'])
            ->when($searchId, function ($query, $id) {
                $query->where('id', $id);
            })
            ->when($searchEmail, function ($query, $email) {
                $query->where('email', 'like', "%{$email}%");
            })
            ->when($searchName, function ($query, $name) {
                $query->whereFullName($name);
            })
            ->oldest('id');

        return $users;
    }
}
