<?php

namespace App;

use App\Core\Entities\Todo as TodoEntity;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Todo
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $completed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|Todo newModelQuery()
 * @method static Builder|Todo newQuery()
 * @method static Builder|Todo query()
 * @method static Builder|Todo whereCompleted($value)
 * @method static Builder|Todo whereCreatedAt($value)
 * @method static Builder|Todo whereDescription($value)
 * @method static Builder|Todo whereId($value)
 * @method static Builder|Todo whereTitle($value)
 * @method static Builder|Todo whereUpdatedAt($value)
 * @method static Builder|Todo whereUserId($value)
 * @mixin Eloquent
 */
class Todo extends Model
{
    protected $fillable
        = [
            'title',
            'description',
            'completed',
        ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return TodoEntity
     */
    public function toEntity()
    {
        $todo = new TodoEntity();

        /** @noinspection PhpUndefinedFieldInspection */
        return $todo->setId($this->id)
            ->setUserId($this->user_id)
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setCompleted($this->completed);
    }
}
