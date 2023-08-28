<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Thread;
use App\Models\Follower;
use App\Models\PostReaction;
use App\Models\ThreadReaction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

    protected $with = [
        // 'isFollowed'
    ];

    protected $withCount = [
        'followees',
        'followers',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function threadReactions(): HasMany
    {
        return $this->hasMany(ThreadReaction::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function postReactions(): HasMany
    {
        return $this->hasMany(PostReaction::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class, 'followee_id');
    }

    public function followees()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }

    public function isFollowed()
    {
        return $this->hasOne(Follower::class)->where('follower_id', auth()->user()->id)->first();
    }
}
