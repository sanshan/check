<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TypeOfChecklistController extends Controller
{
    public function __invoke() : View
    {
        return view('lists.type_of_checklists.index');
    }
}
