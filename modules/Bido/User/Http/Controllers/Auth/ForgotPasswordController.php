<?php

namespace Bido\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Bido\User\Repositories\UserRepo;
use Bido\User\Services\VerifyCodeService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Bido\User\Http\Requests\ResetPasswordVerifyCodeRequest;
use Bido\User\Http\Requests\SendResetPasswordVerifyCodeRequest;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controllers
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    //override by Me
//    public function showLinkRequestForm()
//    {
//        return view('User::Front.passwords.email');
//    }

    public function showVerifyCodeRequestForm()
    {
        return view('User::Front.passwords.email');
    }

    public function sendVerifyCodeEmail(SendResetPasswordVerifyCodeRequest $request, UserRepo $userRepo)
    {
        //todo email validation

        $user = $userRepo->findByEmail($request->email);

        //todo check if code exist
        if($user && !VerifyCodeService::has($user->id)){
            $user->sendResetPasswordNotification();
        }

        return view('User::Front.passwords.enter-verify-code-form');
    }

    public function checkVerifyCode(ResetPasswordVerifyCodeRequest $request)
    {
        $user = resolve(UserRepo::class)->findByEmail($request->email);

        if($user == null || !VerifyCodeService::check($user->id, $request->verify_code)){
            return back()->withErrors(['verify_code'=>'کد وارد شده معتبر نمی باشد!']);
        }

        auth()->loginUsingId($user->id);

        return redirect()->route('password.showResetForm');
    }

}
