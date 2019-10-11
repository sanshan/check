<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDatesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Task
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int $region_id
 * @property int $gas_station_id
 * @property int $type_of_checklist_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $created_date
 * @property-read mixed $updated_date
 * @property-read \App\Models\Region $region
 * @property-read \App\Models\GasStation $station
 * @property-read \App\Models\TypeOfChecklist $type
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Task onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereGasStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereTypeOfChecklistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Task withoutTrashed()
 * @mixin \Eloquent
 */
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'start_date','end_date','region_id','gas_station_id','type_of_checklist_id','user_id',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $dates = [
        'start_date', 'end_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function station()
    {
        return $this->belongsTo(GasStation::class, 'gas_station_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(TypeOfChecklist::class, 'type_of_checklist_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
