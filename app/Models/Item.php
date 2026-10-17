<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'detail',
        'found_place',
        'date',
        'status',
        'image_path',
        'claimed_at',
    ];

    public function finder()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    protected $casts = ['claimed_at' => 'datetime', 'date' => 'date'];
}
