<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'original',
        'short_url',
        'clicks',
    ];

    protected $dates = [
        'expire_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
