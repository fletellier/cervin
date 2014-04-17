<?php
namespace TestsCervin;

use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\SchemaTool;

abstract class Doctrine extends \PHPUnit_Framework_TestCase
{
    protected $application;
    protected $sm;
    protected $em;
    protected $bootstrap;
    protected $emAlias;

    public function setUp()
    {
        $this
            ->setBootstrap(__DIR__ . '/../../bootstrap.php')
            ->setEmAlias('doctrine.entitymanager.orm_default');

        $application = require $this->bootstrap;
        $this->application = $application;
        $this->sm = $application->getServiceManager();
        $this->em = $this->sm->get($this->emAlias);
    }

    public function tearDown()
    {
        unset($this->application);
        unset($this->sm);
        unset($this->em);
    }

    protected function setBootstrap($bootstrap)
    {
        $this->bootstrap = $bootstrap;

        return $this;
    }

    protected function setEmAlias($emAlias)
    {
        $this->emAlias = $emAlias;

        return $this;
    }

    public function testServiceManagerInstance()
    {
        $this->assertInstanceOf(
            'Zend\ServiceManager\ServiceManager',
            $this->sm);
    }

    public function testEmInstance()
    {
        $this->assertInstanceOf(
            'Doctrine\ORM\EntityManager',
            $this->em);
    }
}
