<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TemplateController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('audit.templates.index');
    }
}
