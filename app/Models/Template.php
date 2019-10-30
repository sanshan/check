<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Traits\CreatedUpdatedDatesModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends ListModel
{
    use SoftDeletes, EagerLoadPivotTrait;

    protected $fillable = [
        'author_id',
        'editor_id',
        'type_of_gas_station_id',
        'type_of_checklist_id',
        'status',
    ];
    protected $hidden = [
        'author_id',
        'editor_id',
        'type_of_gas_station_id',
        'type_of_checklist_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    protected $appends = [
        'title',
        'created_date',
        'updated_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
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
            ->withPivot('id');
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

    /**
     * @return string
     */
    public function getCreatedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
    }

    /**
     * @return string
     */
    public function getUpdatedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
    }

}
