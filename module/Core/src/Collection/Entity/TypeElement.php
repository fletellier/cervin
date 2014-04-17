<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;

/**
 * Entité d'un type d'élément de la collection (personne, image, matériel, logiciel, ...)
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity(repositoryClass="Collection\Entity\TypeElementRepository")
 * @ORM\Table(name="mbo_typeelement")
 * 
 * @property int $id Identifiant unique de type d'élément
 * @property string $nom Le nom du type d'élément
 * @property string $type Le type d'un type d'élément : 'media' ou 'artefact'
 * @property \Collection\Entity\Champ $champs Les champs qui décrivent tout élément de ce type d'élémént
 * @property \Collection\Entity\Element $elements Les éléments de ce type d'élément
 * @property bool $valide Booléen qui décrit si le type d'élément est validé ou brouillon
 */
class TypeElement implements InputFilterAwareInterface
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
    protected $nom;
    
    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="string", length=200)
     */
    protected $type;
    
    /**
     * L'ensemble des champs décrivant ce type élément
     * 
     * @ORM\OneToMany(targetEntity="Collection\Entity\Champ", mappedBy="type_element", cascade={"remove"})
     * @ORM\OrderBy({"label" = "ASC"})
     **/
    protected $champs;

    /**
     * L'ensemble des champs décrivant ce type élément
     * 
     * @ORM\OneToMany(targetEntity="Collection\Entity\Element", mappedBy="type_element", cascade={"remove"})
     **/
    protected $elements;
    
    /**
     * Les sémantiques dont le type d'élément est à l'origine
     * @ORM\OneToMany(targetEntity="Collection\Entity\SemantiqueArtefact", mappedBy="type_origine", cascade={"remove"})
     **/
    protected $semantique_origine;
    
    /**
     * Les sémantiques dont le type d'élément est en destination
     * @ORM\OneToMany(targetEntity="Collection\Entity\SemantiqueArtefact", mappedBy="type_destination", cascade={"remove"})
     **/
    protected $semantique_destination;

    /**
     * Constructeur
     **/
    public function __construct($nom = '', $type) {
    	if ($type != "artefact" && $type != "media") {
    		throw new InvalidArgumentException("Construction d'un objet TypeElement avec un attribut type différent de 'artefact' ou 'media' => INTERDIT");
    	}
    	$this->nom = $nom;
    	$this->type = $type;
    	$this->champs = array();
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
    	$this->nom = $data['nom'];
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
    	
    		/*$inputFilter->add($factory->createInput(array(
    			'name' => 'id',
    			'required' => true,
    			'filters' => array(array('name' => 'Int')),
    		)));*/
    		 
    		$inputFilter->add($factory->createInput(array(
    			'name' => 'nom',
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
    		
    		$this->inputFilter = $inputFilter;
    	}
    	
    	return $this->inputFilter;
    }
}

/**
 * Repository d'un type élément
 */
class TypeElementRepository extends EntityRepository
{
	/**
	 * Retourne un tableau contenant le nom et l'id des types élement pour les artefacts
	 *
	 * @return array
	 */
    public function getIdNameArray()
    {
        $query  = $this->getEntityManager()
        		       ->createQuery('SELECT e.id, e.nom FROM Collection\Entity\TypeElement e INDEX BY e.id WHERE e.type = \'artefact\'');

        $array  = $query->getResult(Query::HYDRATE_ARRAY); 
        $return = current($array);
    //    $return = array_combine($array['id'],['nom']);

        return $array['id'] ;
    }
}
