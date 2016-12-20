<?php
namespace FinanceGeni\Interview\Tests\Account;

use FinanceGeni\Interview\Account\Helper;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    public function testValidLuhn10()
    {
        $valid = Helper::isValidLuhn10(4111111111111111);
        $this->assertEquals($valid, true);
    }

    public function testInValidLuhn10()
    {
        $valid = Helper::isValidLuhn10(1234567890123456);
        $this->assertEquals($valid, false);
    }

    public function testIncorrectLengthValidLuhn10()
    {
        $valid = Helper::isValidLuhn10(11111111111111);
        $this->assertEquals($valid, false);

        $valid = Helper::isValidLuhn10(111111111111112029);
        $this->assertEquals($valid, false);
    }

}