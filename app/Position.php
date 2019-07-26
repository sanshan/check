<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Position
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Position onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Position withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Position withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $code
 * @property int $to_rate
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereToRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUpdatedAt($value)
 */
class Position extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'code', 'to_rate'];
    protected $hidden =['created_at', 'updated_at', 'deleted_at'];
}
