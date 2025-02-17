<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'user_id',
        'original',
        'short_url',
        'clicks',
        'expire_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
