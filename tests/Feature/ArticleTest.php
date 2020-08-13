<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    //記事一覧表示画面にアクセス
    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)->assertViewIs('articles.index');
    }

    //未ログインユーザーが投稿画面にアクセス
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));
        $response->assertRedirect(route('login'));
    }

    //ログインユーザーが投稿画面にアクセス
    public function testAtuhCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('articles.create'));

        $response->assertStatus(200)->assertViewIs('articles.create');
    }


}
