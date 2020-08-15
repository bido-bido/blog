<?php

namespace Bido\User\Tests\Feature;

use Bido\User\Models\User;
use Bido\User\Services\VerifyCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_reset_password_request_form()
    {
        $response = $this->get(route('password.request'));
        $response->assertOk();
    }

    public function test_user_can_see_enter_verify_code_by_correct_email()
    {
        $this->call('get', route('password.sendVerifyCodeEmail'), ['email' => 'user2@yahoo.com'])->assertOk();
    }

    public function test_user_can_not_see_enter_verify_code_by_wrong_email()
    {
        $this->call('get', route('password.sendVerifyCodeEmail'), ['email' => 'user2yahoo.com'])->assertStatus(302); //assertRedirect
    }

    public function test_user_banned_after_6_attempt_to_enter_retrive_code_to_reset_password()
    {
        for ($i = 0; $i < 5; $i++){
            $this->post(route('password.checkVerifyCode'), [
                'verify_code',
                'email' => 'user2@yahoo.com',
            ])->assertStatus(302);
        }

        $this->post(route('password.checkVerifyCode'), [
            'verify_code',
            'email' => 'user2@yahoo.com',
        ])->assertStatus(429);
    }
}