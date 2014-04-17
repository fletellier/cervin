<?php

namespace Collection\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Exception;
use Doctrine\ORM\EntityRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Zend\Form\Form as Form;
use Zend\Form\Element as FormElement;

use Collection\Entity\Artefact;
use Collection\Entity\Media;

use Doctrine\ORM\EntityManager;
/**
 * Entité d'un élément de la collection numérique (artefact ou média)
 *
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ORM\Table(name="mbo_element")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"Artefact" = "Artefact", 
 *                        "Media" = "Media"})
 * 
 * @property int $id Identifiant unique de l'élément
 * @property string $titre Titre de l'élément
 * @property string $description Description de l'élément
 * @property bool $onLine Etat de en ligne ou brouillon de l'élément
 * @property \Collection\Entity\TypeElement $type_element Le type de l'élément
 * @property \Collection\Entity\Data $datas Les datas qui décrivent l'élément
 * @property \Collection\Entity\RelationArtefacts $relation_origine L'ensemble des relations entre artefacts
 */
class Element implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * Id de l'élément
     * 
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Titre de l'élément
     * 
     * @Gedmo\Versioned
     * @ORM\Column(type="string", length=200)
     */
    protected $titre;

    /**
     * Descritpion de l'élément
     * 
     * @Gedmo\Versioned
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="Collection\Entity\TypeElement", inversedBy="elements")
     */
    protected $type_element;
    
    /**
     * @ORM\OneToMany(targetEntity="Collection\Entity\Data", mappedBy="element", cascade={"remove", "persist"}))
     */
    protected $datas;

    /**
     * @var date $created
     *
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * @var date $updated
     *
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Timestampable
     */
    protected $updated;

    /**
     * @ORM\ManyToOne(targetEntity="SamUser\Entity\User", inversedBy="elements_chantier")
     */
    protected $utilisateur;

    /**
     * @var datetime $utilisateurChange
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"utilisateur"})
     */
    protected $utilisateurChange;
    
    /**
     * Etat de l'élément : brouillon ou public
     *
     * @ORM\Column(type="boolean")
     */
    protected $public;
    
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
     * Cette fonction est liée au formulaire ChampTypeElementForm
     * Elle prend en entrée les datas postés depuis ce formulaire
     *
     * @param array $data
     */
    public function populate(EntityManager $em, $data = array())
    {
    	$this->id = $data['id']; 
        $this->titre = $data['titre'];
        $this->description = $data['description'];
        $this->datas = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($this->type_element->champs as $champ) {
        	$index = 'champ_'.$champ->id;
        	switch ($champ->format) {
                case 'select':
                    if ($data[$index]) {

                        if ($data[$index] != null) {
                            $select_option = $em
                                ->getRepository('Collection\Entity\SelectOption')
                                ->findOneBy(array('id'=>$data[$index]));
                            if ($select_option === null) {
                                $this->getResponse()->setStatusCode(404);
                                return;
                            }
                        } else {
                            $select_option = null;
                        }


                        $databd = new DataSelect($this, $champ);
                        $databd->option = $select_option;
                        $this->datas->add($databd);
                    }
                    break;
        		case 'texte':
        			if ($data[$index]) {
        				$databd = new DataTexte($this, $champ);
        				$databd->texte = $data[$index];
        				$this->datas->add($databd);
        			}
        			break;
        		case 'textarea':
        			if ($data[$index]) {
        				$databd = new DataTextarea($this, $champ);
        				$databd->textarea = $data[$index];
        				$this->datas->add($databd);
        			}
        			break;
        		case 'nombre':
        			if ($data[$index]) {
        				$databd = new DataNombre($this, $champ);
        				$databd->nombre = $data[$index];
        				$this->datas->add($databd);
        			}
        			break;
        		case 'url':
        			if ($data[$index]) {
        				$databd = new DataUrl($this, $champ);
        				$databd->url = $data[$index];
        				$this->datas->add($databd);
        			}
        			break;
        		case 'date':
        			if ($data[$index] != null) {
        				$format = $data['format'.$index];
        				$databd = new DataDate($this, $champ);
        				$databd->format = (int) $format;
        				if ($format == 0) {
        					$databd->date = \DateTime::createFromFormat('Y-d-m', $data[$index]);
        				} elseif ($format == 1) {
        					$databd->date = \DateTime::createFromFormat('Y-m-d', $data[$index].'-01');
        				} else {
        					$databd->date = \DateTime::createFromFormat('Y-d-m', $data[$index].'-01-01');
        				}
        				$this->datas->add($databd);
        			}
        			break;
        		case 'fichier':
        			if ($data[$index]['tmp_name'] != null) {
        				$this->addFile(new DataFichier($this, $champ), $data[$index]['tmp_name'], $data[$index]['name'], $data[$index]['type']);
        			}
        			break;
                case 'geoposition':
                    if ($data['latitude_'.$index] || $data['longitude_'.$index] || $data['adresse_'.$index]) {
                        $databd = new DataGeoposition($this, $champ);
                        $databd->latitude = $data['latitude_'.$index];
                        $databd->longitude = $data['longitude_'.$index];
                        $databd->adresse = $data['adresse_'.$index];
                        $this->datas->add($databd);
                    }
                    break;
        	}
        }
    }
    
    /**
     * Ajout le fichier uploadé à un DataFichier
     * 
     * Récupère le fichier uploadé pour l'insérer dans l'arborescence public/uploads
     * et ajoute le chemin vers ce fichier aux datas de l'élément
     */
    public function addFile($data, $tmpname ,$name, $format) {
    	// On stocke le fichier dans le dossier public/uploads/artefacts/'champ_id'/'datetime'/
    	// ou dans public/uploads/medias/'champ_id'/'datetime'/
    	if($this instanceof Artefact){
    		$champ_dir = "/uploads/artefacts/" . (string)$data->champ->id;
    	} elseif($this instanceof Media) {
    		$champ_dir = "/uploads/medias/" . (string)$data->champ->id;
    	} else {
    		throw new \Exception("Error Processing Request");
    	}
    	if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $champ_dir)) {
    		mkdir($_SERVER['DOCUMENT_ROOT'] . $champ_dir);
    	}
    	$dest_dir = $champ_dir . "/" . date("Y-m-d-H-i-s");
    	mkdir($_SERVER['DOCUMENT_ROOT'] . $dest_dir);
    	
    	move_uploaded_file($tmpname, $_SERVER['DOCUMENT_ROOT'] . $dest_dir . "/" . $name);
    	$data->fichier = $dest_dir . "/" . $name;
    	$data->format_fichier = $format;
    	$this->datas->add($data);
    }
    
    /**
     * Met à jour le fichier attaché à un DataFichier
     */
    public function updateFile($data, $tmpname ,$name, $format) {
    	$this->deleteFile($data);
    	$this->addFile($data, $tmpname ,$name, $format);
    }

	/**
	 * Supprime le fichier attaché à un DataFichier
	 * 
	 * @return boolean
	 */
    public function deleteFile($data){
    	if($data->fichier !== null){
    		$dir = $_SERVER["DOCUMENT_ROOT"] . dirname($data->fichier);
    		$this->delTree( $dir );
    		return true;
    	}
    	return false;
    }
    
    /**
     * Supprime un dossier et son contenu
     * 
     * Supprime le dossier et tout ce qu'il contient récursivement. 
     * Crédit : http://fr2.php.net/manual/fr/function.rmdir.php#92661
     * 
     * @param string
     * @return boolean
     */
    private function delTree($dir) {
    	if(is_dir($dir)){
    		$files = glob( $dir . '*', GLOB_MARK );
    		foreach( $files as $file ){
    			$file = str_replace('\\', '/', $file);
    			if( substr( $file, -1 ) == '/' ) {
    				$this->delTree( $file );
    			} else {
    				if( is_file($file) ){
    					chown( $file, 666 );
    					chmod( $file, 0666 );
    					unlink( $file );
    				}
    			}
    		}
    
    		rmdir( $dir );
    		return true;
    	}
    	return false;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
    	throw new \Exception("Not used");
    }
    
    public function getInputFilter($form =null)
    {
    	if (!$this->inputFilter) {
    		$inputFilter = new InputFilter();
    		$factory = new InputFactory();

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
    
    		foreach ($this->type_element->champs as $champ) {
    			switch ($champ->format) {
                    case 'texte':
                        $inputFilter->add($factory->createInput(
                            array(
                                'name' => 'champ_'.strval($champ->id),
                                'required' => false,
                                'filters' => array(
                                    array('name' => 'StripTags'),
                                    array('name' => 'StringTrim'),
                            ),
                        )));
                        break;
    				case 'select':
    					$inputFilter->add($factory->createInput(
	    					array(
		    					'name' => 'champ_'.strval($champ->id),
		    					'required' => false,
		    					'validators' => array(
                                    array(
                                        'name' => 'regex',
                                        'options'=>array(
                                            'pattern' => '/^[0-9]+$/',
                                            'messages'=> array('regexNotMatch'=>'Ce n\'est pas une id valide'),
                                        ),
                                    ),
                                ),
        					)));
    					break;
    				case 'textarea':
    					$inputFilter->add($factory->createInput(
	    					array(
		    					'name' => 'champ_'.strval($champ->id),
		    					'required' => false,
		    					'filters' => array(
			    					array('name' => 'StripTags'),
			    					array('name' => 'StringTrim'),
		    				),
    					)));
    					break;
    				case 'fichier':
    					$file = new FileInput('champ_'.strval($champ->id));
    					$file->setRequired(true);
    					$file->getFilterChain()->attachByName(
    							'filerenameupload',
    							array(
    									'target' => $_SERVER['DOCUMENT_ROOT']."/tmpuploads/",
    									'use_upload_name' => true,
    							)
    					);
    					$inputFilter->add($file);
    					break;
    				case 'date':
    					$inputFilter->add($factory->createInput(
	    					array(
		    					'name' => 'champ_'.strval($champ->id),
		    					'required' => false,
		    					'validators' => array(
			    					array(
				    					'name' => 'regex',
				    					'options'=>array(
				    					'pattern' => '/^[0-9]{4}(-[0-9]{2}){0,2}$/',
				    					'messages'=> array('regexNotMatch'=>'L\'entrée ne semble pas être une date valide'),
			    					),
		    					),
	    					),
    					)));
    					break;
    				case 'nombre':
    				case 'url':
    					$inputFilter->add($factory->createInput(
	    					array(
	    						'name' => 'champ_'.strval($champ->id),
	    						'required' => false
	    					)
    					));
    					break;
                    case 'geoposition':
                        $inputFilter->add($factory->createInput(
                            array(
                                'name' => 'adresse_champ_'.strval($champ->id),
                                'required' => false,
                                'filters' => array(
                                    array('name' => 'StripTags'),
                                    array('name' => 'StringTrim'),
                            ),
                            )
                        ));
                        $inputFilter->add($factory->createInput(
                            array(
                                'name' => 'latitude_champ_'.strval($champ->id),
                                'required' => false,
		    					'validators' => array(
                                    array(
                                        'name' => 'regex',
                                        'options'=>array(
                                            'pattern' => '/^[0-9\-.]+$/',
                                            'messages'=> array('regexNotMatch'=>'Ce n\'est pas une latitude valide'),
                                        ),
                                    ),
                                ),
                            )
                        ));
                        $inputFilter->add($factory->createInput(
                            array(
                                'name' => 'longitude_champ_'.strval($champ->id),
                                'required' => false,
		    					'validators' => array(
                                    array(
                                        'name' => 'regex',
                                        'options'=>array(
                                            'pattern' => '/^[0-9\-.]+$/',
                                            'messages'=> array('regexNotMatch'=>'Ce n\'est pas une longitude valide'),
                                        ),
                                    ),
                                ),
                            )
                        ));
                        break;
    			}
    		}
    		$this->inputFilter = $inputFilter;
    	}
    	return $this->inputFilter;
    }
    
}
