<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TemplateSectionQuestionPivot extends Pivot
{
    public $incrementing = true;

    public static function boot()
    {
        parent::boot();

        static::saved(function ($item) {
            $positions = Question::findOrFail($item->question_id)->positions;
            $item->positions()->attach($positions->pluck(['id']) ?? []);
        });

        static::deleting(function ($item) {
            //$pivot = TemplateSectionQuestionPivot::where('question_id', $item->section_id)->where('template_id', $item->template_id)->firstOrFail();
            //$pivot->questions()->detach();
        });
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'template_section_question_position', 'template_section_question_id', 'position_id');
    }
}
