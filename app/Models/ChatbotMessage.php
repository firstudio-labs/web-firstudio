<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chatbot_session_id',
        'role',
        'message',
        'is_unread',
    ];

    protected $casts = [
        'is_unread' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(ChatbotSession::class, 'chatbot_session_id');
    }
}

