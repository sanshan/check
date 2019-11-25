<?php

namespace App\Observers;

use App\Models\Template;

class TemplateObserver
{
    /**
     * Handle the template "sectionsAdded" event.
     *
     * @param \App\Models\Template $template
     * @return void
     */
    public function sectionsAdded(Template $template)
    {
        $sections = $template->getEventData('sectionsAdded');

        $template->sections
            ->filter(function ($section) use ($sections) {
                return in_array($section->id, $sections);
            })
            ->each(function ($section) {
                $section->pivot->attachQuestions($section->questions->pluck('id')->toArray());
            });
    }

}
