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
 * Spécialisation de la classe Data lorsque la donnée correspondante est au format fichier
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_datafichier")
 * 
 * @property string $fichier La valeur de la donnée de format fichier (chemin vers le fichier uploadé)
 * @property string $format_fichier Le format du fichier
 */
class DataFichier extends Data
{

	/**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text", nullable=true)
     */
    protected $fichier;
    
    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text", nullable=true)
     */
    protected $format_fichier;
	
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
