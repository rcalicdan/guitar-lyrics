<?php

namespace App\Models;

use Rcalicdan\Ci4Larabridge\Models\Model;

use Rcalicdan\Ci4Larabridge\Traits\Authentication\HasEmailVerification;
use Rcalicdan\Ci4Larabridge\Traits\Authentication\HasPasswordReset;
use Rcalicdan\Ci4Larabridge\Traits\Authentication\HasRememberToken;

class User extends Model
{
    use HasEmailVerification,
        HasPasswordReset,
        HasRememberToken;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'email',
        'password',
        'email_verified_at',
        'image_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
        'password_reset_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
            'password_reset_expires_at' => 'datetime',
            'email_verification_expires_at' => 'datetime',
            'password_reset_created_at' => 'datetime',
        ];
    }

    public function scopeWhereFullName($query, $name)
    {
        $nameParts = explode(' ', $name);
        $firstName = $nameParts[0] ?? '';
        $lastName = end($nameParts) ?? '';

        return $query->where(function ($q) use ($firstName, $lastName) {
            $q->where('first_name', 'like', "%{$firstName}%")
                ->orWhere('last_name', 'like', "%{$lastName}%");
        });
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
