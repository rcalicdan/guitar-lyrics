<?php

namespace App\Models;

use Rcalicdan\Ci4Larabridge\Models\Model;

class SongCategory extends Model
{
    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'song_categories';

    protected $fillable = [
        'name',
    ];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
