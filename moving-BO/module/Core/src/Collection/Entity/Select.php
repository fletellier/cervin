<?php
namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
* Liste des selects
*
* @ORM\Entity
* @Gedmo\Loggable
* @ORM\Table(name="mbo_select")
* @property int $id Identifiant unique du champ select
* @property string $label Label du select
* @property string $description Description du select (sert d'aide à la saisie pour l'utilisateur)
* @property Collection\Entity\ChampSelect $champs_select L'ensemble des champs select qui utilise ce select
*/
class Select implements InputFilterAwareInterface
{
	protected $inputFilter;
	 
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO"))
	 * @var integer
	 */
	public $id;
	 
	/**
     * @Gedmo\Versioned
	 * @ORM\Column(type="string")
	 * @var string
	 */
	public $label;

	/**
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string
     */
    public $description;

    /**
     * @ORM\OneToMany(targetEntity="Collection\Entity\ChampSelect", mappedBy="select")
     * @var Collection\Entity\ChampSelect[]
     **/
    public $champs_select;

    /**
     * @ORM\OneToMany(targetEntity="Collection\Entity\SelectOption", mappedBy="select", cascade={"remove", "persist"})
     * @ORM\OrderBy({"text" = "ASC"})
     * @var Collection\Entity\SelectOption[]
     **/
    public $select_options;

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
	 * Convert the object to an array.
	 *
	 * @return array
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
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			 
			$factory = new InputFactory();
			 
			$inputFilter->add($factory->createInput(array(
				'name' => 'id',
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
				),
			)));
			 
			$inputFilter->add($factory->createInput(array(
				'name' => 'artist',
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
							'max' => 100,
						),
					),
				),
			)));
			 
			$inputFilter->add($factory->createInput(array(
				'name' => 'title',
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
							'max' => 100,
						),
					),
				),
			)));
			 
			$this->inputFilter = $inputFilter;
		}
		 
		return $this->inputFilter;
	}
}