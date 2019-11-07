<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends ListModel
{
    use EagerLoadPivotTrait;

    protected $fillable = [
        'title',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return HasMany
     */
    public function questions() : HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function templates()
    {
        return $this->belongsToMany(Template::class)
            ->using('App\Models\TemplateSectionPivot')
            ->withPivot(['id', 'weight']);
    }

}
