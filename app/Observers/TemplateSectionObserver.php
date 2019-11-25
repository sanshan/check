<?php

namespace App\Observers;

use App\Models\TemplateSectionPivot;

class TemplateSectionObserver
{
    /**
     * Handle the TemplateSectionPivot "questionsAdded" event.
     *
     * @param  \App\Models\TemplateSectionPivot  $templateSectionPivot
     * @return void
     */
    public function questionsAdded(TemplateSectionPivot $templateSectionPivot)
    {
        $templateSectionPivot->questions->each(function ($question){
           $question->pivot->positions()->attach($question->positions->pluck('id')->toArray());
        });
    }

    /**
     * Handle the TemplateSectionPivot "questionsRemoved" event.
     *
     * @param  \App\Models\TemplateSectionPivot  $templateSectionPivot
     * @return void
     */
    public function questionsRemoved(TemplateSectionPivot $templateSectionPivot)
    {
        $questions = $templateSectionPivot->getEventData('questionsRemoved');

        $templateSectionPivot->questions()->findMany($questions)->each(function ($question){
            $question->pivot->positions()->detach();
        });
    }

}
