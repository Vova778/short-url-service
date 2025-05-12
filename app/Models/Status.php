<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $fillable = [
        'name',
        'label',
    ];
    
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
