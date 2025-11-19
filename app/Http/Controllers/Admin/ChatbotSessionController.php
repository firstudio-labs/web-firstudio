<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Models\ChatbotSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatbotSessionController extends Controller
{
    public function index(Request $request): View
    {
        $sessions = ChatbotSession::query()
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('role', 'user')->where('is_unread', true);
            }])
            ->latest('last_activity')
            ->paginate(20);

        return view('page_admin.chatbot.sessions.index', compact('sessions'));
    }

    public function show(ChatbotSession $chatbotSession): View
    {
        $chatbotSession->load(['messages' => function ($query) {
            $query->latest('created_at');
        }]);

        $chatbotSession->messages()
            ->where('role', 'user')
            ->where('is_unread', true)
            ->update(['is_unread' => false]);

        return view('page_admin.chatbot.sessions.show', [
            'session' => $chatbotSession,
        ]);
    }

    public function respond(Request $request, ChatbotSession $chatbotSession): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        ChatbotMessage::create([
            'chatbot_session_id' => $chatbotSession->id,
            'role' => 'admin',
            'message' => $validated['message'],
            'is_unread' => true,
        ]);

        $chatbotSession->update(['last_activity' => now()]);

        return back()->with('success', 'Balasan admin dikirim ke pengguna.');
    }
}

