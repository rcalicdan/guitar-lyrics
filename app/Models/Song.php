<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rcalicdan\Ci4Larabridge\Models\Model;

class Song extends Model
{
    /**
     * The table associated with the model
     * 
     * @var string
     */
    protected $table = 'songs';
    protected $fillable = ['title', 'content', 'song_category_id', 'artist_id', 'user_id', 'slug', 'image_path', 'is_published',];

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

    public function getCategoryNameAttribute(): string
    {
        return $this->songCategory->name ?? 'Unknown';
    }

    public function getArtistNameAttribute(): string
    {
        return $this->artist->name ?? 'Unknown';
    }
}
