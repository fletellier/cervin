<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entité d'une transition recommandée
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_transitionrecommandee")
 * 
 * @property Parcours\Entity\SceneRecommandee $scene_origine Scène d'origine de la transition recommandée
 * @property Parcours\Entity\SceneRecommandee $scene_destination Scène de destination de la transition recommandée
 */
class TransitionRecommandee extends Transition
{
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SceneRecommandee", inversedBy="transition_recommandee")
     **/
    protected $scene_origine;
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SceneRecommandee", inversedBy="transition_recommandee_entrante")
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
      // A FAIRE
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
       // A FAIRE
    }
}
