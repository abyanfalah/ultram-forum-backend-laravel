<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory;

    protected $with = [
        'participants',
        'otherParty',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class, 'conversation_id');
    }

    public function otherParty()
    {
        // return $this->hasMany(ConversationParticipant::class)->whereNot('user_id', auth()->user()->id);

        return $this->hasManyThrough(User::class, ConversationParticipant::class);
    }

    public static function getUserConversations()
    {
        return Conversation
            ::whereHas(
                'participants',
                function (Builder $query) {
                    $query->where('user_id', auth()->user()->id);
                }
            );
    }


    // i want  to also retrieve the user when getting a conv.
}
