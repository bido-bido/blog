<?php

namespace Bido\User\Http\Controllers\Auth;

use Bido\User\Services\UserService;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Bido\User\Http\Requests\ChangePasswordRequest;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controllers
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    //override by me
    public function showResetForm()
    {
        return view('User::Front.passwords.reset');
    }

    public function reset(ChangePasswordRequest $request)
    {
        UserService::changePassword(auth()->user(), $request->password);

        return redirect()->route('home');
    }
}
