<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Setting extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'value',
        'status',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    protected $attributes = [
        'type' => 'text',
        'status' => 'active'
    ];
}
