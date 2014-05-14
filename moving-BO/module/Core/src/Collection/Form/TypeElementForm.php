<?php

namespace Collection\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

/**
 * Formulaire utilisé pour la création d'un nouveau type d'élément
 *
 */
class TypeElementForm extends Form
{
	public function __construct($name = null)
	{
		
		parent::__construct('typeelement');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'id',
			'attributes' => array('type' => 'hidden')
		));
		

		$nom = new Element\Text();
		$nom->setName('nom')
			->setLabel('Nom du type d\'élément')
			->setAttributes(array(
				'type' => 'text'
			));
		$this->add($nom);
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Valider',
				'id' => 'submitbutton'
			),
		));
		
	}
	
}
