<?php

namespace Parcours\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entité d'un sous-parcours
 *
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_sousparcours")
 * 
 * @property int $id
 * @property string $titre
 * @property string $description
 * @property Parcours\Entity\Parcours $parcours
 * @property Parcours\Entity\Transition $transitions
 * @property Parcours\Entity\Scene $scenes
 * @property Parcours\Entity\SceneRecommandee $scene_depart
 * @property Parcours\Entity\SousParcours $sous_parcours_suivant
 */
class SousParcours implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=200)
     * @var string
     */
    public $titre;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\Parcours", inversedBy="sous_parcours")
     * @var Parcours\Entity\Parcours
     **/
    public $parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Transition", mappedBy="sous_parcours", cascade={"remove", "persist"})
     * @var Parcours\Entity\Transition[]
     **/
    public $transitions;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Scene", mappedBy="sous_parcours", cascade={"persist", "remove"})
     * @var Parcours\Entity\Scene[]
     **/
    public $scenes;
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SceneRecommandee", cascade={"persist"})
     * @var Parcours\Entity\SceneRecommandee[]
     **/
    public $scene_depart;
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SousParcours", cascade={"persist"})
     * @var Parcours\Entity\TransitionRecommandee[]
     **/
    public $sous_parcours_suivant;

    /**
     * @ORM\ManyToOne(targetEntity="SamUser\Entity\User", inversedBy="sous_parcours_chantier")
     * @var SamUser\Entity\User
     */
    public $utilisateur;

    /**
     * @var object $created
     *
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    public $created;

    /**
     * @var object $updated
     *
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Timestampable
     */
    public $updated;

    /**
     * @var object $utilisateurChange
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"utilisateur"})
     */
    public $utilisateurChange;


    /**
     * Ajout d'une transition au sous-parcours
     * 
     * @param unknown_type $transition
     */
    public function addTransition($transition) {
    	$transition->sous_parcours = $this;
    	if (!$this->transitions->contains($transition)) {
    		$this->transitions->add($transition);
    	}
    }
    
    /**
     * Ajout d'une scène au sous-parcours
     */
    public function addScene($scene) {
    	$scene->sous_parcours = $this;
    	if (!$this->scenes->contains($scene)) {
    		$this->scenes->add($scene);
    	}
    }

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
