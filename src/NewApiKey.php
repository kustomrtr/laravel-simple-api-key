<?php

namespace Kustomrt\LaravelSimpleApiKey;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKey;

class NewApiKey implements Arrayable, Jsonable
{
    public function __construct(public ApiKey $apiKey, public string $plainTextApiKey)
    {
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'apiKey' => $this->apiKey,
            'plainTextApiKey' => $this->plainTextApiKey,
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
