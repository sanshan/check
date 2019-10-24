<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{

    public function __invoke(Request $request, Section $section) : View
    {
        return view('audit.questions.index', compact('section'));
    }
}
