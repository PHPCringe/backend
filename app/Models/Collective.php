<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collective extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'is_profit',
        'description',
        'website',
        'donation_goal',
        'twitter',
        'tags'
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->hasMany(CollectiveTag::class);
    }

    public function members()
    {
        return $this->hasMany(CollectiveMember::class);
    }
}
