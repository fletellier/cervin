<?php

namespace Admin\Form;

use Zend\Form\Form;
use InvalidArgumentException;

/**
 * Formulaire utilisé pour la création d'un utilisateur depuis l'administration
 *
 */
class UserForm extends Form
{
	public function __construct($name = null)
	{
		
		parent::__construct('user');
		$this->setAttribute('method', 'post');
		
		/*$this->add(array(
			'name' => 'id',
			'attributes' => array('type' => 'hidden')
		));*/

		$this->add(array(
			'name' => 'displayName',
			'attributes' => array('type' => 'text','placeholder'=>'Nom / Prénom'),
			'options' => array('label' => 'Nom / prénom')
		));
		
		$this->add(array(
			'name' => 'email',
			'attributes' => array('type'  => 'email','placeholder'=>'Email'),
			'options' => array('label' => 'Email')
		));
		
		$this->add(array(
			'name' => 'username',
			'attributes' => array('type'  => 'text','placeholder'=>'Login'),
			'options' => array('label' => 'Login')
		));

		$this->add(array(
			'name' => 'telephone',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
					'label' => 'Téléphone',
					'size'  => '12'
			)
		));
		
		$this->add(array(
			'name' => 'adresse',
			'type' => 'Zend\Form\Element\Textarea',
			'options' => array(
					'label' => 'Adresse',
					'size'  => '255'
			)
		));
		 
		$this->add(array(
			'name' => 'code_postal',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
					'label' => 'Code Postal',
					'size'  => '5'
			)
		));
		 
		$this->add(array(
			'name' => 'ville',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
					'label' => 'Ville',
					'size'  => '255'
			)
		));
		 
		$this->add(array(
			'name' => 'pays',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
					'label' => 'Pays',
					'size'  => '255'
			)
		));
		 
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Valider',
				'id' => 'submitbutton'
			)
		));
	}
	
}
