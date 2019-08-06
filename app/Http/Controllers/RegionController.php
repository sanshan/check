<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class RegionController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('lists.regions.index');
    }
}
