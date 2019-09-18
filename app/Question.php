<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

/**
 * App\Question
 *
 * @property-read \App\Section $section
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Question withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $section_id
 * @property string $title
 * @property int $required
 * @property int $partly
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question wherePartly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Position[] $positions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Template[] $templates
 */
class Question extends Model
{
    use SoftDeletes;
    use EagerLoadPivotTrait;
    protected $fillable = ['section_id', 'title', 'required', 'partly'];
    protected $hidden = ['section_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return BelongsTo
     */
    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @return BelongsToMany
     */
    public function positions() : BelongsToMany
    {
        return $this->belongsToMany(Position::class);
    }

    /**
     * @return BelongsToMany
     */
    public function templates() : BelongsToMany
    {
        return $this->belongsToMany(Template::class)
            ->using('App\QuestionTemplatePivot')
            ->withPivot('id');
    }

}
