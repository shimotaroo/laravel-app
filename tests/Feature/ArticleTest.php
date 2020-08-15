<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    //isLikedByUserメソッドの引数がnullの場合
    public function testIsLikedByNull()
    {
        $article = factory(Article::class)->create();

        $result = $article->isLikedByUser(null);

        $this->assertFalse($result);
    }

    //いいねしているケース
    public function testIsLikedByUser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $article->likes()->attach($user);

        $result = $article->isLikedByUser($user);

        $this->assertTrue($result);
    }

    //いいねしていないケース
    public function testIsLikedByAnotheruser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another_user = factory(User::class)->create();
        $article->likes()->attach($another_user);

        $result = $article->isLikedByUser($user);

        $this->assertFalse($result);
    }

}
