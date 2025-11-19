<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatbotFaqController extends Controller
{
    public function index(): View
    {
        $faqs = ChatbotFaq::query()
            ->latest()
            ->paginate(15);

        return view('page_admin.chatbot.faq.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('page_admin.chatbot.faq.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'sometimes|boolean',
        ]);

        ChatbotFaq::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.chatbot.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(ChatbotFaq $faq): View
    {
        return view('page_admin.chatbot.faq.edit', compact('faq'));
    }

    public function update(Request $request, ChatbotFaq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $faq->update([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.chatbot.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(ChatbotFaq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()
            ->route('admin.chatbot.faq.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}

