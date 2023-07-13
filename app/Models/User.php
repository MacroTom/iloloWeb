<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'google_id',
        'facebook_id',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'website_link',
        'subscriptions',
        'password',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn($value) => ["user", "admin"][$value]
        );
    }

    public function adverts(): HasMany
    {
        return $this->hasMany(Advert::class);
    }

    public function advertBelongsToUser($id){
        $adverts = $this->adverts;
        if($adverts){
            if($adverts->where('id', $id)->count()){
                return true;
            }
        }
        return false;
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class)->latest();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscriptions(){
        return $this->subscriptions->where('status', 'active');
    }

    public function hasSubscriptionInCategory($category){
        $active = $this->activeSubscriptions();
        if($active){
            $subs = $active->map(function($sub){
                return $sub->plan->category_type;
            });
            if(in_array($category,$subs->toArray())){
                return true;
            }
            return false;
        }
    }

    public function getSubsciptionInCategory($category){
        if($this->hasSubscriptionInCategory($category)){
            return $this->activeSubscriptions()->first();
        }
        return false;
    }

    public function getActiveAdsInCategory($category){
        $this->adverts->where('category_id', $category)->where('status', 'active');
    }

    public function canShowLinks(){
        $active = $this->activeSubscriptions();
        if($active){
            $subs = $active->map(function($sub){
                return $sub->plan->properties->links;
            });
            if(in_array(true,$subs->toArray())){
                return true;
            }
            return false;
        }
        return false;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // public function showLinks($category){
    //     $result = $this->activeSubscriptions();
    //     if($result){

    //     }
    // }

}
