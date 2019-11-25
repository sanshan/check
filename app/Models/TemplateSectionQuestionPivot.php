<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TemplateSectionQuestionPivot extends Pivot
{
    public $incrementing = true;
    protected $table = 'question_section_template';

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'template_section_question_position', 'template_section_question_id', 'position_id');
    }
}
