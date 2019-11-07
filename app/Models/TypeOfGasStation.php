<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfGasStation extends ListModel
{

    protected $fillable = [
        'title',
        'abbreviation',
    ];
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
