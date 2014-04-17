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
 * Spécialisation de la classe Data lorsque la donnée correspondante est une donnée géographique
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_datageoposition")
 * 
 * @property decimal $latitude La latitude de la position
 * @property decimal $longitude La longitude de la position
 * @property text $adresse adresse de la position
 */
class DataGeoposition extends Data
{

	/**
     * @Gedmo\Mapping\Annotation\Versioned
	 * @ORM\Column(type="decimal", precision=18, scale=15)
	 */
	protected $latitude;
	
	/**
     * @Gedmo\Mapping\Annotation\Versioned
	 * @ORM\Column(type="decimal", precision=18, scale=15)
	 */
	protected $longitude;

	/**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text", nullable=true)
     */
    protected $adresse;

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
