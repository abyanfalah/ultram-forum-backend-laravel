<?php

namespace App\Models;

use stdClass;
use App\Models\User;
use App\Models\Thread;
use App\Models\PostReaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = [
        'user',
        'postReplies',
        'myReaction'
    ];

    protected $withCount = [
        'likes',
        'dislikes',
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

    public function topParentPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'top_parent_post_id');
    }

    public function parentPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_post_id');
    }

    public function postReplies(): HasMany
    {
        return $this->hasMany(Post::class, 'parent_post_id');
    }

    public function getReactionsCount()
    {
        $likes = $this->hasMany(PostReaction::class)->where('is_liking', true)->count();
        $dislikes = $this->hasMany(PostReaction::class)->where('is_liking', false)->count();

        $result = new stdClass;
        $result->likes_count = $likes;
        $result->dislikes_count = $dislikes;
        $result->my_reaction = $this->myReaction()->first();


        return $result;
    }


    public function likes()
    {
        return $this->hasMany(PostReaction::class)->where('is_liking', true);
    }

    public function dislikes()
    {
        return $this->hasMany(PostReaction::class)->where('is_liking', false);
    }

    public function myReaction()
    {
        return $this->hasOne(PostReaction::class)->where('user_id', auth()->user()->id);
    }
}
