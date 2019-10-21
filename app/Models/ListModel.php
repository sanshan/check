<?php

namespace App\Models;

use App\Traits\FilterModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class ListModel extends Model
{
    use SoftDeletes, FilterModels;
}
