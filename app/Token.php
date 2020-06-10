<?php

namespace App;

use App\Mail\TokenMail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Token extends Model
{   
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateFor(User $user)
    {
        return static::create([
            'token' => Str::random(60),
            'user_id' => $user->id,
        ]);
    }

    public function sendByEmail()
    {  
        Mail::to($this->user)->send(new TokenMail($this));
    }
}
