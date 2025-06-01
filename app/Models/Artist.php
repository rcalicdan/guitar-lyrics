<?php

namespace App\Models;

use Rcalicdan\Ci4Larabridge\Models\Model;

class Artist extends Model
{
    /**
     * The table associated with the model
     * 
     * @var string
     */
    protected $table = 'artists';

    protected $fillable = [
        'name',
        'about',
        'image_path',
    ];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
