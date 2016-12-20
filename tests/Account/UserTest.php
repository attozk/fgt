<?php
namespace FinanceGeni\Interview\Tests\Account;

Use FinanceGeni\Interview\Account\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testUserStuff()
    {
        $user = User::getInstance('User Name 1');
        $this->assertInstanceOf('\FinanceGeni\Interview\Account\User', $user);
        $this->assertEquals($user->getName(), 'User Name 1');
        $this->assertEquals($user->getBalance(), '$0');
    }

    public function testUserAddCard()
    {
        $user = User::getInstance('User Name 2');
        $user->addCard('4111111111111111', 100);
        $this->assertEquals($user->isCardValid(), true);
        $this->assertEquals($user->getBalance(), '$100');
    }

    public function testUserAddCardInvalid()
    {
        $user = User::getInstance('User Name 3');
        $user->addCard('1234567890123456', 100);
        $this->assertEquals($user->isCardValid(), false);
        $this->assertEquals($user->getBalance(), '$0');
    }
}
?>