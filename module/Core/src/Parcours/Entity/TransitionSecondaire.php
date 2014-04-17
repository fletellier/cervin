<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entité d'une transition secondaire
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_transitionsecondaire")
 * 
 * @property Parcours\Entity\Scene $scene_origine Scène d'origine de la transition secondaire
 * @property Parcours\Entity\Scene $scene_destination Scène de destination de la transition secondaire
 */
class TransitionSecondaire extends Transition
{

    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\Scene", inversedBy="transitions_secondaires")
     **/
    protected $scene_origine;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\Scene", inversedBy="transitions_secondaires_entrantes")
     **/
    protected $scene_destination;    
    
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

    /**
     * Retourne l'objet sous forme de tableau
     *
     * @return array Objet au format tableau
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
     public function populate($data = array())
    {

    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {

    }
}
