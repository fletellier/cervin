<?php
namespace Collection\Test;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Collection\Entity\TypeElement;
use Collection\Entity\Champ;
use Collection\Form\ChampTypeElementForm;

use PHPUnit_Framework_TestCase;

/**
 * Classe permettant d'effectuer des tests unitaires sur les types élément
 */
class ChampTypeElementFormTest extends PHPUnit_Framework_TestCase
{
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testChampTypeElementFormError() {
		$form = new ChampTypeElementForm('Argument Invalide');
	}
	
	public function testChampTypeElementFormOK() {
		$type_element = new TypeElement('Exemple de type d\'artefact', 'artefact');
		$champ1 = new Champ('Label pour le texte', $type_element, 'texte');
		$champ2 = new Champ('Label pour la date', $type_element, 'date');
		$champs = array($champ1, $champ2);
		$type_element->__set('champs', $champs);
		$form = new ChampTypeElementForm($type_element);

		$this->assertNotNull($form->get($champ1->id));
		$this->assertNotNull($form->get($champ2->id));
		
	}
	
}
