<?php

namespace App\AI;

use Illuminate\Support\Facades\Storage;
use OpenAI\Client;
use OpenAI\Laravel\Facades\OpenAI;

class Chat
{
    protected array $messages = [];

    public function systemMessage(string $message): static
    {
        $this->messages[] = [
            'role' => 'system',
            'content' => $message
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
