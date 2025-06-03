<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Rcalicdan\Ci4Larabridge\Models\Model;

class Song extends Model
{
    protected $table = 'songs';
    protected $fillable = ['title', 'content', 'song_category_id', 'artist_id', 'user_id', 'slug', 'image_path', 'is_published'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function songCategory(): BelongsTo
    {
        return $this->belongsTo(SongCategory::class);
    }

    /**
     * Song belongs to many users through comments
     */
    public function commenters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comments')
            ->using(Comments::class)
            ->withPivot(['id', 'content', 'created_at', 'updated_at'])
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comments::class)->whereNull('parent_id')->with('user', 'replies');
    }

    public function allComments()
    {
        return $this->hasMany(Comments::class);
    }

    /**
     * Get comments collection
     */
    public function getCommentsAttribute()
    {
        return Comments::where('song_id', $this->id)->with('user')->get();
    }

    public function getCategoryNameAttribute(): string
    {
        return $this->songCategory->name ?? 'Unknown';
    }

    public function getArtistNameAttribute(): string
    {
        return $this->artist->name ?? 'Unknown';
    }

    /**
     * Get comments count
     */
    public function getCommentsCountAttribute(): int
    {
        return Comments::where('song_id', $this->id)->count();
    }
}
