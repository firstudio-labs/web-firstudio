<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Models\ChatbotSession;
use App\Services\ChatContentBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function __construct(
        private ChatContentBuilder $contentBuilder
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $apiKey = config('services.openrouter.api_key');

        if (!$apiKey) {
            return response()->json([
                'error' => 'Layanan chatbot belum dikonfigurasi.',
            ], 503);
        }

        $checkAdminOnly = $request->boolean('check_admin_only');

        $rules = [
            'session_token' => 'required|string|max:100',
            'latest_message' => 'nullable|string',
            'check_admin_only' => 'sometimes|boolean',
        ];

        if ($checkAdminOnly) {
            $rules['messages'] = 'nullable|array';
        } else {
            $rules['messages'] = 'required|array|min:1';
            $rules['messages.*.role'] = 'required|string|in:user,assistant,system';
            $rules['messages.*.content'] = 'required|string';
        }

        $validated = $request->validate($rules);

        $session = ChatbotSession::firstOrCreate(
            ['session_token' => $validated['session_token']],
            [
                'user_agent' => Str::limit($request->userAgent() ?? '', 255),
                'ip_address' => $request->ip(),
                'last_activity' => now(),
            ]
        );

        $session->update([
            'user_agent' => Str::limit($request->userAgent() ?? '', 255),
            'ip_address' => $request->ip(),
            'last_activity' => now(),
        ]);

        if (!$checkAdminOnly && !empty($validated['latest_message'])) {
            ChatbotMessage::create([
                'chatbot_session_id' => $session->id,
                'role' => 'user',
                'message' => $validated['latest_message'],
                'is_unread' => false,
            ]);
        }

        $pendingAdminMessages = $session->messages()
            ->where('role', 'admin')
            ->where('is_unread', true)
            ->orderBy('created_at')
            ->get();

        if ($pendingAdminMessages->isNotEmpty()) {
            $session->messages()
                ->whereIn('id', $pendingAdminMessages->pluck('id'))
                ->update(['is_unread' => false]);

            return response()->json([
                'admin_messages' => $pendingAdminMessages->map(function ($message) {
                    return [
                        'content' => $message->message,
                        'created_at' => $message->created_at->toIso8601String(),
                    ];
                }),
            ]);
        }

        if ($checkAdminOnly) {
            return response()->json([
                'admin_messages' => [],
            ]);
        }

        $systemPrompt = [
            'role' => 'system',
            'content' => 'You are Firsty, AI concierge untuk Firstudio. Jawab dalam bahasa Indonesia, maksimal enam kalimat, informatif dan ajak user konsultasi jika perlu.',
        ];

        $history = collect($validated['messages'] ?? [])
            ->map(function (array $message): array {
                return [
                    'role' => $message['role'],
                    'content' => Str::of($message['content'])->limit(1200, '')->value(),
                ];
            })
            ->filter(fn ($message) => in_array($message['role'], ['user', 'assistant', 'system'], true))
            ->values()
            ->toArray();

        $context = $this->contentBuilder->buildContext();

        $payloadMessages = [$systemPrompt];

        if ($context) {
            $payloadMessages[] = [
                'role' => 'system',
                'content' => "Ringkasan konten resmi Firstudio:\n{$context}",
            ];
        }

        $payloadMessages = array_merge($payloadMessages, array_slice($history, -8));

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name', 'Firstudio'),
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'mistralai/mistral-7b-instruct',
                'messages' => $payloadMessages,
                'max_tokens' => 400,
                'temperature' => 0.4,
            ]);
        } catch (\Throwable $th) {
            report($th);

            return response()->json([
                'error' => 'Tidak dapat terhubung ke layanan AI. Coba lagi beberapa saat.',
            ], 500);
        }

        if (!$response->successful()) {
            return response()->json([
                'error' => 'AI tidak merespons. Silakan coba lagi.',
            ], $response->status());
        }

        $reply = data_get($response->json(), 'choices.0.message.content');

        if (!$reply) {
            return response()->json([
                'error' => 'Jawaban AI kosong.',
            ], 422);
        }

        ChatbotMessage::create([
            'chatbot_session_id' => $session->id,
            'role' => 'assistant',
            'message' => trim($reply),
            'is_unread' => false,
        ]);

        return response()->json([
            'reply' => trim($reply),
        ]);
    }
}
