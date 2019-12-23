<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Todo
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereUserId($value)
 * @mixin \Eloquent
 */
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
