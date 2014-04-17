<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;
use Collection\Entity\Element;

/**
 * Spécialisation de la classe Data lorsque la donnée correspondante est au format textarea
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_datatextarea")
 * 
 * @property string $textarea La valeur de la donnée de format textarea
 * 
 */
class DataTextarea extends Data
{

    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text", nullable=true)
     */
    protected $textarea;
	
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
