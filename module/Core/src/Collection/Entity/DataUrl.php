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
 * Spécialisation de la classe Data lorsque la donnée correspondante est au format url
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_dataurl")
 * 
 * @property string $url La valeur de la donnée de format url
 * 
 */
class DataUrl extends Data
{

    /**
     * Champs contenant l'url
     * 
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="string", nullable=true)
     */
    protected $url;
	
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
