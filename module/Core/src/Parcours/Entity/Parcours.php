<?php

namespace Parcours\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Parcours\Entity\SousParcours;
use Parcours\Entity\Scene;

/**
 * Entité d'un parcours
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_parcours")
 * 
 * @property int $id Id du parcours
 * @property string $titre Titre du parcours
 * @property string $description Description du parcours
 * @property Parcours\Entity\SousParcours $sous_parcours Collection de sous-parcours associés au parcours
 * @property Parcours\Entity\SousParcours $sous_parcours_depart Sous-parcours de départ du parcours
 * @property Parcours\Entity\Transition $transitions Collection de transitions associées au parcours
 */
class Parcours implements InputFilterAwareInterface
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
     * @ORM\Column(type="string", length=200)
     */
    protected $titre;

    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\SousParcours", mappedBy="parcours", cascade={"persist", "remove"})
     **/
    protected $sous_parcours;
    
    /**
     * @ORM\OneToOne(targetEntity="Parcours\Entity\SousParcours", cascade={"persist"})
     **/
    protected $sous_parcours_depart;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Transition", mappedBy="parcours", cascade={"remove", "persist"})
     **/
    protected $transitions;

    /**
     * Etat du parcours : brouillon ou public
     *
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="boolean")
     */
    protected $public;
    
    /**
     * Ajoute un sous parcours au parcours
     * 
     * @param Parcours\Entity\SousParcours Sous Parcours
     * @return void
     */
    public function addSousParcours($sous_parcours) {
    	$sous_parcours->parcours = $this;
    	if (!$this->sous_parcours->contains($sous_parcours)) {
    		$this->sous_parcours->add($sous_parcours);
    	}
    }
    
    /**
     * Ajoute une transition au parcours
     * 
     * @param Parcours\Entity\Transition Transition
     * @return void
     */
    public function addTransition($transition) {
    	$transition->parcours = $this;
    	if (!$this->transitions->contains($transition)) {
    		$this->transitions->add($transition);
    	}
    }
    
    /**
     * Constructeur de la classe
     * 
     * Constructeur : on initialise le parcours avec uns seul sous parcours 
     * contenant une seule scène recommandée
     * 
     * @return void
     */
    public function __construct() {
        $SousParcours = new SousParcours();
        $SousParcours->titre = 'Nouveau sous-parcours';
        $SousParcours->description = 'Description du sous Parcours';
        $SousParcours->scenes = new \Doctrine\Common\Collections\ArrayCollection();
        $SousParcours->transitions = new \Doctrine\Common\Collections\ArrayCollection();

        $Scene = new SceneRecommandee();
        $Scene->titre = 'Nouvelle scène';
        $Scene->narration = 'Narration à écrire...';
        $SousParcours->addScene($Scene);
        $SousParcours->scene_depart = $Scene;

        $this->sous_parcours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addSousParcours($SousParcours);
        $this->sous_parcours_depart = $SousParcours;
        $this->public = false;
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
     * @return void
     */
    public function populate($data = array())
    {
        $this->id = $data['id'];
        $this->description = $data['description'];
        $this->titre = $data['titre'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
             
            $inputFilter->add($factory->createInput(array(
                    'name' => 'id',
                    'required' => true,
                    'filters' => array(array('name' => 'Int')),
            )));
             
            $inputFilter->add($factory->createInput(array(
                    'name' => 'titre',
                    'required' => true,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                            array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'encoding' => 'UTF-8',
                                            'min' => 1,
                                            'max' => 200,
                                    ),
                            ),
                    ),
            )));
             
            $inputFilter->add($factory->createInput(array(
                    'name' => 'description',
                    'required' => false,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                    ),
            )));
            $this->inputFilter = $inputFilter;
            
        }
        return $this->inputFilter;
    }
}
