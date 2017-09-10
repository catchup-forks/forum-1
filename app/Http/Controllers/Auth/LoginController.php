<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($driver)
    {
        $data = Socialite::driver($driver)->user();
        Log::debug((array)$data);

        $userObject = [
            'name' => ($data->name) ?: null,
            'email' => $data->email,
        ];

        if (method_exists($this, 'get' . ucfirst($driver) . 'Data')) {
            $userObject = $this->{'get' . ucfirst($driver) . 'Data'}($data, $userObject);
        }

        if (!$user = User::whereEmail($userObject['email'])->first()) {
            $userObject[$driver . '_token'] = $data->token;

            $user = User::create($userObject);
        } else {
            $user->{$driver . '_token'} = $data->token;
            $user->save();
        }

        auth()->loginUsingId($user->id);

        return redirect('/');
    }

    public function handleProviderDeauthorize($driver)
    {
        Log::info(['Deauthorize ' . $driver => request()->getContent()]);
    }

    private function getFacebookData($data, $userObject)
    {
        $gender = $data->user['gender'];

        if ($gender != 'male' && $gender != 'female') {
            $gender = null;
        }

        $userObject['gender'] = $gender;
        $userObject['avatar_path'] = ($data->avatar_original) ?: null;

        return $userObject;
    }

    private function getGoogleData($data, $userObject)
    {
        $gender = null;
        if (isset($data->user['gender'])) $gender = $data->user['gender'];
        if ($gender != 'male' && $gender != 'female') $gender = null;

        $userObject['gender'] = $gender;
        $userObject['avatar_path'] = ($data->avatar) ? $data->avatar . '0' : null;

        return $userObject;
    }
}
