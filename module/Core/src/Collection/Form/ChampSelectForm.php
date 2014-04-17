<?php

namespace Collection\Form;

use Zend\Form\Form;
use InvalidArgumentException;
use Collection\Entity\TypeElement;

/**
 * Formulaire utilisé pour la création d'un nouveau champ dans un type d'élément
 *
 */
class ChampSelectForm extends Form
{
	public function __construct($selects,$name = null)
	{
		
		parent::__construct('ChampSelect');
		$this->setAttribute('method', 'post');
		$this->setAttribute('class','ajChampSelectForm form-horizontal no-submit');

		$this->add(array(
			'name' => 'id',
			'attributes' => array('type'  => 'hidden')
		));

		$this->add(array(
			'name' => 'label',
			'attributes' => array('type'  => 'text',
				'placeholder' => 'Label'),
			'options' => array('label' => 'Label')
		));

		$this->add(array(
           	'type' => 'select',
            'name' => 'select',
            'options' => array(
                'label' => 'Select',
                'value_options' => $selects
            ),
            'attributes' => array(
                'value' => 'text',
            )
        ));
		
		$this->add(array(
			'name' => 'description',
			'attributes' => array(
				'type'  => 'textarea',
				'placeholder' => 'Description',
				),
			'options' => array(
					'label' => 'Description'
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
