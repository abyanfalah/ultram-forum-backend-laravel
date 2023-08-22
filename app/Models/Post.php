<?php

namespace App\Models;

use App\Models\User;
use App\Models\Thread;
use App\Models\PostReaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use stdClass;

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
        $isReactedByUser = $this->postReactions()->where('user_id', auth()->user()->id)->first();

        $result = new stdClass;
        $result->likes = $likes;
        $result->dislikes = $dislikes;

        if ($isReactedByUser) {
            $result->userReaction = $isReactedByUser->is_liking;
        }

        return $result;
    }
}
