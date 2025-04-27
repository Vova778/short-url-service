<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'link_id','clicked_at','referrer','ip_address'
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
