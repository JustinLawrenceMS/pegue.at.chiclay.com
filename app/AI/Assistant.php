<?php

namespace App\AI;

use OpenAI\Laravel\Facades\OpenAI;

class Assistant
{
    private string $systemMessage = 'You are a library assistant and your job is to
    classify journal citations with MeSH (Medical Subject Headings) based on bibliographic
    citations that the user will provide. The user will copy and paste a citation in APA
    format.  You are going to return a JSON object in the following format:
      {
    "author": [
      {
        "given": "",
        "family": ""
      }
    ],
    "drug_type": "",
    "issue": 0,
    "pages": "",
    "issued": {
      "date-parts": [
        [
          0
        ]
      ]
    },
    "mesh-headings": [],
    "publication": "",
    "title": "",
    "url": "",
    "volume": 0
  }
  Note the field "mesh-headings".  Here you simply add one or more MeSH headings, as a JSON array of strings.
  Use only official MeSH headings for this field, from the National Library of Medicine';

    protected array $messages = [];

    public function systemMessage(string $message = null): static
    {
        if (!is_null($message)) {
            $this->systemMessage = $message;
        }

        $this->messages[] = [
            'role' => 'system',
            'content' => $this->systemMessage
        ];

        $this->setMessages();

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

        unset($this->messages);

        return $response;
    }

    public function reply(string $message): ?string
    {
        $this->setMessages();

        return $this->send($message);
    }

    public function messages()
    {
        return $this->messages;
    }

    public function setMessages()
    {
        if (!session('messages')) {
            session(['messages' => json_encode($this->messages, JSON_PRETTY_PRINT)]);
        } else {
            $sess = json_decode(session('messages'), true);
            $merge = array_merge($sess, $this->messages);
            session(['messages' => json_encode($merge, JSON_PRETTY_PRINT)]);
            $this->messages = json_decode(session('messages'), true);
        }
    }
}
