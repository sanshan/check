<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\FilterModels;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes, FilterModels;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'email_verified_at', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT
     *
     * @return array
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing ony custom claims to added to the JWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'test' => 'proverka',
        ];
    }


}
