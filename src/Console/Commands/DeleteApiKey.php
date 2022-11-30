<?php

namespace Kustomrt\LaravelSimpleApiKey\Console\Commands;

use Illuminate\Console\Command;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKey;
use SimpleApiKey;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DeleteApiKey extends Command
{
    /*
     * Messages
     */
    const MESSAGE_CONFIRMATION = 'Are you sure you want to delete the following API key?';

    /**
     * Error messages
     */
    const MESSAGE_ERROR_INVALID_ID = 'Please provide a valid API Key ID. To see the current keys run "php artisan apikey:list"';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikey:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing API key.';

    /**
     * Execute the console command.
     *
     */
    public function handle(): int
    {
        $id = $this->argument('id');

        /** @var ApiKey|null $apiKey */
        $apiKey = ApiKey::query()->find($id);

        if(!$apiKey){
            $this->error(self::MESSAGE_ERROR_INVALID_ID);
            return CommandAlias::FAILURE;
        }

        if (!$this->confirm(self::MESSAGE_CONFIRMATION . ": ($apiKey->id) $apiKey->name")) {
            return CommandAlias::FAILURE;
        }

        $apiKey->delete();

        $this->info("API Key deleted successfully: ($apiKey->id) $apiKey->name");

        return CommandAlias::SUCCESS;
    }
}
