<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\TypeOfChecklist
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\TypeOfChecklist onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\TypeOfChecklist withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TypeOfChecklist withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TypeOfChecklist whereUpdatedAt($value)
 */
class TypeOfChecklist extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'type_of_checklists';
}
