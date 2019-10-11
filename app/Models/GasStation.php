<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDatesModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GasStation extends ListModel
{
    use CreatedUpdatedDatesModel;

    protected $fillable = [
        'region_id',
        'type_of_gas_station_id',
        'number',
        'address',
        'is_shop',
        'it_works',
        'dir_name',
        'dir_patronymic',
        'dir_surname',
        'email',
        'phone',
    ];
    protected $hidden = [
        'region_id',
        'type_of_gas_station_id',
        'pivot',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'is_shop'  => 'integer',
        'it_works' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeOfGasStation::class, 'type_of_gas_station_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(Profile::class);
    }

}
