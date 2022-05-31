<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function participant() {
        return $this->belongsToMany(User::class, Participant::class, 'user_id');
    }
}
