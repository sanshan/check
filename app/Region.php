<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Region
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Region onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Region withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Region withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GasStation[] $stations
 */
class Region extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];
    protected $hidden = ['pivot', 'created_at', 'updated_at', 'deleted_at'];

    public function stations() : HasMany
    {
        return $this->hasMany(GasStation::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }
}
