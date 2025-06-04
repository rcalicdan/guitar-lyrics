<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Rcalicdan\Ci4Larabridge\Models\Model;

class Comments extends Pivot
{
    protected $table = 'comments';
    protected $fillable = ['content', 'user_id', 'song_id', 'parent_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comments::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comments::class, 'parent_id')->with('user', 'replies');
    }

    public function scopeRootComments($query)
    {
        return $query->whereNull('parent_id');
    }
}