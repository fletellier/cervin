<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use InvalidArgumentException;
use Doctrine\ORM\EntityRepository;

/**
 * Spécialisation de la classe Champ lorsque la champ correspondante est au format select
 * 
 * @ORM\Entity
 * @ORM\Table(name="mbo_champselect")
 * 
 * @property Collection\Entity\Select $select est la liste de select  
 * 
 */
class ChampSelect extends Champ
{

    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\Select", inversedBy="champs_select")
     **/
    protected $select;
	
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

	    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter($select = null)
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
    			'name' => 'select',
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
                'name' => 'label',
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
                'name'     => 'select',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => $select,
                            'messages' => array(
                                \Zend\Validator\InArray::NOT_IN_ARRAY => 'Le select na pas été trouvé'  
                            ),
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
