<?php

namespace App\AI;

use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class Assistant
{
    private string $systemMessage = '';
    private string $csl_path = '';
    protected array $messages = [];

    public function systemMessage(string $message = null): static
    {
        $this->systemMessage = config('openai.prompt.prompt_text');
        $this->csl_path = Storage::disk('local')->get(config('openai.prompt.csl_path'));

        \Log::info($this->systemMessage . $this->csl_path);

        if (!is_null($message)) {
            $this->systemMessage = $message;
        }

        $this->messages[] = [
            'role' => 'system',
            'content' => $this->systemMessage
        ];

        $this->setSession();

        return $this;
    }

    public function send(string $message): ?string
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        $response = OpenAI::chat()->create([
            "model"    => "gpt-3.5-turbo",
            'max_tokens' => 4096,
            "messages" => $this->messages
        ])->choices[0]->message->content;

        if ($response) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response,
            ];
        }

        $this->setSession();

        return $response;
    }

    public function reply(string $message): ?string
    {
        $this->setSession();

        return $this->send($message);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages(string $role, string $message): void
    {
        $this->messages[] = [
            'role' => $role,
            'content' => $message,
        ];
    }

    public function setSession(): void
    {
        if (!session('messages')) {
            session(['messages' => json_encode($this->messages, JSON_PRETTY_PRINT)]);
        } else {
            $sess = json_decode(session('messages'), true);
            $merge = array_merge($sess, $this->messages);

            // Remove duplicates from the multidimensional array
            $unique = array_map('unserialize', array_unique(array_map('serialize', $merge)));

            session(['messages' => json_encode($unique, JSON_PRETTY_PRINT)]);
            $this->messages = json_decode(session('messages'), true);
        }
    }
}
