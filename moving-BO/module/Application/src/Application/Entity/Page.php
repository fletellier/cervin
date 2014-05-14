<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Une page
 * 
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_page")
 * 
 * @property int $id
 */
class Page implements InputFilterAwareInterface
{
	protected $inputFilter;

	/**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=200, unique=true)
     */
    protected $titre;

    /**
     * @ORM\Column(type="text")
     */
    protected $texte;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(type="string", length=200, unique=true)
     */
    protected $slug;

    static public function slugify($text)
	{ 
	  	// replace non letter or digits by -
	  	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		
	  	// trim
	  	$text = trim($text, '-');
	
	  	// transliterate
	  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	
	  	// lowercase
	  	$text = strtolower($text);
	
	  	// remove unwanted characters
	  	$text = preg_replace('~[^-\w]+~', '', $text);
	
	  	if (empty($text))
	  	{
	  	  return 'n-a';
	  	}
		
	  	return $text;
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
     * Constructeur
     **/
    public function __construct($title = '', $text = '') {
        $this->titre = $title;
        $this->texte = $text;
        $this->slug = $this->slugify($title);
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
    	$this->titre = $data['titre'];
    	$this->texte = $data['texte'];
    	$this->slug = $this->slugify($this->titre);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
    	
    }
}