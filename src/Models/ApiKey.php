<?php

namespace Kustomrt\LaravelSimpleApiKey\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property Carbon $last_used_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ApiKey extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    protected $fillable = ['name', 'key', 'last_used_at'];
    protected $casts = [
        'last_used_at' => 'datetime'
    ];
    protected static string $nameRegex = '/^[a-z0-9-]{1,255}$/';

    /**
     * Prune soft-deleted api keys after 30 days
     *
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->days(30));
    }

    public static function isValid(string $key): ?ApiKey
    {
        if(!Str::contains($key, '|')){
            /** @var ApiKey|null $apiKey */
            $apiKey = static::query()->where('key', $key)->first();
            return $apiKey;
        }

        [$id, $key] = explode('|', $key);
        /** @var ApiKey|null $apiKey */
        $apiKey = static::query()->find($id);

        if($apiKey){
            return hash_equals($apiKey->key, hash('sha256', $key)) ? $apiKey : null;
        }

        return null;
    }

    public static function isValidName($name): bool
    {
        return (bool) preg_match(self::$nameRegex, $name);
    }

    public static function boot()
    {
        parent::boot();

        // API Key is only updated on 'last_access_at' so for every update we'll create an access log entry
        static::updated(function(ApiKey $apiKey){
            info("API Key $apiKey->id accessed. Creating access log entry");

            /** @var ApiKeyAccessLog $apiKeyAccessLog */
            $apiKeyAccessLog = ApiKeyAccessLog::query()->create([
                'api_key_id' => $apiKey->id,
                'ip_address' => request()->ip(),
                'url' => request()->fullUrl()
            ]);

            info("Access log entry for API Key $apiKey->id was successfully created ($apiKeyAccessLog->id)");
        });
    }

    protected static function logActionEvent(){

    }

    protected static function logAccessEvent(){

    }
}
