<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $fillable = ['title', 'description', 'photo', 'status', 'reply'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
