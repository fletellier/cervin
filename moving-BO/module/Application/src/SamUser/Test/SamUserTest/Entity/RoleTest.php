<?php
namespace SamUser;

use Doctrine\ORM\EntityManager;
use SamUser\Entity\Role;

use PHPUnit_Framework_TestCase;

class RoleTest extends PHPUnit_Framework_TestCase
{
    public function testRoleInitialState()
    {
        $role = new Entity\Role();

        $this->assertNull($role->getId(), '"id" should initially be null');
        $this->assertNull($role->getRoleId(), '"roleId" should initially be null');
        $this->assertNull($role->getParent(), '"parent" should initially be null');
    }
}
