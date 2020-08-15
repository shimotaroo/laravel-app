<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //ユーザーページ表示
    public function show(string $name)
    {
        $user = User::where('name', $name)->first()->load(['articles.user', 'articles.prefecture', 'articles.companyType', 'articles.phase', 'articles.likes']);
        //投稿した記事
        $post_articles = $user->articles->sortByDesc('created_at');
        //いいねした記事
        $like_articles = $user->likes->sortByDesc('created_at');

        return view('users.show', [
            'user' => $user,
            'post_articles' => $post_articles,
            'like_articles' => $like_articles,
        ]);
    }

    //プロフィール編集画面
    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit', ['user' => $user]);
    }

    //プロフィール編集処理
    public function update(UserRequest $request, string $name)
    {

        $user = User::where('name', $name)->first();
        $all_request = $request->all();

        $profile_image = $request->file('image');
        if ($profile_image) {
            $all_request['image'] = $this->saveProfileImage($profile_image, $user->id);
        }

        $user->fill($all_request)->save();
        return redirect()->route('users.show', ["name" => $user->name]);
    }

    //画像の名前変更、storageに保存
    public function saveProfileImage($profile_image, $id)
    {
        //インスタンス取得
        $image = \Image::make($profile_image);
        //リサイズ
        $image->fit(80, 80, function($constraint){
            $constraint->upsize();
        });
        //保存
        $file_name = 'profile_'.$id.'.'.$profile_image->getClientOriginalExtension();
        $save_path = 'storage/'.$file_name;
        $image->save($save_path);

        return $file_name;
    }

    //パスワード編集画面
    public function editPassword(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.password_edit', ['user' => $user]);
    }

    //パスワード編集処理
    public function updatePassword(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        //現在のパスワードが合っているかチェック
        if(!(Hash::check($request->current_password, $user->password)))
        {
            return redirect()->back()
                ->withInput()->withErrors(['current_password' => '現在のパスワードが違います']);
        }

        //現在のパスワードと新しいパスワードが違うかチェック
        if($request->current_password === $request->password)
        {
            return redirect()->back()
                ->withInput()->withErrors(['password' => '現在のパスワードと新しいパスワードが変わっていません']);
        }

        $this->passwordValidator($request->all())->validate();

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('users.show', ["name" => $user->name]);
    }

    public function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}

