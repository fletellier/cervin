<?php

namespace Collection\Form;

use Zend\Form\Form;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

/**
 * Formulaire utilisé pour la création d'une nouvelle sémantique des relations entre artefacts
 */
class SemantiqueForm extends Form
{
	public function __construct($TypeElement, $name = null)
	{
		
		parent::__construct('semantique');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'id',
			'attributes' => array('type' => 'hidden')
			));

		$this->add(array(
			'type' => 'Zend\Form\Element\Select',
			'name' => 'type_origine',
			'options' => array(
				'label' => 'Type origine',
				'empty_option' => 'Type origine',
				'value_options' => $TypeElement
				)
			));
		
		$this->add(array(
			'name' => 'semantique',
			'attributes' => array('type' => 'text'),
			'options' => array('label' => 'Sémantique')
			));
		
		$this->add(array(
				'name' => 'description',
				'attributes' => array('type' => 'textarea'),
				'options' => array('label' => 'Description')
		));

		$this->add(array(
			'type' => 'Zend\Form\Element\Select',
			'name' => 'type_destination',
			'options' => array(
				'label' => 'Type destination',
				'empty_option' => 'Type destination',
				'value_options' => $TypeElement
				)
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
