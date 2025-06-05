<?php

namespace App\Models;

use Rcalicdan\Ci4Larabridge\Models\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'content',
        'name',
        'email',
    ];
}
