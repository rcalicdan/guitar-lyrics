<?php

namespace App\Observers;

use App\Models\SongCategory;
use App\Models\User;
use Illuminate\Support\Str;

class SongCategoryObserver
{
    public function created(SongCategory $songcategory): void 
    {
       log_message('error', 'SongCategory created: ' . $songcategory->name);
    }
}
