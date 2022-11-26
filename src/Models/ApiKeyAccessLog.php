<?php

namespace Kustomrt\LaravelSimpleApiKey\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $api_key_id
 * @property string $ip_address
 * @property string $url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ApiKeyAccessLog extends Model
{
    use HasFactory;

    protected $fillable = ['api_key_id', 'ip_address', 'url'];
}
