<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url','short_code','user_id','password','expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }
}
