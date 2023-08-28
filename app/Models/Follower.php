<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model
{
    use HasFactory;


    public function followee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'followee_id');
    }

    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
