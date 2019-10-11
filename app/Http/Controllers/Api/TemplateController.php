<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\addQuestionRequest;
use App\Http\Requests\Template\removeQuestionRequest;
use App\Http\Requests\Template\TemplateIndexRequest;
use App\Http\Requests\Template\TemplateRequest;
use App\Http\Requests\Template\TemplateStoreRequest;
use App\Http\Requests\Template\TemplateUpdateRequest;
use App\Http\Requests\Template\updatePositionRequest;
use App\Http\Resources\Position\PositionResource;
use App\Http\Resources\Template\QuestionInTemplateResource;
use App\Http\Resources\Template\TemplateDTResource;
use App\Http\Resources\Template\TemplateInfoResource;
use App\Http\Resources\Template\TemplateResource;
use App\Http\Resources\Template\TemplateSelect2Resource;
use App\Models\Question;
use App\Models\QuestionTemplatePivot;
use App\Models\Template;
use DB;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(TemplateIndexRequest $request)
    {
        $templates = Template::filter($request)
            ->take(10)
            ->get();

        return TemplateSelect2Resource::collection($templates);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $templates = Template::with('regions', 'templateTypes', 'gasStationTypes')->withCount('questions')->get();
        return datatables()->of(TemplateDTResource::collection($templates))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })
            ->addColumn('link', function ($row) {
                return '<a class="model-show font-weight-bold" title="Шаблон №' . $row['id'] . '" href="#" data-id="' . $row['id'] . '">' . $row['title'] . '</a>';
            })
            ->rawColumns(['link'])
            ->toJson();
    }

    /**
     * @param TemplateStoreRequest $request
     * @return TemplateInfoResource
     * @throws \Throwable
     */
    public function store(TemplateStoreRequest $request): TemplateInfoResource
    {
        $template = DB::transaction(function () use ($request) {
            $template = Template::create([
                'author_id'            => 1,
                'editor_id'            => 1,
                'type_of_checklist_id' => $request->type_of_checklist_id,
                'status'               => $request->it_works,
            ]);

            $template->gasStationTypes()->sync($request->type_of_gas_station_id);
            $template->regions()->sync($request->region_id);

            return $template;
        });
        return TemplateInfoResource::make($template);
    }

    /**
     * @param $id
     * @return TemplateResource
     */
    public function show($id): TemplateResource
    {
        $template = Template::with(['author.profile', 'editor.profile', 'gasStationTypes', 'templateTypes', 'regions'])->withCount('questions')->findOrFail($id);
        return TemplateResource::make($template);
    }

    /**
     * @param TemplateInfoResource $request
     * @param Template $template
     * @return TemplateResource
     * @throws \Throwable
     */
    public function update(TemplateUpdateRequest $request, Template $template): TemplateInfoResource
    {
        $template = DB::transaction(function () use ($request, $template) {
            $template->editor_id = 2;
            $template->type_of_checklist_id = $request->type_of_checklist_id;
            $template->status = $request->it_works;
            $template->save();
            $template->gasStationTypes()->sync($request->type_of_gas_station_id);
            $template->regions()->sync($request->region_id);

            return $template;
        });
        return TemplateInfoResource::make($template);
    }

    /**
     * @param Template $template
     * @return TemplateInfoResource
     * @throws \Throwable
     */
    public function destroy(Template $template): TemplateInfoResource
    {
        $template = DB::transaction(function () use ($template) {
            $template->gasStationTypes()->detach();
            $template->regions()->detach();
            $template->questions()->detach();
            $template->delete();

            return $template;
        });
        return TemplateInfoResource::make($template);
    }

    /**
     * @param Template $template
     * @return mixed
     * @throws \Exception
     */

    // Этот метод надо перенести в QuestionController
    public function questions(Template $template)
    {
        $questions = $template->questions()->with(['pivot.positions', 'positions', 'section'])->get()->sortBy('id');
        return datatables()->of(QuestionInTemplateResource::collection($questions))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })
            ->toJson();
    }

    /**
     * @param addQuestionRequest $request
     * @param Template $template
     * @return \Illuminate\Http\JsonResponse
     */
    // Этот метод надо перенести в QuestionController
    public function addQuestion(addQuestionRequest $request, Template $template)
    {

        $template->questions()->attach($request->question_id);

        return response()->json(['message' => 'Вопросы добавлены в шаблон!']);
    }

    /**
     * @param removeQuestionRequest $request
     * @param Template $template
     * @return \Illuminate\Http\JsonResponse
     */
    // Этот метод надо перенести в QuestionController
    public function removeQuestion(removeQuestionRequest $request, Template $template)
    {
        $template->questions()->detach($request->question_id);

        return response()->json(['message' => 'Вопросы удалены из шаблона!']);
    }

    /**
     * @param updatePositionRequest $request
     * @param Template $template
     * @return \Illuminate\Http\JsonResponse
     */
    // Этот метод надо перенести в PositionController
    public function updatePositions(updatePositionRequest $request, Template $template)
    {
        $pivot = QuestionTemplatePivot::where('question_id', $request->question_id)->where('template_id', $template->id)->firstOrFail();
        $pivot->positions()->sync($request->position_id);

        return response()->json(['message' => 'Проверяемые категории должностей изменены']);
    }

    // Этот метод надо перенести в PositionController
    public function indexPositions(Request $request, Template $template, Question $question)
    {
        $title = $request->input('title');

        $pivot = QuestionTemplatePivot::where('question_id', $question->id)->where('template_id', $template->id)->firstOrFail();

        $positions = $pivot->positions()
            ->when($title, function ($query) use ($title) {
                return $query->where('title', 'LIKE', "%$title%")->take(10);
            })
            ->get();

        return PositionResource::collection($positions);
    }
}
