<?php

namespace Tests\Feature;

use Bido\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;
    use  RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_by_email()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => bcrypt('Abcd@#1234'),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'Abcd@#1234',
        ]);

        $this->assertAuthenticated();
    }

    public function test_user_can_login_by_mobile()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'mobile' => '9011733054',
            'password' => bcrypt('Abcd@#1234'),
        ]);

        $this->post(route('login'), [
            'email' => $user->mobile,
            'password' => 'Abcd@#1234',
        ]);

        $this->assertAuthenticated();
    }
}
