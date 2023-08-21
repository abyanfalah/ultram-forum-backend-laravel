<?php

namespace App\Models;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = [
        'postReactions',
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postReactions(): HasMany
    {
        return $this->hasMany(PostReaction::class);
    }

    public function getReactionsCount()
    {
        $likes = $this->postReactions()->where('is_liking', true)->count();
        $dislikes = $this->postReactions()->where('is_liking', false)->count();

        return [
            "likes" => $likes,
            "dislikes" => $dislikes,
        ];
    }
}
