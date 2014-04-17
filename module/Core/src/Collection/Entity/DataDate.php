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
 * Spécialisation de la classe Data lorsque la donnée correspondante est au format date
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_datadate")
 * 
 * @property date $date La valeur de la donnée de format date
 * 
 */
class DataDate extends Data
{

	/**
     * @Gedmo\Mapping\Annotation\Versioned
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $date;
	
	/**
     * @Gedmo\Mapping\Annotation\Versioned
	 * @ORM\Column(type="integer", nullable=true)
	 * 	0 : jour
	 * 	1 : mois
	 * 	2 : année
	 */
	protected $format;
	
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
