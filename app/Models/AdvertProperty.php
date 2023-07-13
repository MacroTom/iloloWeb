<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertProperty extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'id',
        'advert_id',
        'created_at',
        'updated_at',
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }
}
