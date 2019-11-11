<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\CreatedUpdatedDatesModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends ListModel
{
    use CreatedUpdatedDatesModel, EagerLoadPivotTrait;

    protected $fillable = [
        'section_id',
        'title',
        'required',
        'partly',
    ];
    protected $hidden = [
        'section_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @return BelongsToMany
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class);
    }

    public function tsPivot()
    {
        return $this->belongsToMany(TemplateSectionPivot::class, 'question_section_template', 'question_id', 'section_template_id');
    }

    public function scopeFromSection($query, $section_id)
    {
        return $query->where('section_id', $section_id);
    }


}
