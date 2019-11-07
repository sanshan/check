<?php


namespace App\Classes\Filter\Filters;


class MissingInTemplateSectionFilter
{
    public function filter($builder, $value)
    {
        $builder->select(['questions.id', 'questions.title'])
            ->from('questions')
            ->leftJoin('question_section_template', function ($join) use ($value){
                $join->on('questions.id', '=', 'question_section_template.question_id')
                    ->where('question_section_template.section_template_id', $value);
            })
            ->where('questions.section_id', request()->route('section')->id)
            ->whereNull('question_section_template.id');
    }
}
