<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url',
        'short_code',
        'user_id',
        'password',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    public function status()
{
    return $this->belongsTo(Status::class);
}


    /**
     *
     * @param  string|null  $custom
     * @return string
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function generateUniqueCode(?string $custom = null): string
    {
        $cfg = config('links.generator');
        $blacklist = config('links.blacklist', []);

        $alphabet = implode('abcdefghijklmnopqrstuvwxyz', array_filter([
            $cfg['lowercase'] ? 'abcdefghijklmnopqrstuvwxyz' : null,
            $cfg['uppercase'] ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : null,
            $cfg['digits'] ? '0123456789' : null,
            $cfg['symbols'] ?? null,
        ]));

        if ($custom) {
            if (in_array($custom, $blacklist, true)
                || static::where('short_code', $custom)->exists()
            ) {
                abort(422, __('home.error_code_taken'));
            }
            return $custom;
        }

        $length = (int) $cfg['length'];

        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
            }
        } while (
            in_array($code, $blacklist, true)
            || static::where('short_code', $code)->exists()
        );

        return $code;
    }
}
