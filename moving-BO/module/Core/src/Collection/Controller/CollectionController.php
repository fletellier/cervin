<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Collection\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Collection\Form\ChampForm;
use Doctrine\DBAL\DriverManager;
use Zend\Json\Json;

/**
 * Controleur de la collection
 *
 * Permet l'affichage des éléments de la collection ainsi que la modification du statut "onLine"
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class CollectionController extends AbstractActionController
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	/**
	 * Initialisation de l'Entity Manager
	 *
	 * @param Doctrine\ORM\EntityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Retourne l'Entity Manager
	 *
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if ($this->em === null) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
	
		return $this->em;
	}

	/**
	 * Redirige sur la page de consultation de la collection numérique
	 *
	 * @return void
	 */
	public function indexAction()
	{
		return $this->redirect()->toRoute('collection/consulter');
	}
    
	/**
	 * Affiche la Datatable de la collection ou retourne une liste de tous les éléments à la Datatable
	 *
	 * Si la page est appelé en GET elle affiche la vue consulter.phtml.
	 * Si c'est une requête AJAX, elle prend en paramètre les conditions 
	 * renvoyées par le widget Datatable et précisés au moment de 
	 * l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en 
	 * base de donnée. Ces données sont ensuite passées à la Datatable qui 
	 * se chargera de les afficher.
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function consulterAction()
    {
    	$params = null;

    	if ($this->getRequest()->isXmlHttpRequest()) {
    		
    		//Ces 2 variables permettent de récupérer la fonction escapeHtml pour pouvoir échapper les entités Html
    		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    		$escapeHtml = $viewHelperManager->get('escapeHtml');
    		
    		$params = $this->params()->fromPost();

	    	if(!isset($params["iSortCol_0"])){
	    		$params["iSortCol_0"] = '0';
	    	}
	
	    	if(!isset($params["sSortDir_0"])){
	    		$params["sSortDir_0"] = 'ASC';
	    	}
	    	
	    	
	    	$entityManager = $this->getEntityManager()->getRepository('Collection\Entity\Element');
	    	
	    	$dataTable = new \Collection\Model\ElementDataTable($params);
	    	$dataTable->setEntityManager($entityManager);

    		$dataTable->setConfiguration(array(
    				'titre',
			        'description',
		    	    'nom',
    				'public'
    		));
	    	
	    	$aaData = array();
	    	
	    	$paginator = null;
	    	
	    	if(isset($params["conditions"])){
	    		$conditions = json_decode($params["conditions"], true);
	    		$paginator = $dataTable->getPaginator($conditions);
	    	} else {
	    		$paginator = $dataTable->getPaginator();
	    	}
	    		
	    	foreach ($paginator as $element) {
	    		
	    		if ($element->public) {
	    			$visibilite = 'Public';
	    		} else {
	    			$visibilite = '<p class="muted"> Brouillon </p>';
	    		}
	    		

	    		if($element->type_element->type == 'artefact'){
	    			$titre = '<p class="text-success"><i class="icon-tag"> </i><a class="text-success" href="'.$this->url()->fromRoute('element/voir', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
	    		} else {
	    			$titre = '<p class="text-warning"><i class="icon-picture"> </i><a class="text-warning" href="'.$this->url()->fromRoute('element/voir', array('id' => $element->id)).'">'.$escapeHtml($element->titre).'</a></p>';
	    		}

    			$aaData[] = array(
    					$titre,
	    				$dataTable->truncate($element->description, 250, ' ...', false, true),
	    				$element->type_element->nom,
    					$visibilite
    			);
	    	}
	    	
	    	$dataTable->setAaData($aaData);

    		return $this->getResponse()->setContent( $dataTable->findAll() );
    	} else {
    		//var_dump($this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findAll());
    		$allTypeArtefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findByType('artefact');
    		$allTypeMedia = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findByType('media');
    		return new ViewModel( array( 'allTypeArtefact' => $allTypeArtefact, 'allTypeMedia' => $allTypeMedia ) );
    		//return new ViewModel( array( 'aaData' => $dataTable->getJSONaaData() ) );
    	}
    }

}
