<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_plan');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    protected function properties(): Attribute
    {
        return new Attribute(
            get: fn($value) => json_decode($value)
        );
    }

    public function max_ads(){
        return $this->properties->count;
    }

    public function autoRenew(){
        return $this->properties->autorenew;
    }

    public function smsAlert(){
        return $this->properties->sms;
    }

    public function badge(){
        return $this->properties->badge;
    }

    public function links(){
        return $this->properties->links;
    }
}
