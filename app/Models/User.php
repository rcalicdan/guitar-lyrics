<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'remember_token',
        'email_verification_token',
        'password_reset_token',
        'image_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
        'password_reset_token',
    ];

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

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    public function commentedSongs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class, 'comments')
            ->using(Comments::class)
            ->withPivot(['id', 'content', 'created_at', 'updated_at'])
            ->withTimestamps();
    }

    public function comments()
    {
        return Comments::where('user_id', $this->id);
    }

    public function getCommentsAttribute()
    {
        return Comments::where('user_id', $this->id)->with('song')->get();
    }
}
