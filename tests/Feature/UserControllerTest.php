<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    //未ログインユーザーでマイページにアクセス
    public function testGuestShow()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;

        $response = $this->get(route('users.show', ['name' => $user_name]));
        $response->assertRedirect(route('login'));
    }

    //ログインユーザーでマイページにアクセス
    public function testAuthShow()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;

        $response = $this->actingAs($user)->get(route('users.show', ['name' => $user_name]));

        $response->assertStatus(200)->assertViewIs('users.show');
    }

    //未ログインユーザーでプロフィール編集画面にアクセス
    public function testGuestEdit()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;

        $response = $this->get(route('users.edit', ['name' => $user_name]));
        $response->assertRedirect(route('login'));
    }

    //ログインユーザーでプロフィール編集画面にアクセス
    public function testAuthEdit()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;

        $response = $this->actingAs($user)->get(route('users.edit', ['name' => $user_name]));

        $response->assertStatus(200)->assertViewIs('users.edit');
    }

    //プロフィール編集機能
    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;
        $new_name = '面接太郎';

        $this->actingAs($user)->get(route('users.edit', ['name' => $user_name]));

        $response = $this->patch(route('users.update', ['name' => $user_name]), [
            'name' => $new_name,
            'age' => '30',
            'email' => 'test@mail.com',
            'image' => 'https://mensetsu-s3-bucket.s3.ap-northeast-1.amazonaws.com/image/sample.png'
        ]);

        $response->assertRedirect(route('users.show', ['name' => $new_name]));
    }

    //未ログインユーザーでパスワード編集画面にアクセス
    public function testGuestEditPassword()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;

        $response = $this->get(route('users.password.edit', ['name' => $user_name]));
        $response->assertRedirect(route('login'));
    }

    //ログインユーザーでパスワード編集画面にアクセス
    public function testAuthEditPassword()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;

        $response = $this->actingAs($user)->get(route('users.password.edit', ['name' => $user_name]));

        $response->assertStatus(200)->assertViewIs('users.password_edit');
    }

    //パスワード編集処理
    public function testUpdatePassword()
    {
        $user = factory(User::class)->create();
        $user_name = $user->name;

        $response = $this->actingAs($user)->patch(route('users.password.update', ['name' => $user_name]), [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect(route('users.show', ['name' => $user_name]));
    }

}
