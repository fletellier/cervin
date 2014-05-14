<?php

namespace Parcours\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

/**
 * Formulaire utilisé pour la création d'une 
 * sémantique des transitions entre scènes
 *
 */
class SemantiqueTransitionForm extends Form
{
	public function __construct($name = null)
	{
		
		parent::__construct('semantique');
		$this->setAttribute('method', 'post');
		
		$hidden = new Element\Hidden();
		$hidden->setName('id')
			->setAttributes(array(
				'type'  => 'hidden'
		));
		$this->add($hidden);
		
		/*
		$semantique = new Element\Text();
		$semantique->setName('semantique')
					->setLabel('Semantique');
		$this->add($semantique);
		//*/

		$this->add(array(
			'name' => 'semantique',
			'attributes' => array('type' => 'text'),
			'options' => array('label' => 'Sémantique')
		));
		
		$description = new Element\Textarea();
		$description->setName("description")
					->setLabel("Description");
		$this->add($description);
		
		$button = new Element\Button('submit');
		$button->setLabel('Valider')
				->setValue('submit')
				->setAttributes(array(
					'type'  => 'submit',
					'value' => 'Valider',
					'id' => 'submitbutton',
					'class' => 'btn btn-primary',
		));
		$this->add($button);
		
	}
	
}
