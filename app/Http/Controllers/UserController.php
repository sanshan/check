<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function __invoke() : View
    {
        return view('lists.users.index');
    }
}
