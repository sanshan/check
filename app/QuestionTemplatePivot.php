<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Log;

/**
 * App\QuestionTemplatePivot
 *
 * @property int $id
 * @property int $question_id
 * @property int $template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Position[] $positions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionTemplatePivot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionTemplatePivot extends Pivot
{
    protected $fillable = ['id'];
    //protected $hidden = ['template_id', 'question_id'];
    protected $table = 'question_template';
    public $incrementing = true;

    public static function boot()
    {
        parent::boot();
        static::saved(function ($item)  {
            $positions = Question::findOrFail($item->question_id)->positions;
            foreach ($positions as $position )
                $item->positions()->attach($position->id);
        });

        static::deleting(function ($item)  {
            $pivot = QuestionTemplatePivot::where('question_id', $item->question_id)->where('template_id', $item->template_id)->firstOrFail();
            $pivot->positions()->detach();
        });
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_question_template', 'question_template_id', 'position_id');
    }
}
