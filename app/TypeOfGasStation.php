<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\TypeOfGasStation
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\TypeOfGasStation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\TypeOfGasStation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TypeOfGasStation withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $abbreviation
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfGasStation whereUpdatedAt($value)
 */
class TypeOfGasStation extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'abbreviation'];
    protected $hidden = ['pivot', 'created_at', 'updated_at', 'deleted_at'];
}
