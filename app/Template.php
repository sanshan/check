<?php

namespace App;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Template
 *
 * @property int $id
 * @property int $author_id
 * @property int|null $editor_id
 * @property int $type_of_checklist_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TypeOfGasStation[] $gasStationTypes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read \App\TypeOfChecklist $templateType
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Template onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereEditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereTypeOfChecklistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Template withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Region[] $regions
 * @property-read \App\User $author
 * @property-read \App\User|null $editor
 * @property-read \App\TypeOfChecklist $templateTypes
 * @property-read mixed $title
 */
class Template extends Model
{
    use SoftDeletes;
    use EagerLoadPivotTrait;
    protected $fillable = ['author_id', 'editor_id', 'type_of_gas_station_id', 'type_of_checklist_id', 'status'];
    protected $hidden = ['author_id', 'editor_id', 'type_of_gas_station_id', 'type_of_checklist_id', 'deleted_at', 'created_at', 'updated_at'];
    protected $appends = ['title', 'created_date', 'updated_date'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)
            ->using('App\QuestionTemplatePivot')
            ->has('section')
            ->withPivot('id');
    }

    public function templateTypes()
    {
        return $this->belongsTo(TypeOfChecklist::class, 'type_of_checklist_id');
    }

    public function gasStationTypes()
    {
        return $this->belongsToMany(TypeOfGasStation::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function getTitleAttribute()
    {
        return 'Ш'.str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getCreatedDateAttribute() {
        return \Carbon\Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
    }

    public function getUpdatedDateAttribute() {
        return \Carbon\Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
    }

}
