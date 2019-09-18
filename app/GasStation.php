<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 * @property int $id
 * @property int $region_id
 * @property int $type_of_gas_station_id
 * @property string $number
 * @property string $address
 * @property int $is_shop
 * @property int $it_works
 * @property string $dir_name
 * @property string $dir_patronymic
 * @property string $dir_surname
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Profile[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereDirName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereDirPatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereDirSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereIsShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereItWorks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereTypeOfGasStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GasStation whereUpdatedAt($value)
 */
class GasStation extends Model
{
    use SoftDeletes;

    protected $fillable = ['region_id', 'type_of_gas_station_id', 'number', 'address', 'is_shop', 'it_works', 'dir_name', 'dir_patronymic', 'dir_surname', 'email', 'phone'];
    protected $hidden = ['region_id', 'type_of_gas_station_id', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'is_shop' => 'integer',
        'it_works' => 'integer',
    ];
    protected $appends = ['full_name'];

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
        return $this->belongsTo(TypeOfGasStation::class, 'type_of_gas_station_id');
    }

    public function users() : belongsToMany
    {
        return $this->belongsToMany(Profile::class);
    }

    public function getFullNameAttribute() : string
    {
        return $this->dir_surname.' '.$this->dir_name.' '.$this->dir_patronymic;
    }

}
