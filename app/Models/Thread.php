<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\ThreadReaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use stdClass;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = [
        // 'threadReactions',
        // 'likes',
        'user',
        'myReaction'
    ];

    protected $withCount = [
        'likes',
        'dislikes',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the posts for the Thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function threadReactions(): HasMany
    {
        return $this->hasMany(ThreadReaction::class);
    }

    public function getReactionsCount()
    {
        $likes = $this->hasMany(ThreadReaction::class)->where('is_liking', true)->count();
        $dislikes = $this->hasMany(ThreadReaction::class)->where('is_liking', false)->count();

        $result = new stdClass;
        $result->likes_count = $likes;
        $result->dislikes_count = $dislikes;
        $result->my_reaction = $this->myReaction()->first();


        return $result;
    }

    public function likes()
    {
        return $this->hasMany(ThreadReaction::class)->where('is_liking', true);
    }

    public function dislikes()
    {
        return $this->hasMany(ThreadReaction::class)->where('is_liking', false);
    }

    public function myReaction()
    {
        return $this->hasOne(ThreadReaction::class)->where('user_id', auth()->user()->id);
    }


    public function parentPosts()
    {
        return Post
            ::where('thread_id', $this->id)
            ->where('parent_post_id', null);
    }
}
