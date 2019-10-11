<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Position extends ListModel
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'code',
        'to_rate',
    ];
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'to_rate' => 'boolean',
    ];

    /**
     * @return BelongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }

}
