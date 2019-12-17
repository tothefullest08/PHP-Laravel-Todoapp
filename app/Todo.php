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
            // 'user_id'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
