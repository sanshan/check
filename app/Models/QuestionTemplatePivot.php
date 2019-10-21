<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class QuestionTemplatePivot extends Pivot
{
    public $incrementing = true;
    //protected $hidden = ['template_id', 'question_id'];
    protected $fillable = ['id'];
    protected $table = 'question_template';

    public static function boot()
    {
        parent::boot();
        static::saved(function ($item) {
            $positions = Question::findOrFail($item->question_id)->positions;
            foreach ($positions as $position)
                $item->positions()->attach($position->id);
        });

        static::deleting(function ($item) {
            $pivot = QuestionTemplatePivot::where('question_id', $item->question_id)->where('template_id', $item->template_id)->firstOrFail();
            $pivot->positions()->detach();
        });
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_question_template', 'question_template_id', 'position_id');
    }

}
