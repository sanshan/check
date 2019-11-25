<?php

namespace App\Models;

use App\Traits\PassDataToObserver;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TemplateSectionPivot extends Pivot
{
    use PassDataToObserver;

    public $incrementing = true;
    protected $table = 'section_template';

    protected $fillable = [
        'weight',
    ];

    protected $observables = [
        'questionsAdded',
        'questionsRemoved',
    ];

    public static function boot()
    {
        parent::boot();

//        static::deleting(function ($item) {
//            $pivot = TemplateSectionPivot::where('section_id', $item->section_id)->where('template_id', $item->template_id)->firstOrFail();
//            $pivot->questions->each(function($question){
//                $question->pivot->positions()->detach();
//            });
//            $pivot->questions()->detach();
//        });
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_section_template', 'section_template_id', 'question_id')
            ->using('App\Models\TemplateSectionQuestionPivot')
            ->withPivot('id');
    }

    public function attachQuestions(array $questions)
    {
        $this->questions()->attach($questions);
        $this->fireModelEvent('questionsAdded', false);
    }

    public function detachQuestions(array $questions)
    {
        $this->fireModelEvent('questionsRemoved', false, $questions);
        $this->questions()->detach($questions);
    }

}

