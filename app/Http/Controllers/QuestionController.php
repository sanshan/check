<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Section;
use Illuminate\View\View;

class QuestionController extends Controller
{


    /**
     * @param QuestionRequest $request
     * @return View
     */
    public function __invoke(QuestionRequest $request) : View
    {
        $section = ($request->exists('section')) ? Section::find($request->section) : false;

        return view('audit.questions.index', compact('section'));
    }
}
