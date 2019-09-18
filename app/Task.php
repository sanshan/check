<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Task
 *
 * @property int $id
 * @property string $start_date
 * @property string $end_date
 * @property int $region_id
 * @property int $gas_station_id
 * @property int $type_of_checklist_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereGasStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTypeOfChecklistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUserId($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use SoftDeletes;
    protected $fillable = ['start_date','end_date','region_id','gas_station_id','type_of_checklist_id','user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function station()
    {
        return $this->belongsTo(GasStation::class, 'gas_station_id');
    }

    public function type()
    {
        return $this->belongsTo(TypeOfChecklist::class, 'type_of_checklist_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
