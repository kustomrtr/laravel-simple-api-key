<?php

namespace Kustomrt\LaravelSimpleApiKey\Console\Commands;

use Illuminate\Console\Command;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKey;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ListApiKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikey:list {--D|deleted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the available API keys';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $apiKeys = $this->option('deleted')
        ? ApiKey::withTrashed()->orderBy('name')->get()
        : ApiKey::query()->orderBy('name')->get();

        if(!$apiKeys->count()){
            $this->warn('There are no API keys. To generate one run "php artisan apikey:generate api_key_name_here".');

            return CommandAlias::SUCCESS;
        }

        $headers = ['ID', 'Name', 'Last Used', 'Created', 'Status'];
        $rows = $apiKeys->map(function($apiKey){
            return [
                $apiKey->id,
                $apiKey->name,
                $this->lastUsedAt($apiKey),
                $apiKey->created_at,
                $apiKey->deleted_at ? 'deleted': 'active'
            ];
        });

        $this->table($headers, $rows);

        return CommandAlias::SUCCESS;
    }

    public function lastUsedAt(ApiKey $apiKey): string
    {
        if($apiKey->last_used_at){
            $ago = $apiKey->last_used_at->diffForHumans();
            return "$apiKey->last_used_at ($ago)";
        }

        return 'never';
    }
}
