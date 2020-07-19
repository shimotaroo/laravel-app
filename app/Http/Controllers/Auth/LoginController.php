<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //Googleアカウント選択画面へリダイレクト
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    //Googleアカウントでログイン可能にする
    public function handleProviderCallback(Request $request, string $provider)
    {
        $providerUser = Socialite::driver($provider)->user();

        $user = User::where('email', $providerUser->getEmail())->first();

        if($user) {
            //trueでログアウトをしない限りログイン状態を維持できる
            $this->guard()->login($user, true);
            return $this->sendLoginResponse($request);
        }

        //$userがnullの場合の処理（メールアドレスを登録してない場合）
        return redirect()->route('register.{provider}', [
            'provider' => $provider,
            'email' => $providerUser->getEmail(),
            'token' => $providerUser->token,
        ]);
    }
}
