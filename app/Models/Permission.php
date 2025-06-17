<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
        use HasFactory, HasUuids;

        protected $casts = [
            'created_at' => 'date:d-M-Y H:i',
        ];
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
