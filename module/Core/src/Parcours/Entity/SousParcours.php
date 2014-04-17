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
     */
    protected $id;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=200)
     */
    protected $titre;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parcours\Entity\Parcours", inversedBy="sous_parcours")
     **/
    protected $parcours;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Transition", mappedBy="sous_parcours", cascade={"remove", "persist"})
     **/
    protected $transitions;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Scene", mappedBy="sous_parcours", cascade={"persist", "remove"})
     **/
    protected $scenes;
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SceneRecommandee", cascade={"persist"})
     **/
    protected $scene_depart;
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SousParcours", cascade={"persist"})
     **/
    protected $sous_parcours_suivant;

    /**
     * @ORM\ManyToOne(targetEntity="SamUser\Entity\User", inversedBy="sous_parcours_chantier")
     */
    protected $utilisateur;

    /**
     * @var date $created
     *
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var date $updated
     *
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Timestampable
     */
    private $updated;

    /**
     * @var datetime $utilisateurChange
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"utilisateur"})
     */
    protected $utilisateurChange;


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
