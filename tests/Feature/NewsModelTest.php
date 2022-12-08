<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NewsModelTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    public function setup() :void {
        parent::setup();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * A basic feature test list.
     * @test
     * @return void
     */
    public function newsList()
    {
        $news = News::factory([
            "user_id" => $this->user->id,
        ])->create();
        $response = $this->get(route("news.index"));
        $response->assertStatus(200);
        $response->assertSeeInOrder([$news->title, $news->user->name, $news->content]);
        $response->assertSee(route("news.show", [$news->id]));
    }

    /** 
     * @test
     */
    public function newsHasTitle()
    {
        $news = News::factory([
            "user_id" => $this->user->id,
        ])->make();
        $this->assertNotEmpty($news->title);
    }
    /** 
     * @test
     */
    public function newsHasContent()
    {
        $news = News::factory([
            "user_id" => $this->user->id,
        ])->make();
        $this->assertNotEmpty($news->content);
    }

    /**
     * A basic feature test create.
     * @test
     * @return void
     */
    public function newsCreate()
    {
        $response = $this->get('/news/create');
        $response->assertStatus(200);
        $response->assertSee(route("news.store"));
    }
    /**
     * A basic feature test store.
     * @test
     * @return void
     */
    public function newsStore()
    {
        $title = "Just Random Text";
        $content = "Here is a random content of a message";
        $response = $this->post(route("news.store"), [
            "title" => $title,
            "content" => $content,
        ]);
        $this->assertDatabaseHas("news", [
            "title" => $title,
            "content" => $content,
            "user_id" => $this->user->id,
        ]);
        $response->assertRedirect(route("news.index"));
    }

    /**
     * A basic feature test store missing title.
     * @test
     * @return void
     */
    public function newsStoreMissingTitle()
    {
        $title = "";
        $content = "Here is a random content of a message";
        $response = $this->post(route("news.store"), [
            "title" => $title,
            "content" => $content,
        ]);
        $this->assertDatabaseMissing("news", [
            "title" => $title,
            "content" => $content,
            "user_id" => $this->user->id,
        ]);
        $response->assertSessionHasErrors(["title"]);
    }
    /**
     * A basic feature test store missing title.
     * @test
     * @return void
     */
    public function newsStoreMissingTitleContent()
    {
        $title = "";
        $content = "";
        $response = $this->post(route("news.store"), [
            "title" => $title,
            "content" => $content,
        ]);
        $this->assertDatabaseMissing("news", [
            "title" => $title,
            "content" => $content,
            "user_id" => $this->user->id,
        ]);
        $response->assertSessionHasErrors(["title", "content"]);
    }

    /**
     * A basic feature test logged in user see a news.
     * @test
     * @return void
     */
    public function newsPage()
    {
        $news = News::factory([
            "user_id" => $this->user->id,
        ])->create();
        $response = $this->get(route("news.show", [
            $news->id,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([$news->title, $news->user->name, $news->content]);
        // $response->assertSee(route("news.edit", [$news->id]));
    }


    /**
     * A basic feature test edit news.
     * @test
     * @return void
     */
    public function newsEdit()
    {
        $news = News::factory(["user_id" => $this->user->id])->create();
        $response = $this->get(route("news.edit", [$news->id]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([$news->title, $news->content]);
        $response->assertSee(route("news.update", $news->id));
        $response->assertSee(route("news.destroy", $news->id));
    }

    /**
     * A basic feature test edit news.
     * @test
     * @return void
     */
    public function newsUpdate()
    {
        $news = News::factory(["user_id" => $this->user->id])->create();
        $new_title = "New title here";
        $new_content = "New random content goes here";
        $response = $this->put(route("news.update", $news->id), [
            "title" => $new_title,
            "content" => $new_content,
        ]);
        $this->assertDatabaseHas("news", [
            "title" => $new_title,
            "content" => $new_content,
            "id" => $news->id,
        ]);
        $response->assertRedirect(route("news.show", $news->id));
    }

    /**
     * A basic feature test delete news.
     * @test
     * @return void
     */
    public function newsDelete()
    {
        $news = News::factory(["user_id" => $this->user->id])->create();
        $response = $this->delete(route("news.destroy", $news->id));
        $this->assertDatabaseMissing("news", [
            "title" => $news->title,
            "content" => $news->content,
            "id" => $news->id,
        ]);
        $response->assertRedirect(route("news.index"));
    }


}
