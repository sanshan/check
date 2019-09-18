<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Section
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Section onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Section withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 */
class Section extends Model
{
    use SoftDeletes;
    protected $fillable = ['title'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return HasMany
     */
    public function questions() : HasMany
    {
        return $this->hasMany(Question::class);
    }
}
