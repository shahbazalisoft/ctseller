<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $casts = [
        'id'=>'integer',
        'stores_count'=>'integer',
        'theme_id'=>'integer',
        'status'=>'string',
        'all_zone_service'=>'integer'
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }
}
