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
 */
class TypeOfGasStation extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'abbreviation'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
