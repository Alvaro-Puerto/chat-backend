<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens ,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contact() {
        return $this->belongsToMany(User::class, Contact::class, 'user_id', 'user_guess', 'id', 'id');
    }

    public function conversation() {
        return $this->belongsToMany(Conversation::class, Participant::class);
    }

    public function getConversationWithUser($id) {
        $user = User::find(Auth::user()->id);
        return $user->conversation()->whereHas('participant', function ($query) use ($id) {
            $query->where('users.id', $id);
        })->first();
    }
    
}
