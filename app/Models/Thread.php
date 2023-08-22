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
        'threadReactions',
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
        $likes = $this->threadReactions()->where('is_liking', true)->count();
        $dislikes = $this->threadReactions()->where('is_liking', false)->count();
        $isReactedByUser = $this->threadReactions()->where('user_id', auth()->user()->id)->first();

        $result = new stdClass;
        $result->likes = $likes;
        $result->dislikes = $dislikes;

        if ($isReactedByUser) {
            $result->userReaction = $isReactedByUser->is_liking;
        }

        return $result;
    }

    public function parentPosts()
    {
        return Post
            ::where('thread_id', $this->id)
            ->where('parent_post_id', null);
    }
}
