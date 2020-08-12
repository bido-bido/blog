<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Bido\User\Rules\ValidMobile;

class MobileValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mobile_can_not_be_less_than_10_character()
    {
        $result = (new ValidMobile())->passes('','919587019');

        $this->assertEquals(0, $result);
    }

    public function test_mobile_can_not_be_more_than_10_character()
    {
        $result = (new ValidMobile())->passes('','919587019788');

        $this->assertEquals(0, $result);
    }

    public function test_mobile_should_start_by_9()
    {
        $result = (new ValidMobile())->passes('','3195870197');

        $this->assertEquals(0, $result);
    }
}
