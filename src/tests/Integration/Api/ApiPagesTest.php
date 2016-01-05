<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiPagesTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }


    public function testResponseGetPages()
    {
        // Setup
        $model = factory(DanPowell\Portfolio\Models\Page::class)->create();

        // Actions
        $this->get(route('api.page.index'));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'id' => $model->id,
            'title' => $model->title,
        ]);
    }


    public function testResponseGetPage()
    {
        // Setup
        $model = factory(DanPowell\Portfolio\Models\Page::class)->create();

        // Actions
        $this->get(route('api.page.show', $model->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'id' => $model->id,
            'title' => $model->title,
        ]);
    }


/*
    public function testResponsePostPage()
    {
        // Setup
        $model = factory(DanPowell\Portfolio\Models\Page::class)->make();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->post(route('api.page.store'), $model->toArray());

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'title' => $model->title,
        ]);
    }
*/


    public function testResponsePutPage()
    {
        // Setup
        $model = factory(DanPowell\Portfolio\Models\Page::class)->create();
        $newModel = factory(DanPowell\Portfolio\Models\Page::class)->make();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->put(route('api.page.update', $model->id), $newModel->toArray());

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'title' => $newModel->title,
        ]);

    }


    public function testResponseDeletePage()
    {
        // Setup
        $model = factory(DanPowell\Portfolio\Models\Page::class)->create();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->delete(route('api.page.destroy', $model->id));

        // Assertions
        $this->assertResponseOk();
        $this->notSeeInDatabase('pages', ['id' => $model->id]);
    }


    // Page Sections

    public function testResponseGetPageSections()
    {
        // Setup
        $relation = factory(DanPowell\Portfolio\Models\Section::class)->make();
        $model = factory(DanPowell\Portfolio\Models\Page::class)->create();
        $model->sections()->save($relation);

        // Actions
        $this->get(route('api.page.section.index', $model->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'markup' => $relation->markup,
        ]);
    }


    public function testResponseGetPageSection()
    {
        // Setup
        $relation = factory(DanPowell\Portfolio\Models\Section::class)->make();
        $model = factory(DanPowell\Portfolio\Models\Page::class)->create();
        $model->sections()->save($relation);

        // Actions
        $this->get(route('api.page.section.show', $model->id, $relation->id));

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'markup' => $relation->markup,
        ]);
    }


    public function testResponsePostPageSection()
    {
        // Setup
        $relation = factory(DanPowell\Portfolio\Models\Section::class)->make();
        $model = factory(DanPowell\Portfolio\Models\Page::class)->create();
        $user = factory(App\User::class)->create();

        // Actions
        $this->actingAs($user);
        $this->post(route('api.page.section.store', $model->id), $relation->toArray());

        // Assertions
        $this->assertResponseOk();
        $this->seeJson([
            'markup' => $relation->markup,
        ]);
    }

}
