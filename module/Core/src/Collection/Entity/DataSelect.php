<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;

/**
 * Spécialisation de la classe Data lorsque la donnée correspondante est au format dateselect
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_dataselect")
 * 
 * @property Collection\Entity\SelectOption $option es l'option choisie du Data Select
 * 
 */
class DataSelect extends Data
{

    /**
     * Valeur du select
     * 
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\ManyToOne(targetEntity="Collection\Entity\SelectOption", inversedBy="datas")
     **/
    protected $option;
	
	/**
	 * Magic getter to expose protected properties.
	 *
	 * @param string $property
	 * @return mixed
	 */
	public function __get($property)
	{
		return $this->$property;
	}

	/**
	 * Magic setter to save protected properties.
	 *
	 * @param string $property
	 * @param mixed $value
	 */
	public function __set($property, $value)
	{
		$this->$property = $value;
	}


}
