<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    protected $hidden = [
        'id', 'user_id', 'role_id', 'created_at', 'updated_at', 'deleted_at',
    ];
    protected $fillable = [
        'phone', 'name', 'patronymic', 'surname', 'full_name', 'role_id',
    ];

    /**
     * @return BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function regions() : BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }

    /**
     * @return BelongsToMany
     */
    public function stations() : BelongsToMany
    {
        return $this->belongsToMany(GasStation::class);
    }

}
