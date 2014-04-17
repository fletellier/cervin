<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Collection\Form\SemantiqueForm;
use Collection\Entity\SemantiqueArtefact;
use Collection\Entity\SemantiqueArtefactRepository;
use Zend\Json\Json;

/**
 * Controleur des sémantiques
 *
 * Permet la création, lecture, modification et suppression des sémantiques
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class SemantiqueController extends AbstractActionController
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
	 * Affiche la Datatable des sémantiques ou retourne une liste de tous les sémantiques à la Datatable
	 *
	 * Si la page est appelé en GET elle affiche la vue index.phtml.
	 * Si c'est une requête AJAX, elle prend en paramètre les conditions 
	 * renvoyées par le widget Datatable et précisés au moment de 
	 * l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en 
	 * base de donnée. Ces données sont ensuite passées à la Datatable qui 
	 * se chargera de les afficher.
	 *
     * @return \Zend\View\Model\ViewModel
     */
	public function indexAction()
	{
		$params = null;
		
		if ($this->getRequest()->isXmlHttpRequest())
		{
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
		    
		    $entityManager = $this->getEntityManager()
		    ->getRepository('Collection\Entity\SemantiqueArtefact');
		    
		    $dataTable = new \Collection\Model\SemantiqueDataTable($params);
		    $dataTable->setEntityManager($entityManager);
		    
		    $dataTable->setConfiguration(array(
		    	'type_origine',
		    	'semantique',
		    	'description',
		    	'type_destination'
		    	));
	
		    $aaData = array();
	
		    $paginator = null;
	
		    if(isset($params["conditions"])){
		    	$conditions = json_decode($params["conditions"], true);
		    	$paginator = $dataTable->getPaginator($conditions);
		    } else {
		    	$paginator = $dataTable->getPaginator();
		    }
		    
		    foreach ($dataTable->getPaginator() as $semantique) {
		    	
		    	$btn_supprimer = '<a href="#" data-url="'
		    	.$this->url()->fromRoute('semantique/supprimer', array('id' => $semantique->id))
		    	.'" data-value="['.$escapeHtml($semantique->type_origine->nom).'] '
		    	.$escapeHtml($semantique->semantique).' ['
		    	.$escapeHtml($semantique->type_destination->nom).']" 
		    	class="btn btn-danger SupprimerSemantique"
		    	><i class="icon-trash"></i></a>';
	
	            $aaData[] = array(
	                '<span> '. $semantique->type_origine->nom .' </span>',
	                '<span class="edit CursorPointer"
	                	data-url="'.$this->url()->fromRoute("semantique/modifier", array("id" => $semantique->id)).'"
	                	data-name="semantique" data-type="text" data-pk="1"> '.
	        			$escapeHtml($semantique->semantique) .
	            	'</span>',
	            	'<span class="edit CursorPointer"
	                	data-url="'.$this->url()->fromRoute("semantique/modifier", array("id" => $semantique->id)).'"
	                	data-name="description" data-type="textarea" data-pk="1"> '.
	        			$escapeHtml($semantique->description) .
	            	'</span>',
	                '<span> '. $semantique->type_destination->nom .' </span>',
	                $btn_supprimer
	            );
	        }
	        
	        $dataTable->setAaData($aaData);

            return $this->getResponse()->setContent($dataTable->findAll());
		} else {

			//	$TypeDestination = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy($post['type_destination']);
			$TypesOrigines = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->getSemantiqueOrigine();
			$TypesDestinations = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->getSemantiqueDestination();
			$semantiquesArtefact = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->findAll();
			return new ViewModel(array( 'semantiquesArtefact'=>$semantiquesArtefact,'TypesOrigines'=>$TypesOrigines,'TypesDestinations'=>$TypesDestinations ));
		}
	}

	/**
	 * Ajout d'une nouvelle sémantique
	 * 
	 * Renvoie le formulaire avec les types d'artefacts possibles en origine et destination d'une sémantique à la vue
	 * Traite la requête lorsque le formulaire est posté :
	 * 		Création de la sémantique
	 * 		Vérification des données du formulaire
	 * 		Remplissage de la sémantique avec les données
	 * 		Envoi dans la base de données
	 * 
	 * @return \Zend\View\Model\ViewModel
	 */
	public function ajouterAction()
	{
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
		$typeElementsArtefact = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'), array('nom'=>'ASC'));
		$typeElementsArtefactArray = array();
		$typeElementsArtefactArray2 = array();
		foreach ($typeElementsArtefact as $typeElementArtefact) {
			$typeElementsArtefactArray[$typeElementArtefact->id] = $typeElementArtefact->nom;
			$typeElementsArtefactArray2[]=$typeElementArtefact->id;
		}
        $form = new SemantiqueForm($typeElementsArtefactArray);
		$SemantiqueArtefact = new SemantiqueArtefact();
	    $form->bind($SemantiqueArtefact);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
		    $form->setInputFilter($SemantiqueArtefact->getInputFilter($typeElementsArtefactArray2));
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$post = $request->getPost();
				$SemantiqueArtefact->type_destination = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->find($post['type_destination']);
				$SemantiqueArtefact->type_origine = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->find($post['type_origine']);
			    $this->getEntityManager()->persist($SemantiqueArtefact);
			    $this->getEntityManager()->flush();
			 	$this->flashMessenger()->addSuccessMessage(sprintf(
			 		'La sémantique a bien été créé.<br>%1$s', '['
			 		.$escapeHtml($SemantiqueArtefact->type_origine->nom).'] '
			 		.$escapeHtml($SemantiqueArtefact->semantique)
			 		.' ['.$escapeHtml($SemantiqueArtefact->type_destination->nom).']'));
	            return $this->redirect()->toRoute('semantique');
		    }
		}
		return new ViewModel(array('form'=>$form));
	}

	/**
	 * Modification d'une sémantique existante
	 * 
	 * Cette action est déclenchée par un appel AJAX lancé par X-Editable
	 * On commence par récupérer la sémantique à modifier : 
	 * son ID est passé en paramètre dans la requête AJAX
	 */
	public function modifierAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) 
        {
			$id = (int) $this->params('id', null);
			$SemantiqueArtefact = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->findOneBy(array('id'=>$id));
			if ($SemantiqueArtefact === null or $id === null) {
				$this->getResponse()->setStatusCode(404);
				return; 
			}
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'semantique':
					$SemantiqueArtefact->semantique = $request['value'];
					break;
				case 'description':
					$SemantiqueArtefact->description = $request['value'];
					break;
        	}
	    	$this->getEntityManager()->flush();
			return $this->getResponse()->setContent(Json::encode(true));
		} else {
			$this->getResponse()->setStatusCode(404);
		}
	}

	/**
	 * Suppression d'une sémantique
	 * 
	 * Cette action est déclenché par un appel AJAX 
	 * lancé depuis la modale de confirmation dans la vue.
	 * On commence par récupérer la sémantique à supprimer : 
	 * son ID est passé en paramètre dans la requête AJAX
	 * On vérifie ensuite si la sémantique est déjà utilisée dans une relation existante :
	 * 		Si non, on peut la supprimer sans problème
	 * 		Si oui, on ne doit pas la supprimer, on le signale à l'utilisateur 
	 */
	public function supprimerAction()
	{
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
		$id = (int) $this->params()->fromRoute('id', 0);
		$semantiqueArtefact = $this->getEntityManager()->getRepository('Collection\Entity\SemantiqueArtefact')->findOneBy(array('id'=>$id));
		if ($semantiqueArtefact === null || $id === null) {
			$this->getResponse()->setStatusCode(404);
			return; 
		}
		$relations = $this->getEntityManager()->getRepository("Collection\Entity\RelationArtefacts")->findBy(array('semantique' => $semantiqueArtefact));
		if(count($relations) != 0){
			// La sémantique est déjà utilisée dans une relation, on ne peut pas la supprimer
			$this->flashMessenger()->addErrorMessage(sprintf(
				'<i class="icon-warning-sign"> </i> La sémantique " ['
				. $escapeHtml($semantiqueArtefact->type_origine->nom) .'] '
				.$escapeHtml($semantiqueArtefact->semantique)
				.' ['.$escapeHtml($semantiqueArtefact->type_destination->nom)
				.']" ne peut pas être supprimée car elle est déjà utilisée dans une transition existante.'));
			return $this->getResponse()->setContent(Json::encode(true));
		} else {
			$this->getEntityManager()->remove($semantiqueArtefact);
			$this->getEntityManager()->flush();
			$this->flashMessenger()->addSuccessMessage(
				sprintf('La sémantique "['
					.$escapeHtml($semantiqueArtefact->type_origine->nom) .'] '
					.$escapeHtml($semantiqueArtefact->semantique)
					.' ['
					.$escapeHtml($semantiqueArtefact->type_destination->nom)
					.']" a bien été supprimée.'));
			return $this->getResponse()->setContent(Json::encode(true));
		}
		
	}

}
