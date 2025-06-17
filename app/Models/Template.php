<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Template extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'file_content',
        'status',
        'created_by',
    ];

    protected $casts = [
        'file_content' => 'array',
    ];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
