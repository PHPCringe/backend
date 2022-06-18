<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'type',
        'issued_by',
        'currency_id',
        'title',
        'description',
        'amount',
    ];


    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }


    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }


    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }


    public function contributionType()
    {
        return $this->belongsTo(ContributionType::class, 'contribution_type_id');
    }
}
