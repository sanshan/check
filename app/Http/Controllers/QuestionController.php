<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{

    public function __invoke(Request $request) : View
    {
        $section = ($request->exists('section')) ? Section::find($request->section) : false;

        return view('audit.questions.index', compact('section'));
    }
}
