<?php

namespace Parcours\Form;

use Zend\Form\Form;
use InvalidArgumentException;

/**
 * Formulaire utilisé pour la création d'un parcours
 *
 */
class ParcoursForm extends Form
{
	public function __construct($name = null)
	{
		
		parent::__construct('semantique');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'id',
			'attributes' => array('type' => 'hidden')
			));

		
		$this->add(array(
			'name' => 'titre',
			'attributes' => array('type' => 'text','placeholder'=>'Titre [max 200]'),
			'options' => array('label' => 'Titre')
			));
		$this->add(array(
			'name' => 'description',
			'attributes' => array('type'  => 'textarea','placeholder'=>'Description'),
			'options' => array('label' => 'Description')
		));
		
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
