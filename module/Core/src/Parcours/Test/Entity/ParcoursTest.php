<?php

namespace Parcours;

use Doctrine\ORM\EntityManager;

use PHPUnit_Framework_TestCase;

class ParcoursTest extends PHPUnit_Framework_TestCase
{
    public function testParcoursInitialState()
    {
        $parcours = new Entity\Parcours();

        $this->assertNull($parcours->id, '"id" should initially be null');
        $this->assertNull($parcours->titre, '"titre" should initially be null');
        $this->assertNull($parcours->description, '"description" should initially be null');
        $this->assertNull($parcours->sous_parcours, '"sous_parcours" should initially be null');
        $this->assertNull($parcours->transitions, '"transitions" should initially be null');
        
    }
}
