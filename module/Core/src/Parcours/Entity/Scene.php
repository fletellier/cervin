<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entité d'une scène
 * 
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_scene")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"SceneRecommandee" = "SceneRecommandee",
 *                        "SceneSecondaire"  = "SceneSecondaire"})
 * 
 * @property int $id Id d'une scène
 * @property string $titre Titre d'une scène
 * @property string $narration Narration
 * @property Collection\Entity\Element $elements Eléments (artefact ou media) associés à cette scène
 * @property Collection\Entity\SousParcours $sous_parcours 
 * @property Collection\Entity\TransitionInterParcours $transitions_inter_parcours
 * @property Collection\Entity\TransitionSecondaire $transitions_secondaires
 */
class Scene implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public  $id;

    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="string", length=200)
     * @var string
     */
    public $titre;
    
    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text")
     * @var string
     */
    public $narration;
    
    /**
     * @ORM\ManyToMany(targetEntity="Collection\Entity\Element")
	 * @ORM\JoinTable(name="mbo_scene_element")
	 * @var Collection\Entity\Element[]
     **/
    public $elements;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\SousParcours", inversedBy="scenes")
     * @var Parcours\Entity\SousParcours[]
     **/
    public $sous_parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\TransitionInterParcours", mappedBy="scene_origine")
     * @var Parcours\Entity\TransitionInterParcours[]
     **/
    public $transitions_inter_parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\TransitionSecondaire", mappedBy="scene_origine")
     * @var Parcours\Entity\TransitionSecondaire[]
     **/
    public $transitions_secondaires;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\TransitionSecondaire", mappedBy="scene_destination")
     * @var Parcours\Entity\TransitionSecondaire[]
     **/
    public $transitions_secondaires_entrantes;
    
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
     * Return this object in array form.
     *
     * @return array
     */
    public function toArray()
    {
    
    	foreach ($this as $attribute => $value) {
    		if (is_object($value)) {
    			if(get_class($value) == 'Doctrine\\ORM\\PersistentCollection'){
    				$data[$attribute] = $value->toArray(true);
    				foreach ($data[$attribute] as $att => $val){
    					$data[$attribute][$att] = $val->toArray();
    				}
    			}
    		}
    		else{
    			$data[$attribute]= $value;
    		}
    	}
    	return $data;
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
