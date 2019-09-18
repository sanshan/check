<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('audit.tasks.index');
    }
}
