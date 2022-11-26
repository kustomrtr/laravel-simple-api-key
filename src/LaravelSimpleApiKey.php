<?php

namespace Kustomrt\LaravelSimpleApiKey;

use Illuminate\Support\Str;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKey;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKeyAccessLog;

class LaravelSimpleApiKey
{
    public function create(string $name): NewApiKey
    {
        /** @var ApiKey $apiKey */
        $apiKey = ApiKey::query()->create([
            'name' => $name,
            'key' => hash('sha256', $plainTextApiKey = Str::random(40))
        ]);

        return new NewApiKey($apiKey, "$apiKey->id|$plainTextApiKey");
    }
}
