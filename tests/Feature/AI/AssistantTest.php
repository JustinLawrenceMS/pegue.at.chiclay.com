<?php

namespace Tests\Feature;

use App\AI\Assistant;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Testing\ClientFake;
use Tests\TestCase;

class AssistantTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Create a fake OpenAI client with a default response
        $fakeClient = new ClientFake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Mock response from OpenAI',
                        ],
                    ],
                ],
            ]),
        ]);

        // Swap the actual OpenAI client with the fake one
        OpenAI::swap($fakeClient);
    }

    public function test_system_message_is_saved()
    {
        $chat = new Assistant();

        $chat->systemMessage('System message content');

        $messages = $chat->getMessages();

        $this->assertCount(1, $messages);
        $this->assertEquals('system', $messages[0]['role']);
        $this->assertEquals('System message content', $messages[0]['content']);
    }

    public function test_send_message_saves_and_returns_response()
    {
        $chat = new Assistant();

        $response = $chat->send('Hello AI!');

        $this->assertEquals('Mock response from OpenAI', $response);

        $messages = $chat->getMessages();

	dump($messages);
        $this->assertCount(2, $messages);
        $this->assertEquals('user', $messages[0]['role']);
        $this->assertEquals('Hello AI!', $messages[0]['content']);
        $this->assertEquals('assistant', $messages[1]['role']);
        $this->assertEquals('Mock response from OpenAI', $messages[1]['content']);
    }

    public function test_reply_message_behaves_like_send()
    {
        $chat = new Assistant();

        $response = $chat->reply('Hello AI again!');

        $this->assertEquals('Mock response from OpenAI', $response);

        $messages = $chat->getMessages();

        $this->assertCount(2, $messages);
        $this->assertEquals('user', $messages[0]['role']);
        $this->assertEquals('Hello AI again!', $messages[0]['content']);
        $this->assertEquals('assistant', $messages[1]['role']);
        $this->assertEquals('Mock response from OpenAI', $messages[1]['content']);
    }

    public function test_set_messages_updates_session_correctly()
    {
        $chat = new Assistant();

        $chat->systemMessage('System message content');
        $chat->setSession();

        $sessionMessages = json_decode(session('messages'), true);

	dump($sessionMessages);
        $this->assertCount(1, $sessionMessages);
        $this->assertEquals('system', $sessionMessages[0]['role']);
        $this->assertEquals('System message content', $sessionMessages[0]['content']);
    }

    public function test_no_api_calls_sent_without_user_message()
    {
        // Assert that no API call was made
        OpenAI::assertNothingSent();
    }

    public function test_api_request_is_sent_with_correct_parameters()
    {
        $chat = new Assistant();

        $chat->send('Test message');

        // Assert the request was sent with the correct parameters
        OpenAI::chat()->assertSent(function (string $method, array $parameters): bool {
            return $method === 'create'
                && $parameters['model'] === 'gpt-3.5-turbo'
                && $parameters['messages'][0]['content'] === 'Test message';
        });
    }
}