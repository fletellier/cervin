<?php
namespace SamUser;

use Doctrine\ORM\EntityManager;
use SamUser\Entity\User;

use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testUserInitialState()
    {
        $user = new Entity\User();

        $this->assertNull($user->getId(), '"id" should initially be null');
        $this->assertNull($user->getUsername(), '"username" should initially be null');
        $this->assertNull($user->getEmail(), '"email" should initially be null');
        $this->assertNull($user->getDisplayName(), '"displayName" should initially be null');
        $this->assertNull($user->getPassword(), '"password" should initially be null');
        $this->assertNull($user->getState(), '"state" should initially be null');
        $this->assertEmpty($user->getRoles(), '"roles" should initially be empty');
    }
}
