<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\PasswordValidation;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:15', 'unique:users'],
            'age' => ['numeric', 'min:1', 'max:100', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', new PasswordValidation, 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'age' => $data['age'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showProviderUserRegistrationForm(Request $request, string $provider)
    {
        $token = $request->token;
        $provider_user = Socialite::driver($provider);

        //google
        if ($provider === 'google') {
            $provider_user = $provider_user->userFromToken($token);

            return view('auth.social_register', [
                'provider' => $provider,
                'email' => $provider_user->getEmail(),
                'token' => $provider_user->token,
            ]);

        //twitter
        } elseif ($provider === 'twitter') {
            $token_secret = $request->token_secret;
            $provider_user = $provider_user->userFromTokenAndSecret($token, $token_secret);

            return view('auth.social_register', [
                'provider' => $provider,
                'email' => $provider_user->getEmail(),
                'token' => $provider_user->token,
                'token_secret' => $provider_user->token_secret,
            ]);
        }
    }

    public function registerProviderUser(Request $request, string $provider)
    {
        //google
        if($provider === 'google') {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:15', 'unique:users'],
                'age' => ['numeric', 'min:1', 'max:100', 'nullable'],
                'token' => ['required', 'string'],
            ]);
        } elseif($provider === 'twitter') {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:15', 'unique:users'],
                'age' => ['numeric', 'min:1', 'max:100', 'nullable'],
                'token' => ['required', 'string'],
                'token_secret' => ['required', 'string'],
            ]);
        }

        $token = $request->token;
        $provider_user = Socialite::driver($provider);

        if ($provider === 'google') {
            $provider_user = $provider_user->userFromToken($token);
        } elseif ($provider === 'twitter') {
            $token_secret = $request->token_secret;
            $provider_user = $provider_user->userFromTokenAndSecret($token, $token_secret);
        }

        $user = User::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $provider_user->getEmail(),
            'password' => null,
        ]);

        $this->guard()->login($user, true);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}
