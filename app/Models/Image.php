<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'imageable_type',
        'imageable_id',
    ];

    protected function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
