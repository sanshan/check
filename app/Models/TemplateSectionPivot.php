<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TemplateSectionPivot extends Pivot
{
    public $incrementing = true;
    protected $table = 'section_template';

    public static function boot()
    {
        parent::boot();

        static::saved(function ($item) {
            $questions = Section::findOrFail($item->section_id)->questions;
            foreach ($questions as $question)
                $item->questions()->attach($question->id);
        });

        static::deleting(function ($item) {
            $pivot = TemplateSectionPivot::where('section_id', $item->section_id)->where('template_id', $item->template_id)->firstOrFail();
            $pivot->questions()->detach();
        });
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_section_template', 'section_template_id', 'question_id')
            ->using('App\Models\TemplateSectionQuestionPivot')
            ->withPivot('id');
    }

}
