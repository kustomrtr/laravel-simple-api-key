<?php

namespace Kustomrt\LaravelSimpleApiKey\Console\Commands;

use Illuminate\Console\Command;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKey;
use SimpleApiKey;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GenerateApiKey extends Command
{
    /**
     * Error messages
     */
    const MESSAGE_ERROR_INVALID_NAME_FORMAT = 'Invalid name.  Must be a lowercase alphabetic characters, numbers and hyphens less than 255 characters long.';
    const MESSAGE_ERROR_NAME_ALREADY_USED   = 'Name is unavailable.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikey:generate {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new API key';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $error = $this->validateName($name);

        if ($error) {
            $this->error($error);
            return CommandAlias::FAILURE;
        }

        $apiKey = SimpleApiKey::create($name);

        $this->info('API Key generated successfully');
        $this->info("Name: {$apiKey->apiKey->name}");
        $this->info("API Key: {$apiKey->plainTextApiKey}");
        $this->warn("IMPORTANT: Make sure to store it in a safe place. You won't be able to see the API Key again.");

        return CommandAlias::SUCCESS;
    }

    protected function validateName($name): ?string
    {
        if(!ApiKey::isValidName($name)){
            return self::MESSAGE_ERROR_INVALID_NAME_FORMAT;
        }

        return null;
    }
}
