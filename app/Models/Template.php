<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\PassDataToObserver;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class Template extends ListModel
{
    use EagerLoadPivotTrait, PassDataToObserver;

    protected $fillable = [
        'user_id',
        'editor_id',
        'type_of_gas_station_id',
        'type_of_checklist_id',
        'status',
    ];
    protected $hidden = [
        'user_id',
        'editor_id',
        'type_of_gas_station_id',
        'type_of_checklist_id',
        'deleted_at',
    ];
    protected $appends = [
        'title',
    ];
    protected $observables = [
        'sectionsAdded',
        'sectionsRemoved',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class)
            ->using('App\Models\TemplateSectionPivot')
            ->withPivot(['id', 'weight']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function templateTypes()
    {
        return $this->belongsTo(TypeOfChecklist::class, 'type_of_checklist_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function gasStationTypes()
    {
        return $this->belongsToMany(TypeOfGasStation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return 'Ш' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function attachSections(array $sections)
    {
            $this->sections()->attach($sections);
            $this->fireModelEvent('sectionsAdded', false, $sections);
    }

}
