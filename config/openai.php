<?php


return [

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
    'endpoint' => env('OPENAI_ENDPOINT'),

    'timeout' => 180, //time in seconds

];
