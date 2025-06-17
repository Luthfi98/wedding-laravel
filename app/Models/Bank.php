<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Bank extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'image',
        'status',
    ];
}
