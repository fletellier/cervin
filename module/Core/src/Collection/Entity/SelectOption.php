<?php
namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
* Valeurs de la liste des selects
*
* @ORM\Entity
* @Gedmo\Loggable
* @ORM\Table(name="mbo_selectoption",options={"collate"="utf8_general_ci"})
* @property int $id Identifiant unique du champ select
* @property string $text text de l'option
* @property Collection\Entity\Select $select Select de la valeur
* @property Collection\Entity\DataSelect $datas L'ensemble des data qui utilise cette valeur 
*/
class SelectOption implements InputFilterAwareInterface
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
	public $text;

    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Select", inversedBy="select_options")
     * @var Collection\Entity\Select
     **/
    public $select;

	/**
     * @ORM\OneToMany(targetEntity="Collection\Entity\DataSelect", mappedBy="option")
     * @var Collection\Entity\DataSelect[]
     **/
    public $datas;


    public function getText()
    {
        return $this->text;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __construct($select = null) {
    	$this->select = $select;
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
	 * Convert the object to an array.
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