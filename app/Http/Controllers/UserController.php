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
        $user = User::where('name', $name)->first();
        //投稿した記事
        $postArticles = $user->articles->sortByDesc('created_at');
        //いいねした記事
        $likeArticles = $user->likes->sortByDesc('created_at');

        return view('users.show', [
            'user' => $user,
            'postArticles' => $postArticles,
            'likeArticles' => $likeArticles,
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
        $allRequest = $request->all();

        $profileImage = $request->file('image');
        if ($profileImage) {
            $allRequest['image'] = $this->saveProfileImage($profileImage, $user->id);
        }

        $user->fill($allRequest)->save();
        return redirect()->route('users.show', ["name" => $user->name]);
    }

    //画像の名前変更、storageに保存
    public function saveProfileImage($profileImage, $id)
    {
        //インスタンス取得
        $image = \Image::make($profileImage);
        //リサイズ
        $image->fit(80, 80, function($constraint){
            $constraint->upsize();
        });
        //保存
        $fileName = 'profile_'.$id.'.'.$profileImage->getClientOriginalExtension();
        $savePath = 'storage/'.$fileName;
        $image->save($savePath);

        return $fileName;
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

        // dd((Hash::check($request->current_password, $user->password)));

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

