<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'category_property');
    }

    public function adverts(): HasMany
    {
        return $this->hasMany(Advert::class);
    }

    public function advertsCount(){
        return $this->adverts()->count();
    }
}
