<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entité d'une relation entre deux artefacts
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_artefact_artefact")
 * 
 * @property int $id Id de la relation
 * @property Collection\Entity\Artefact $origine Artefact d'origine de la sémantique
 * @property Collection\Entity\Artefact $destination Artefact de destination de la sémantique
 * @property Collection\Entity\SemantiqueArtefact $semantique Sémantique liée aux artefacts
 */
class RelationArtefacts implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Artefact", inversedBy="relation_origine")
     * @ORM\JoinColumn(name="origine_id", referencedColumnName="id", nullable=false)
     **/
    protected $origine;
    
    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Artefact", inversedBy="relation_destination")
     * @ORM\JoinColumn(name="destination_id", referencedColumnName="id", nullable=false)
     **/
    protected $destination;
    
    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\ManyToOne(targetEntity="Collection\Entity\SemantiqueArtefact", inversedBy="relations")
     * @ORM\JoinColumn(name="semantique_id", referencedColumnName="id", nullable=false)
     **/
    protected $semantique;

    /**
     * Constructeur
     **/
    public function __construct($origine, $destination, $semantique) {
    	$this->origine     = $origine;
    	$this->destination = $destination;
    	$this->semantique  = $semantique;
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
     * Retourne l'objet sous la forme d'un tableau
     *
     * @return array
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
        $this->id = $data['id'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;
        }
    	return $this->inputFilter;
    }
}
