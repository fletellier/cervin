<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entité de la valeur d'un champ d'un élément (data)
 * 
 * Un objet data se spécialise en DataTexte, DataUrl, DataDate, Datafichier, DataTextarea, ou DataNombre
 * selon le format de la donnée qu'il contient défini par le champ auquel il est associé
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_data")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"DataDate" = "DataDate", 
 *                        "DataFichier" = "DataFichier", 
 *                        "DataNombre" = "DataNombre", 
 *                        "DataTexte" = "DataTexte", 
 *                        "DataUrl" = "DataUrl", 
 *                        "DataSelect" = "DataSelect", 
 *                        "DataTextarea" = "DataTextarea",
 *                        "DataGeoposition" = "DataGeoposition"
 *                        })
 * 
 * @property int $id Identifiant unique du data
 * @property \Collection\Entity\Element $element L'élément de la collection auquel se rapporte le data
 * @property \Collection\Entity\Champ $champ Le data contient la valeur du champ $champ de l'élément $element
 */
class Data implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Element", inversedBy="datas")
     **/
    protected $element;
    
    /**
     * Le champ auquel la donnée se rapporte
     * 
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Champ", inversedBy="datas")
     **/
    protected $champ;
    
    /**
     * Constructeur
     **/
    public function __construct($element, $champ) {
    	$this->element = $element;
    	$this->champ = $champ;
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

    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {

    }
}
