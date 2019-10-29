<?php

namespace Tests\Feature;

use App\Models\Position;
use App\Models\Question;
use App\Models\Section;
use App\Models\Template;
use App\Models\TypeOfChecklist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class TemplateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_add_sections_to_the_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();

        $params = [
            'sections' => [
                $section1->id,
                $section2->id,
            ],
        ];
        $this->json('POST', route('templates.sections.store', ['template' => $template->id]), $params)
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Sections added to the template.'),
            ]);

        $this->assertEquals(2, $template->sections()->count());
    }

    /**
     * @test
     */
    public function user_can_add_only_unique_sections_to_the_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();

        $template->sections()->attach([
            $section1->id,
            $section2->id,
        ]);

        $params = [
            'sections' => [
                $section1->id,
            ],
        ];

        $this->json('POST', route('templates.sections.store', ['template' => $template->id]), $params)
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_remove_sections_from_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();
        $section3 = factory(Section::class)->create();

        $template->sections()->attach([
            $section1->id,
            $section2->id,
            $section3->id,
        ]);

        $params = [
            'sections' => [
                $section2->id,
            ],
        ];
        $this->json('DELETE', route('templates.sections.destroy', ['template' => $template->id]), $params)
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Sections removed from the template.'),
            ]);

        $this->assertEquals(2, $template->sections()->count());
        $this->assertEquals(0, $template->sections()->where('sections.id', $section2->id)->get()->count());

    }

    /**
     * @test
     */
    public function user_can_remove_only_present_sections_from_the_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();
        $section3 = factory(Section::class)->create();

        $template->sections()->attach([
            $section1->id,
            $section2->id,
        ]);

        $params = [
            'sections' => [
                $section2->id,
                $section3->id,
            ],
        ];
        $this->json('DELETE', route('templates.sections.destroy', ['template' => $template->id]), $params)
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function questions_from_the_section_are_transferred_to_the_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section = factory(Section::class)->create();
        $section->questions()->saveMany(factory(Question::class, 2)->make());

        $template->sections()->attach([
            $section->id,
        ]);

        $this->assertEquals($template->sections()->where('sections.id', $section->id)->first()->pivot->questions()->count(), 2);

    }

    /**
     * @test
     */
    public function positions_from_the_question_are_transferred_to_the_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section = factory(Section::class)->create();
        $question = $section->questions()
            ->saveMany(factory(Question::class, 3)->make())
            ->first();
        $question->positions()->saveMany(factory(Position::class, 5)->make());

        $template->sections()->attach([
            $section->id,
        ]);

        $this->assertEquals($template->sections()->where('sections.id', $section->id)->first()->pivot->questions()->where('questions.id', $question->id)->first()->pivot->positions()->count(), 5);

    }

    /**
     * @test
     */
    public function user_can_remove_questions_from_template()
    {
        $this->withoutExceptionHandling();

        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $sections = factory(Section::class, 3)->create();
        foreach ($sections as $section) {
            $section->questions()->saveMany(factory(Question::class, 5)->make());
        }
        $sectionsID = $sections->take(2)->pluck('id')->toArray();

        $template->sections()->attach($sectionsID);

        $questionsID = $template->sections()
            ->where('sections.id', $sectionsID[0])
            ->first()
            ->pivot
            ->questions()
            ->take(2)
            ->get()
            ->pluck('id')
            ->toArray();

        $params = [
            'questions' => $questionsID,
        ];
        $this->json('DELETE', route('templates.sections.questions.destroy', ['template' => $template->id, 'section' => $sectionsID[0]]), $params)
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Questions removed from the template.'),
            ]);

        $this->assertEquals($template->sections()->where('sections.id', $sectionsID[0])->first()->pivot->questions()->count(), 3);
    }

    /**
     * @test
     */
    public function user_can_remove_only_present_questions_from_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();

        $section1->questions()->saveMany(factory(Question::class, 5)->make());
        $section2->questions()->saveMany(factory(Question::class, 5)->make());

        $template->sections()->attach([
            $section1->id,
        ]);

        $question = $section2->questions->first();

        $params = [
            'questions' => [
                $question->id,
            ],
        ];

        $this->json('DELETE', route('templates.sections.questions.destroy', ['template' => $template->id, 'section' => $section1->id]), $params)
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_add_questions_to_template()
    {
        $this->withoutExceptionHandling();

        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section = factory(Section::class)->create();
        $section->questions()
            ->saveMany(
                factory(Question::class, 10)->make()
            );

        $template->sections()->attach([
            $section->id,
        ]);

        $newQuestionsID = $section->questions()
            ->saveMany(
                factory(Question::class, 2)->make()
            )
            ->pluck('id')
            ->toArray();

        $params = [
            'questions' => $newQuestionsID,
        ];
        $this->json('POST', route('templates.sections.questions.store', ['template' => $template->id, 'section' => $section->id]), $params)
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Questions added to the template.'),
            ]);

        $this->assertEquals($template->sections()->where('sections.id', $section->id)->first()->pivot->questions()->count(), 12);

    }

    /**
     * @test
     */
    public function user_can_add_only_unique_questions_to_the_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section = factory(Section::class)->create();
        $section->questions()
            ->saveMany(
                factory(Question::class, 10)->make()
            );

        $template->sections()->attach([
            $section->id,
        ]);

        $newQuestionsID = $section->questions()
            ->take(2)
            ->get()
            ->pluck('id')
            ->toArray();

        $params = [
            'questions' => $newQuestionsID,
        ];
        $this->json('POST', route('templates.sections.questions.store', ['template' => $template->id, 'section' => $section->id]), $params)
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_sync_positions_in_the_template()
    {
        $this->withoutExceptionHandling();

        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section = factory(Section::class)->create();
        $question = $section->questions()
            ->saveMany(factory(Question::class, 3)->make())
            ->first();
        $positions = $question->positions()->saveMany(factory(Position::class, 5)->make());

        $template->sections()->attach([
            $section->id,
        ]);

        $params = [
            'positions' => $positions->take(2)->pluck('id')->toArray(),
        ];

        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                [
                    'template' => $template->id,
                    'section'  => $section->id,
                    'question' => $question->id
                ]
            ),
            $params
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Positions synced.'),
            ]);

        $this->assertEquals(
            $template->sections()
                ->where('sections.id', $section->id)
                ->first()
                ->pivot
                ->questions()
                ->where('questions.id', $question->id)
                ->first()
                ->pivot
                ->positions()
                ->count(),
            2
        );

    }

    /**
     * @test
     */
    public function user_can_sync_only_present_positions_in_the_template()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section = factory(Section::class)->create();
        $question = $section->questions()->save(factory(Question::class)->make());
        $question->positions()->saveMany(factory(Position::class, 5)->make());

        $template->sections()->attach([
            $section->id,
        ]);

        $params = [
            'positions' => [
                100,
                200,
            ],
        ];
        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                [
                    'template' => $template->id,
                    'section'  => $section->id,
                    'question' => $question->id
                ]
            ),
            $params
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_use_only_correct_section_id_when_deleting_questions()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();
        $question = $section1->questions()->save(factory(Question::class)->make());

        $template->sections()->attach([
            $section1->id,
        ]);

        $params = [
            'questions' => [
                $question->id,
            ]
        ];
        $this->json(
            'DELETE',
            route(
                'templates.sections.questions.destroy',
                [
                    'template' => $template->id,
                    'section'  => $section2->id,
                ]
            ),
            $params
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_use_only_correct_section_id_when_adding_questions()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();
        $section1->questions()->save(factory(Question::class)->make());

        $template->sections()->attach([
            $section1->id,
        ]);

        $question2 = $section1->questions()->save(factory(Question::class)->make());

        $params = [
            'questions' => [
                $question2->id,
            ]
        ];
        $this->json(
            'POST',
            route('templates.sections.questions.store', [
                'template' => $template->id,
                'section'  => $section2->id,
            ]),
            $params
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_use_only_correct_section_id_when_sync_positions()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();
        $question = $section1->questions()->save(factory(Question::class)->make());
        $positions = $question->positions()->saveMany(factory(Position::class, 5)->make());

        $template->sections()->attach([
            $section1->id,
        ]);

        $params = [
            'positions' => $positions->take(2)->pluck('id')->toArray(),
        ];

        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                [
                    'template' => $template->id,
                    'section'  => $section2->id,
                    'question' => $question->id
                ]
            ),
            $params
        )
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function user_can_use_only_correct_question_id_when_sync_positions()
    {
        factory(User::class)->create();
        factory(TypeOfChecklist::class)->create();

        $template = factory(Template::class)->create();
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();
        $question1 = $section1->questions()->save(factory(Question::class)->make());
        $question2 = $section2->questions()->save(factory(Question::class)->make());
        $positions = $question1->positions()->saveMany(factory(Position::class, 5)->make());

        $template->sections()->attach([
            $section1->id,
        ]);

        $params = [
            'positions' => $positions->take(2)->pluck('id')->toArray(),
        ];

        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                [
                    'template' => $template->id,
                    'section'  => $section1->id,
                    'question' => $question2->id
                ]
            ),
            $params
        )
            ->assertStatus(422);

    }
}
