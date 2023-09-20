<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Thread;
use App\Models\Follower;
use App\Models\SubForum;
use App\Models\Conversation;
use App\Models\PostReaction;
use App\Models\ThreadReaction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\ConversationParticipant;
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
        // 'followees',
        // 'followers',
        // 'isFollowed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'profile_pic',
        'cover_pic',
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
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followees()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function isFollowed()
    {
        return $this->hasMany(Follower::class, 'user_id')
            ->where('follower_id', auth()->user()->id)->exists();
    }

    public function isFollowing()
    {
        return $this->hasMany(Follower::class, 'follower_id')
            ->where('user_id', auth()->user()->id)->exists();
    }

    public function conversationParticipations()
    {
        return $this->hasMany(ConversationParticipant::class, 'user_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants');
    }

    public function withFollowDetails()
    {
        $this->followers_count = $this->followers()->count();
        $this->followees_count = $this->followees()->count();
        $this->is_followed = $this->isFollowed();
        $this->is_following = $this->isFollowing();
        return $this;
    }

    public function joinedSubForums()
    {
        return $this->belongsToMany(SubForum::class, 'sub_forum_members', 'user_id', 'sub_forum_id');
    }
}
