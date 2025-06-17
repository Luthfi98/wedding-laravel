<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LogActivity extends Model
{
    use HasUuids;

    protected $fillable = [
        'ip_address',
        'user_id',
        'method',
        'table',
        'data',
        'path'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

static function insertData(array $data, string $table)
{
    $ip_address = request()->ip();
    $method = request()->method();
    $path = request()->fullUrl();
    $user_id = auth()->user() ? auth()->user()->id : null;

    $attributes = [
        'ip_address' => $ip_address,
        'user_id' => $user_id,
        'method' => $method,
        'table' => $table,
        'data' => $data,
        'path' => $path
    ];

    return self::create($attributes);
}

}
