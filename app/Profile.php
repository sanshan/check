<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Profile
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $mobile
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUserId($value)
 * @property int $role_id
 * @property string $name
 * @property string $patronymic
 * @property string $surname
 * @property string $phone
 * @property string|null $deleted_at
 * @property-read mixed $full_name
 * @property-read \App\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereSurname($value)
 */
class Profile extends Model
{
    protected $hidden = ['id', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->patronymic.' '.$this->surname;
    }
}
