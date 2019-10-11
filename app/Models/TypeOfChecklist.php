<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfChecklist extends ListModel
{
    use SoftDeletes;

    protected $fillable = [
        'title',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $table = 'type_of_checklists';
}
