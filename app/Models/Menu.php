<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Menu extends Model
{
    use HasUuids, SoftDeletes;
    protected $fillable = ['name', 'module_name', 'icon', 'route', 'order', 'parent_id', 'status', 'list_permissions'];
    protected $casts = [
        'list_permissions' => 'array',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'menu_id', 'id');
    }

    
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }
}

