<?php

namespace App\Models;

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\ConversationParticipant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $with = [
        // 'participants',
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
        return $this->belongsToMany(User::class, 'conversation_participants');
    }

    public function otherParty()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->whereNot('users.id', auth()->user()->id);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_participants');
    }


    public static function createNew(array $participantIdList)
    {
        $conversation = new Conversation;
        $conversation->save();

        // set the participants
        foreach ($participantIdList as $participantId) {
            $participant = new ConversationParticipant;
            $participant->user_id = $participantId;
            $participant->conversation_id = $conversation->id;
            $participant->save();
        }

        // need to re-retrieve to include eagerloaded prarticipants
        $conversation = Conversation::find($conversation->id);
        return $conversation;
    }

    public function isMyConversation()
    {
        return $this->participants()->where('user_id', Auth::id())->exists();
    }
}
