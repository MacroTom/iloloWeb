<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function from()
    {
        return User::find($this->from_id);
    }

    public function to()
    {
        return User::find($this->to_id);
    }

    public function advert()
    {
        return Advert::find($this->advert_id);
    }
}
