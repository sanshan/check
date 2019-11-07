<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends ListModel
{

    protected $fillable = [
        'title',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
