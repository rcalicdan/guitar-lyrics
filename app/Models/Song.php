<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Rcalicdan\Ci4Larabridge\Models\Model;

class Song extends Model
{
    use Auditable;

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

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getFormattedViewsAttribute(): string
    {
        $count = $this->views_count;

        if ($count >= 1000000) {
            return number_format($count / 1000000, 1) . 'M';
        } elseif ($count >= 1000) {
            return number_format($count / 1000, 1) . 'K';
        }

        return number_format($count);
    }

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

    public function getCommentsCountAttribute(): int
    {
        return Comments::where('song_id', $this->id)->count();
    }
}
