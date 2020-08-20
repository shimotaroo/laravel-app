<?php

namespace Tests\Feature;

use App\Article;
use App\CompanyType;
use App\Phase;
use App\Prefecture;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
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
    public function testAuthCreate()
    {
        $this->withoutExceptionHandling();
        //テストに必要なUserモデルを「準備」
        $user = factory(User::class)->create();

        //ログインして記事投稿画面にアクセスすることを実行
        $response = $this->actingAs($user)->get(route('articles.create'));

        //レスポンスを「検証」
        $response->assertStatus(200)->assertViewIs('articles.create');
    }

    //記事を投稿する
    public function testStore()
    {
        $user = factory(User::class)->create();
        $user_id = $user->id;
        $prefecture_id = factory(Prefecture::class)->create()->id;
        $company_type_id = factory(CompanyType::class)->create()->id;
        $phase_id = factory(Phase::class)->create()->id;

        $this->actingAs($user)->get(route('articles.create'));

        $response = $this->post(route('articles.store'), [
            'user_id' => $user_id,
            'prefecture_id' => $prefecture_id,
            'company_type_id' => $company_type_id,
            'phase_id' => $phase_id,
            'question_content' => 'あああああ',
            'other_information' => 'いいいいい',
            'impression' => 'ううううう',
        ]);

        //'articles.index'にリダイレクトさせる指示ではなく、'articles,index'にリダイレクトしているかをチェック
        $response->assertRedirect(route('articles.index'));
    }

    //未ログインユーザーが投稿編集画面にアクセス
    public function testGuestEdit()
    {
        $article = factory(Article::class)->create();

        $response = $this->get(route('articles.edit', ['article' => $article]));
        $response->assertRedirect(route('login'));
    }

    //ログインユーザーが投稿編集画面にアクセス
    public function testAuthEdit()
    {
        $this->withoutExceptionHandling();
        $article = factory(Article::class)->create();
        $user = $article->user;

        $response = $this->actingAs($user)->get(route('articles.edit', ['article' => $article]));

        $response->assertStatus(200)->assertViewIs('articles.edit');
    }

    //記事を編集する
    public function testUpdate()
    {
        $article = factory(Article::class)->create();
        $prefecture_id = factory(Prefecture::class)->create()->id;
        $company_type_id = factory(CompanyType::class)->create()->id;
        $phase_id = factory(Phase::class)->create()->id;

        $user = $article->user;
        $this->actingAs($user)->get(route('articles.edit', ['article' => $article]));

        $response = $this->patch(route('articles.update', ['article' => $article]), [
            'prefecture_id' => $prefecture_id,
            'company_type_id' => $company_type_id,
            'phase_id' => $phase_id,
            'question_content' => 'あああああ',
            'other_information' => 'いいいいい',
            'impression' => 'ううううう',
        ]);

        $response->assertRedirect(route('articles.index'));
    }

    //記事を削除する
    public function testDestroy()
    {
        $article = factory(Article::class)->create();
        $user = $article->user;

        $this->actingAs($user)->get(route('articles.edit', ['article' => $article]));

        $response = $this->delete(route('articles.destroy', ['article' => $article]));

        $response->assertRedirect(route('articles.index'));
    }

    //投稿編集画面にアクセス
    public function testShow()
    {
        $article = factory(Article::class)->create();

        $response = $this->get(route('articles.show', ['article' => $article]));

        $response->assertStatus(200)->assertViewIs('articles.show');
    }

    //並び替え
    public function testSort()
    {
        $sort = 'asc';

        $response = $this->get(route('articles.sort', ['sort_type' => $sort]));

        $response->assertStatus(200)->assertViewIs('articles.index');
    }
}
