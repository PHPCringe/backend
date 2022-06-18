<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectiveMember extends Model
{
    protected $fillable = [
        'collective_id',
        'user_id',
        'role'
    ];
    use HasFactory;

    public function collective()
    {
        return $this->belongsTo(Collective::class);
    }
}
