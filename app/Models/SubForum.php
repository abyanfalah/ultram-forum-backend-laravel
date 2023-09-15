<?php

namespace App\Models;

use App\Models\User;
use App\Models\Thread;
use App\Models\SubForumMod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SubForum extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $withCount = [
        'threads',
        'members',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The members that belong to the SubForum
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'sub_forum_members', 'sub_forum_id', 'user_id');
    }

    public function mods(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, SubForumMod::class);
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function isJoined()
    {
        return $this->belongsToMany(User::class, 'sub_forum_members', 'sub_forum_id', 'user_id')->where('user_id', Auth::id())->exists();
    }

    public function withJoinDetail()
    {
        $this->is_joined = $this->isJoined();
        return $this;
    }
}
