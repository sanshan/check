<?php

namespace App\Http\Controllers;

use Illuminate\View\View;


class PositionController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('lists.positions.index');
    }
}
