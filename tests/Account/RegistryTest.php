<?php
namespace FinanceGeni\Interview\Tests\Account;

Use FinanceGeni\Interview\Account\Registry;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public function testSetRegistry()
    {
        Registry::set('namespace1', 'key1', 'value1');
        $this->assertEquals(Registry::get('namespace1', 'key1'), 'value1');
    }

    public function testGetRegistry()
    {
        $v = Registry::get('namespace2', 'key2');
        $this->assertEquals($v, null);
    }

    public function testDelRegistry()
    {
        Registry::set('namespace3', 'key3', 'value3');
        Registry::del('namespace3', 'key3');
        $this->assertEquals(Registry::get('namespace3', 'key3'), null);
    }
}
?>