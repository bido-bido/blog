<?php

namespace Bido\User\Tests\Feature;

use Bido\User\Models\User;
use Bido\User\Services\VerifyCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_can_see_register_form()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $this->withoutExceptionHandling();
        $response = $this->registerNewUser();

        $response->assertRedirect(route('home'));

        $this->assertCount(1, User::all());
    }

    public function test_user_have_to_verify_account()
    {
        $this->registerNewUser();

        $response = $this->get(route('home'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_user_can_verify_account()
    {
        $user = User::create([
            'name' => 'Mojtaba',
            'email' => 'Mojtaba@yahoo.com',
            'password' => bcrypt('Abcd@#1234'),
        ]);

        $code = VerifyCodeService::generate();

        VerifyCodeService::store($user->id, $code, now()->addDay());

        auth()->loginUsingId($user->id);

        $this->assertAuthenticated();

        $response = $this->post(route('verification.verify'), [
            'verify_code' => $code,
        ]);

        $this->assertEquals(true, $user->fresh()->hasVerifiedEmail());
    }

    public function test_verified_user_can_see_home_page()
    {
        $this->registerNewUser();

        $this->assertAuthenticated();

        auth()->user()->markEmailAsVerified();

        $response = $this->get(route('home'));

        $response->assertOk();
    }

    public function registerNewUser()
    {
        return $this->post(route('register'), [
            'name' => 'MM',
            'email' => 'user3@yahoo.com',
            'mobile' => '9195870199',
            'password' => 'Aabcd@#1234',
            'password_confirmation' => 'Aabcd@#1234',
        ]);
    }
}
