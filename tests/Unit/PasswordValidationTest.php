<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Bido\User\Rules\ValidPassword;

class PasswordValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_password_should_not_be_less_than_6_character()
    {
        $result = (new ValidPassword())->passes('','Abc1@');

        $this->assertEquals(0, $result);
    }

    public function test_password_should_include_sign_character()
    {
        $result = (new ValidPassword())->passes('','Abcd1234');

        $this->assertEquals(0, $result);
    }

    public function test_password_should_include_digit_character()
    {
        $result = (new ValidPassword())->passes('', 'Abcd@#^&');

        $this->assertEquals(0, $result);
    }

    public function test_password_should_include_capital_character()
    {
        $result = (new ValidPassword())->passes('', 'bcd@#^&');

        $this->assertEquals(0, $result);
    }

    public function test_password_should_include_small_character()
    {
        $result = (new ValidPassword())->passes('', 'ABCDF@#^&');

        $this->assertEquals(0, $result);
    }
}
