<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_token',
        'user_agent',
        'ip_address',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(ChatbotMessage::class);
    }
}

