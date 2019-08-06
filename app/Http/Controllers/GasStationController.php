<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class GasStationController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('lists.gas_stations.index');
    }
}
