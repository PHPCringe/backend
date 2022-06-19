<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionType extends Model
{

    protected $fillable = [
        'collective_id',
        'name',
        'description',
        'cost',
        'currency_id',
        'type',
        'is_recurring',
    ];


    use HasFactory;

    public function collective()
    {
        return $this->belongsTo(Collective::class, 'collective_id');
    }
}
