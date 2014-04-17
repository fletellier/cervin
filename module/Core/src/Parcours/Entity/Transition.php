<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entité d'une transition
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_transition")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"TransitionRecommandee"   = "TransitionRecommandee",
 *                        "TransitionSecondaire"    = "TransitionSecondaire",
 *                        "TransitionInterParcours" = "TransitionInterParcours"})
 * 
 * @property int $id Id d'une transition
 * @property string $narration
 * @property Parcours\Entity\SemantiqueTransition $semantique
 * @property Parcours\Entity\Parcours $parcours
 * @property Parcours\Entity\SousParcours $sous_parcours
 */
class Transition implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text")
     */
    protected $narration;
    
    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\SemantiqueTransition")
     **/
    protected $semantique;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\Parcours", inversedBy="transitions")
     **/
    protected $parcours;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\SousParcours", inversedBy="transitions")
     **/
    protected $sous_parcours;
    
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
