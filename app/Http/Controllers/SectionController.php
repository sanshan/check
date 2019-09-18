<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SectionController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('audit.sections.index');
    }
}
