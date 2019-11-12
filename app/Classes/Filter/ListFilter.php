<?php

namespace App\Classes\Filter;

class ListFilter extends AbstractFilter
{
    protected $filters = [
        'full_name'                   => \App\Classes\Filter\Filters\FullNameFilter::class,
        'gas_station_region'          => \App\Classes\Filter\Filters\GasStationRegionFilter::class,
        'number'                      => \App\Classes\Filter\Filters\NumberFilter::class,
        'title'                       => \App\Classes\Filter\Filters\TitleFilter::class,
        'region'                      => \App\Classes\Filter\Filters\UserRegionFilter::class,
        'section'                     => \App\Classes\Filter\Filters\SectionFilter::class,
        'template'                    => \App\Classes\Filter\Filters\TemplateIdFilter::class,
        'missing_in_template'         => \App\Classes\Filter\Filters\MissingInTemplateFilter::class,
        'present_in_template'         => \App\Classes\Filter\Filters\PresentInTemplate::class,
        'missing_in_section_template' => \App\Classes\Filter\Filters\MissingInTemplateSectionFilter::class,
    ];
}
