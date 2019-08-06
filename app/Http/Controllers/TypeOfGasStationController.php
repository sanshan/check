<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TypeOfGasStationController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('lists.type_of_gas_stations.index');
    }
}
