<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiProjectsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }


    public function testResponseGetProjects()
    {
        // Setup
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();

        // Actions
        $this->get(route('api.project.index'));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'id' => $project->id,
            'title' => $project->title,
        ]);
    }


    public function testResponseGetProject()
    {
        // Setup
        $model = factory(DanPowell\Portfolio\Models\Project::class)->create();

        // Actions
        $this->get(route('api.project.show', $model->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'id' => $model->id,
            'title' => $model->title,
        ]);
    }


    public function testResponsePostProject()
    {
        // Setup
        $project = factory(DanPowell\Portfolio\Models\Project::class)->make();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->post(route('api.project.store'), $project->toArray());

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'title' => $project->title,
        ]);
    }


    public function testResponsePutProject()
    {
        // Setup
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $newProject = factory(DanPowell\Portfolio\Models\Project::class)->make();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->put(route('api.project.update', $project->id), $newProject->toArray());

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'title' => $newProject->title,
        ]);

    }


    public function testResponseDeleteProject()
    {
        // Setup
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->delete(route('api.project.destroy', $project->id));

        // Assertions
        $this->assertResponseOk();
        $this->notSeeInDatabase('projects', ['id' => $project->id]);
    }



    // Project Sections

    public function testResponseGetProjectSections()
    {
        // Setup
        $section = factory(DanPowell\Portfolio\Models\Section::class)->make();
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $project->sections()->save($section);

        // Actions
        $this->get(route('api.project.section.index', $project->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'markup' => $section->markup,
        ]);
    }


    public function testResponseGetProjectSection()
    {
        // Setup
        $section = factory(DanPowell\Portfolio\Models\Section::class)->make();
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $project->sections()->save($section);

        // Actions
        $this->get(route('api.project.section.show', $project->id, $section->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'markup' => $section->markup,
        ]);
    }


    public function testResponsePostProjectSection()
    {
        // Setup
        $section = factory(DanPowell\Portfolio\Models\Section::class)->make();
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->post(route('api.project.section.store', $project->id), $section->toArray());

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'markup' => $section->markup,
        ]);
    }


    // Project Pages

    public function testResponseGetProjectPages()
    {
        // Setup
        $page = factory(DanPowell\Portfolio\Models\Page::class)->make();
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $project->pages()->save($page);

        // Actions
        $this->get(route('api.project.page.index', $project->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'title' => $page->title,
        ]);
    }


    public function testResponseGetProjectPage()
    {
        // Setup
        $page = factory(DanPowell\Portfolio\Models\Page::class)->make();
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $project->pages()->save($page);

        // Actions
        $this->get(route('api.project.page.show', $project->id, $page->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'title' => $page->title,
        ]);
    }


    public function testResponsePostProjectPage()
    {
        // Setup
        $page = factory(DanPowell\Portfolio\Models\Page::class)->make();
        $project = factory(DanPowell\Portfolio\Models\Project::class)->create();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->post(route('api.project.page.store', $project->id), $page->toArray());

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'title' => $page->title,
        ]);
    }

}
