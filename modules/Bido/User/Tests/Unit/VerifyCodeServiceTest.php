<?php

namespace Bido\User\Tests\Unit;




use Tests\TestCase;
use Bido\User\Services\VerifyCodeService;

class VerifyCodeServiceTest extends TestCase
{
    public function test_generated_code_id_6_digit()
    {
        $code = VerifyCodeService::generate();
        $this->assertIsNumeric($code,'Generated Code is Not Numeric');
        $this->assertLessThanOrEqual(999999, $code, 'Generated Code is Less than 999999');
        $this->assertGreaterThanOrEqual(100000, $code, 'Generated Code is Less than 100000');
    }

    public function test_verify_code_can_store()
    {
        $code = VerifyCodeService::generate();
        VerifyCodeService::store(1, $code, 120);
        $this->assertEquals($code, cache()->get('verify_code_1'));
    }
}