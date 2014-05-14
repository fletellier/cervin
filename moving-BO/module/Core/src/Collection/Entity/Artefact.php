<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;

use Collection\Entity\Element;

/**
 * Entité d'un artefact
 *
 * @ORM\Entity(repositoryClass="Collection\Entity\ArtefactRepository")
 * @ORM\Table(name="mbo_artefact")
 * 
 * @property \Collection\Entity\Media $medias L'ensemble des médias qui sont liés à l'artefact
 * @property \Collection\Entity\RelationArtefacts $relations_origine L'ensemble des relations entre artefacts (marqués d'une sémantique) qui ont pour origine l'artefact
 * @property \Collection\Entity\RelationArtefacts $relations_destination L'ensemble des relations entre artefacts (marqués d'une sémantique) qui ont pour destination l'artefact
 */
class Artefact extends Element
{
	protected $inputFilter;

	/**
	 * L'ensemble des médias qui sont liés à l'artefact
	 * 
	 * @ORM\ManyToMany(targetEntity="Collection\Entity\Media", inversedBy="artefacts")
	 * @ORM\JoinTable(name="mbo_artefact_media")
	 * @var Collection\Entity\Media[]
	 **/
	public $medias;

	/**
	 * L'ensemble des relations entre artefacts (marqués d'une sémantique) qui ont pour origine l'artefact
	 * 
	 * @ORM\OneToMany(targetEntity="Collection\Entity\RelationArtefacts", mappedBy="origine", cascade={"remove"})
	 * @var Collection\Entity\RelationArtefacts[]
	 **/
	public $relations_origine;
	
	/**
	 * L'ensemble des relations entre artefacts (marqués d'une sémantique) qui ont pour destination l'artefact
	 * 
	 * @ORM\OneToMany(targetEntity="Collection\Entity\RelationArtefacts", mappedBy="destination", cascade={"remove"})
	 * @var Collection\Entity\RelationArtefacts[]
	 **/
	public $relations_destination;
	
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
	 * Constructeur
	 *
	 * @param string $titre
	 * @param Collection\Entity\TypeElement $type_element
	 * @throws InvalidArgumentException Si $type_elemnt n'est pas de type média
	 */
	public function __construct($titre, $type_element) {
		if ($type_element->type != 'artefact') {
			throw new InvalidArgumentException('Tentative de création d\'un média avec un type élément caractérisant un artefact => INTERDIT');
		}
		$this->titre = $titre;
		$this->type_element = $type_element;
		$this->public = false;
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
	
}

/**
 * Repository d'un artefact
 */
class ArtefactRepository extends EntityRepository
{

}