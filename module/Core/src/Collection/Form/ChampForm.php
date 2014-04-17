<?php

namespace Collection\Form;

use Zend\Form\Form;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

/**
 * Formulaire utilisé pour la création d'un nouveau champ dans un type d'élément
 *
 */
class ChampForm extends Form
{
	public function __construct($name = null)
	{
		
		parent::__construct('champ');
		$this->setAttribute('method', 'post');

		$this->add(array(
			'name' => 'id',
			'attributes' => array('type'  => 'hidden')
		));
		
		$this->add(array(
			'name' => 'label',
			'attributes' => array('type'  => 'text'),
			'options' => array('label' => 'Label')
		));
		
		$this->add(array(
			'name' => 'description',
			'attributes' => array('type'  => 'textarea'),
			'options' => array('label' => 'Description')
		));
		
		$this->add(array(
           	'type' => 'select',
            'name' => 'format',
            'options' => array(
                'label' => 'Format',
                'value_options' => array(
                    'texte' => 'Texte',
                    'textarea' => 'Zone de texte',
                    'date' => 'Date',
                    'nombre' => 'Nombre',
                    'fichier' => 'Fichier',
                    'url' => 'URL',
                    'geoposition' => 'Position géographique'
                ),
            ),
            'attributes' => array(
                'value' => 'text' //set selected to 'text'
            )
        ));
		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
					'type'  => 'submit',
					'value' => 'Ajouter',
					'id' => 'submitbutton'
				),
		));
		
	}
	
}
