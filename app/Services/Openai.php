<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Openai
{
    protected string $endpoint;
    protected string $api_key;
    protected string $model;
    protected array $messages = [];

    protected $user;
    protected $currentTeam;

    /**
     * This requires an organization or team. The team should have a setting page
     * where the business information is set for the prompt completion
     *
     * Information from the team includes:
     * string $name, string $niche, string $business_overview or $service_description
     *
     */

    public function __construct()
    {
        $this->endpoint = config('openai.endpoint');
        $this->api_key = config('openai.api_key');
        $this->model = config('openai.model');
        $this->messages[] = [
            "role" => "system",
            "content" => "You are a seasoned social media copywriter."
        ];

        $this->user = auth()->user();
        $this->currentTeam = auth()->user()->team;
    }

    public function generateText(string $prompt_message, string $model = null): ?string
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $prompt_message
        ];
        $endpoint = $this->endpoint . '/chat/completions';
        $model = $model ?? $this->model;

        $response = Http::timeout(config('openai.timeout'))
            ->withToken($this->api_key)
            ->post(
                $endpoint,
                [
                    "model" => $model,
                    "messages" => $this->messages
                ]
            )
            ->json('choices.0.message.content');

        return html_entity_decode($response);
    }

    public function generateImage(string $prompt_message, string $model = "dall-e-3")
    {
        $endpoint = $this->endpoint . '/images/generations';

        $response = Http::timeout(config('openai.timeout'))
            ->withToken($this->api_key)
            ->post(
                $endpoint,
                [
                    "model" => $model,
                    "prompt" => $prompt_message,
                    "n" => 1,
                    "size" => "1024x1024"
                ]
            )->json('data.0.url');

        return $response;
    }

}
