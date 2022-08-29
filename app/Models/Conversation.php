<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id'
    ];

    public function participant() {
        return $this->belongsToMany(User::class, Participant::class);
    }

    public function message() {
        return $this->belongsToMany(User::class, Message::class)->withPivot('content')->withTimestamps(); 
    }

    public function getLastMessage() {
        return $this->message()->orderByPivot('created_at', 'asc');
    }
}

