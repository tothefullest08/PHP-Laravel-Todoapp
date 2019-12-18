<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable
        = [
            'title',
            'description',
            'completed_at',
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
