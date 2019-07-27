<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\GasStation
 *
 * @property-read \App\Region $region
 * @property-read \App\TypeOfGasStation $type
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\GasStation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\GasStation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GasStation withoutTrashed()
 * @mixin \Eloquent
 */
class GasStation extends Model
{
    use SoftDeletes;

    protected $fillable = ['region_id', 'type_of_gas_station_id', 'number', 'address', 'is_shop', 'it_works', 'dir_name', 'dir_patronymic', 'dir_surname', 'email', 'phone'];
    protected $hidden = ['region_id', 'type_of_gas_station_id', 'dir_name', 'dir_patronymic', 'dir_surname', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return BelongsTo
     */
    public function region() : BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return BelongsTo
     */
    public function type() : BelongsTo
    {
        return $this->belongsTo(TypeOfGasStation::class);
    }
}
