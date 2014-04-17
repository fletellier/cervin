<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;

/**
 * Entité d'une sémantique possible des relations entre deux artefacts
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity(repositoryClass="Collection\Entity\SemantiqueArtefactRepository")
 * @ORM\Table(name="mbo_semantiqueartefact")
 * 
 * @property int $id Identifiant unique de la sémantique
 * @property \Collection\Entity\TypeElement $type_origine Le type d'artefact à l'origine des relations marquées par cette sémantique
 * @property \Collection\Entity\TypeElement $type_origine Le type d'artefact à la destination des relations marquées par cette sémantique
 * @property string $semantique La sémantique elle même
 * @property string $description Une description expliquant le sens de la sémantique
 * @property \Collection\Entity\RelationArtefacts $ relations Les relations qui utilisent cette sémantique
 * @property bool $valide Booléen qui décrit si le type d'élément est validé ou brouillon
 */
class SemantiqueArtefact implements InputFilterAwareInterface
{
    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", cascade={"persist"})
     **/
    protected $type_origine;
    
    /**
     * $type_destination contient la chaîne décrivant le type du deuxième artefact
     * 
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", cascade={"persist"})
     */
    protected $type_destination;
    
    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="string", length=200)
     */
    protected $semantique;
    
    /**
     * @Gedmo\Mapping\Annotation\Versioned
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Collection\Entity\RelationArtefacts", mappedBy="semantique", cascade={"remove"})
     **/
    protected $relations;
    
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
        $this->semantique = $data['semantique'];
        $this->description = $data['description'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter($typeElementsArtefactArray = array())
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
                'name'     => 'type_destination',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => $typeElementsArtefactArray,
                            'messages' => array(
                                \Zend\Validator\InArray::NOT_IN_ARRAY => 'Le type d\'élément na pas été trouvé'  
                            ),
                        ),
                    ),
                ),
            )));  
            $inputFilter->add($factory->createInput(array(
                'name'     => 'type_origine',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => $typeElementsArtefactArray,
                            'messages' => array(
                                \Zend\Validator\InArray::NOT_IN_ARRAY => 'Le type d\'élément na pas été trouvé'  
                            ),
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'semantique',
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

/**
 * Repository d'une sémantique possible des relations entre deux artefacts
 */
class SemantiqueArtefactRepository extends EntityRepository
{

    public function getSemantiqueOrigine()
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->from('Collection\Entity\SemantiqueArtefact', 'SA')
            ->select("t.nom,t.id")
            ->leftJoin('SA.type_origine', 't') 
            ->groupBy('t.nom');

        return $query->getQuery()->getResult();
    }

    public function getSemantiqueDestination()
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->from('Collection\Entity\SemantiqueArtefact', 'SA')
            ->select("t.nom,t.id")
            ->leftJoin('SA.type_destination', 't') 
            ->groupBy('t.nom');

        return $query->getQuery()->getResult();
    }
}