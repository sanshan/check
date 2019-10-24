<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\CreatedUpdatedDatesModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends ListModel
{
    use SoftDeletes, CreatedUpdatedDatesModel, EagerLoadPivotTrait;

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

    /**
     * @return BelongsToMany
     */
    public function templates(): BelongsToMany
    {
        return $this->belongsToMany(Template::class)
            ->using('App\Models\QuestionTemplatePivot')
            ->withPivot('id');
    }

    public function scopeFrom($query, $section_id)
    {
        return $query->where('section_id', $section_id);
    }


}
