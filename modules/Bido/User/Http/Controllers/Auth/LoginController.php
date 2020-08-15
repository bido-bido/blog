<?php

namespace Bido\User\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Doctrine\DBAL\Schema\AbstractAsset;
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

    //override by me from AuthenticatesUsers trait
    public function credentials(Request $request)
    {
        $userName = $request->get($this->username());

        $field = filter_var($userName, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        return [
            $field => $userName,
            'password' => $request->get('password'),
        ];
    }


    public function showLoginForm()
    {
        return view('User::Front.login');
    }
}
