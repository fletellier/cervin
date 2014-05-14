<?php
/**
 *
 */

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Form\ChampTypeElementForm;
use Zend\Form\Form;
use Zend\Form\Element;
use Exception;
use Collection\Entity\Media;
use Collection\Entity\Data;
use Zend\File\Transfer\Adapter\Http;
use Zend\Json\Json;

/**
 * Controleur des medias
 *
 * Permet la création, lecture, modification et suppression des médias
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class RelationController extends AbstractActionController
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
	 * Créé la relation entre deux artefacts avec une sémantique
	 *
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle récupère l'id de la sémantique et de l'élément de destination présents dans
	 * les paramètres de la route puis l'id de l'élément d'origine depuis les variables
	 * POST. On vérifie ensuite que tous les ids sont bien présents, si l'id de la
	 * sémantique est absent on envoie la modal sinon on vérifie que les ids
	 * correspondent à un élément en base de donnée. Et enfin on ajoute la relation.
	 *
	 * @return void|\Zend\Stdlib\mixed|Ambigous <\Zend\View\Model\ViewModel, \Zend\View\Model\ViewModel>
	 */
	public function addRelationArtefactSemantiqueAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
				
			$idSemantique = (int) $this->params()->fromPost('idSemantique', 0);
	
			//Si il n'y a pas de sémantique, on charge la modal
			if(!$idSemantique){
	
				$idElementDestination = (int) $this->params()->fromRoute('idDestination', 0);
				$idElementOrigine     = (int) $this->params()->fromPost('idOrigine', 0);
	
				if (!$idElementDestination) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément de destination.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
	
				if (!$idElementOrigine) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément d\'origine.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
	
				$elementDestination = $this->getEntityManager()->find('Collection\Entity\Element', $idElementDestination);
				$elementOrigine     = $this->getEntityManager()->find('Collection\Entity\Element', $idElementOrigine);
	
				if (null === $elementDestination || null === $elementOrigine ) {
					$this->flashMessenger()->addErrorMessage(sprintf('Entity not found'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
	
				$semantiques = $this->getEntityManager()
				->getRepository('Collection\Entity\SemantiqueArtefact')
				->findBy(array('type_origine' => $elementOrigine->type_element->id, 'type_destination' => $elementDestination->type_element->id));
	
				$viewModel   = new ViewModel(
						array(
								'semantiques'   => $semantiques,
								'idOrigine'     => $idElementOrigine,
								'idDestination' => $idElementDestination,
								'titreOrigine' => $elementOrigine->titre,
								'titreDestination' => $elementDestination->titre
						)
				);
	
				$viewModel->setTerminal(true);
				return $viewModel->setTemplate('Collection/Element/addSemantiqueModal.phtml');
	
				//Si la sémantique est présente en paramétre, on crée la relation et la persiste
			} else {
	
				$idElementDestination = (int) $this->params()->fromRoute('idDestination', 0);
				$idElementOrigine     = (int) $this->params()->fromRoute('idOrigine', 0);
	
				if (!$idElementDestination) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément de destination.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
	
				if (!$idElementOrigine) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant de l\'élément d\'origine.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
	
				$testRelationArtefacts = $this->getEntityManager()
				->getRepository('Collection\Entity\RelationArtefacts')
				->findOneBy( array( 'origine' => $idElementOrigine, 'destination' => $idElementDestination, 'semantique' => $idSemantique ));
	
				if( $testRelationArtefacts != null ){
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
	
				$elementOrigine = $this->getEntityManager()
				->getRepository('Collection\Entity\Element')
				->findOneBy( array( 'id' => $idElementOrigine ));
	
				$elementDestination = $this->getEntityManager()
				->getRepository('Collection\Entity\Element')
				->findOneBy( array( 'id' => $idElementDestination ));
	
				$semantique = $this->getEntityManager()
				->getRepository('Collection\Entity\SemantiqueArtefact')
				->findOneBy( array( 'id' => $idSemantique ));
	
				if ( $elementOrigine === null || $elementDestination === null || $semantique === null ) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
	
				try {
					$relationArtefacts = new \Collection\Entity\RelationArtefacts($elementOrigine, $elementDestination, $semantique);
					$this->getEntityManager()->persist($relationArtefacts);
					$this->getEntityManager()->flush();
				} catch (Exception $e) {
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Erreur durant l\'insertion en base de donnée.'));
					return $this->getResponse()->setContent(Json::encode( array( 'success' => false) ));
				}
				$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été ajoutée.'));
				return $this->getResponse()->setContent(Json::encode( array( 'success' => true) ));
			}
				
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
	
	/**
	 * Suppression d'une relation entre deux artefacts
	 *
	 * Cette action est déclenchée par un appel AJAX
	 * lancé depuis la modale de confirmation dans la vue.
	 * L'id de la relation à supprimer est passé en paramètre de la requête.
	 */
	public function supprimerRelationArtefactSemantiqueAction()
	{
		$idRelation = (int) $this->params('idRelation', null);
		$relation = $this->getEntityManager()
			->getRepository('Collection\Entity\RelationArtefacts')
			->findOneBy(array('id'=>$idRelation));
		if ($idRelation === null || $relation === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$this->getEntityManager()->remove($relation);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été supprimée.'));
		return $this->getResponse()->setContent(Json::encode(true));
	}
	
    /**
     * Crée la relation entre un artefact et un média
     * Depuis la page d'édition d'un média
     *
     * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
     * Elle récupère l'id du artefact présent dans les paramètres de la route puis l'id
     * du média depuis les variables POST. On vérifie ensuite que tous les ids
     * sont bien présents et on vérifie que les ids correspondent à un élément en
     * base de donnée. Et enfin on ajoute la relation.
     *
     * @return void|\Zend\Stdlib\mixed
     */
    public function addRelationMediaArtefactAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) {
    			
    		$idArtefact = (int) $this->params()->fromRoute('idArtefact', 0);
    		$idMedia    = (int) $this->params()->fromPost('idMedia', 0);
    			
    		if (!$idMedia) {
    			$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour le média'));
    			return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
    		}
    			
    		if (!$idArtefact) {
    			$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour l\'artefact'));
    			return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
    		}
    
    		$artefact = $this->getEntityManager()
	    		->getRepository('Collection\Entity\Artefact')
	    		->findOneBy( array( 'id' => $idArtefact ));
	    
    		$media = $this->getEntityManager()
	    		->getRepository('Collection\Entity\Media')
	    		->findOneBy( array( 'id' => $idMedia ));
    			
    		if ( $media === null || $artefact === null ) {
    			$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable'));
    			return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
    		}
    			
    		foreach($artefact->medias as $mediaArt){
    			if($mediaArt->id === $media->id ){
    				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà'));
    				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
    			}
    		}
    
    		try {
    			$artefact->medias->add($media);
    			$this->getEntityManager()->flush();
    		} catch (Exception $e) {
    			$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Erreur durant l\'insertion en base de donnée'));
    			return $this->getResponse()->setContent(Json::encode( array( 'success' => false)));
    		}
    		$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été ajoutée.'));
    		return $this->getResponse()->setContent(Json::encode( array( 'success' => true, 'message' => 'La relation a bien été ajoutée.' ) ));
    
    	} else {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    }
    
    /**
     * Crée la relation entre un média et un artefact
     * Depuis la page d'édition d'un artefact
     *
     * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
     * Elle récupère l'id du artefact présent dans les paramètres de la route puis l'id
     * du média depuis les variables POST. On vérifie ensuite que tous les ids
     * sont bien présents et on vérifie que les ids correspondent à un élément en
     * base de donnée. Et enfin on ajoute la relation.
     *
     * @return void|\Zend\Stdlib\mixed
     */
    public function addRelationArtefactMediaAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
			
			$idMedia = (int) $this->params()->fromRoute('idMedia', 0);
			$idArtefact = (int) $this->params()->fromPost('idArtefact', 0);
			
			if (!$idMedia) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour le média'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
			
			if (!$idArtefact) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour l\'artefact'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}

			$artefact = $this->getEntityManager()
						     ->getRepository('Collection\Entity\Artefact')
						     ->findOneBy( array( 'id' => $idArtefact ));

			$media = $this->getEntityManager()
						  ->getRepository('Collection\Entity\Media')
						  ->findOneBy( array( 'id' => $idMedia ));
			
			if ( $media === null || $artefact === null ) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
			
			foreach($artefact->medias as $mediaArt){
				if($mediaArt->id === $media->id ){
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
			}

			try {
				$artefact->medias->add($media);
				$this->getEntityManager()->flush();
			} catch (Exception $e) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Erreur durant l\'insertion en base de donnée'));
				return $this->getResponse()->setContent(Json::encode( array( 'success' => false)));
			}
			$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été ajoutée.'));
			return $this->getResponse()->setContent(Json::encode( array( 'success' => true, 'message' => 'La relation a bien été ajoutée.' ) ));

		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
	
	/**
	 * Suppression d'une relation entre un média et un artefact
	 * Depuis la page d'édition d'un média
	 *
	 * Cette action est déclenché par un appel AJAX
	 * lancé depuis la modale de confirmation dans la vue.
	 * Les id du média et de l'artefact à délier son pssés en
	 * paramètre de la requête
	 */
	public function supprimerRelationMediaArtefactAction()
	{
		$idArtefact = (int) $this->params('idArtefact', null);
		$idMedia = (int) $this->params('idMedia', null);
		$artefact = $this->getEntityManager()
		->getRepository('Collection\Entity\Artefact')
		->findOneBy(array('id'=>$idArtefact));
		$media = $this->getEntityManager()
		->getRepository('Collection\Entity\Media')
		->findOneBy(array('id'=>$idMedia));
		if ($idMedia === null || $idArtefact === null
				|| $artefact === null || $media === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$artefact->medias->removeElement($media);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La relation a bien été supprimée.'));
		return $this->getResponse()->setContent(Json::encode(true));
	}
	
	
	/**
	 * Retourne une liste de tous les artefacts à la Datatable
	 *
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle prend en paramètre les conditions renvoyées par le widget Datatable et précisés
	 * au moment de l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en base de donnée. Ces données
	 * sont ensuite passées à la Datatable qui se chargera de les afficher.
	 *
	 */
    public function getAllArtefactAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
    	$params = null;
	
		if ($this->getRequest()->isXmlHttpRequest()) {
			
			$params = $this->params()->fromPost();

			if(!isset($params["iSortCol_0"])){
				$params["iSortCol_0"] = '0';
			}
			 
			if(!isset($params["sSortDir_0"])){
				$params["sSortDir_0"] = 'ASC';
			}
	
			$entityManager = $this->getEntityManager()
							      ->getRepository('Collection\Entity\Element');
			 
			$dataTable = new \Collection\Model\ElementDataTable($params);
			$dataTable->setEntityManager($entityManager);
			 
			$dataTable->setConfiguration(array(
					'titre',
					'type'
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
				$titre = '';
				$titre = '
						<a class="href-type-element" 
						href="'.$this->url()->fromRoute('element/voir', array('id' => $element->id)).'">
							<i class="icon-tag"> </i>'.$escapeHtml($element->titre).'</a>';
	
				$type_origine = $this->params()->fromRoute('type_origine');
				if ($type_origine == 'media') {
					$bouton = '<a href="#" class="btn btn-primary ajouter btn-block" 
						data-url="'.$this->url()->fromRoute('relation/addRelationMediaArtefact', array('idArtefact' => $element->id)).'">
						<i class="icon-plus"></i> Lier </a>';
				} else {
					$bouton = '<a href="#" class="btn btn-primary ajouter btn-block" 
						data-url="'.$this->url()->fromRoute('relation/addRelationArtefactSemantique', array('idDestination' => $element->id)).'">
						<i class="icon-plus"></i> Lier </a>';
				}
				$aaData[] = array(
						$titre,
						$element->type_element->nom,
						$bouton
				);
			}
			$dataTable->setAaData($aaData);
			return $this->getResponse()->setContent($dataTable->findAll());
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
	
	/**
	 * Retourne une liste de tous les médias à la Datatable
	 *
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle prend en paramètre les conditions renvoyées par le widget Datatable et précisés
	 * au moment de l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en base de donnée. Ces données
	 * sont ensuite passées à la Datatable qui se chargera de les afficher.
	 *
	 */
	public function getAllMediaAction()
	{
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
		$escapeHtml = $viewHelperManager->get('escapeHtml');
		$params = null;
	
		if ($this->getRequest()->isXmlHttpRequest()) {
				
			$params = $this->params()->fromPost();
	
			if(!isset($params["iSortCol_0"])){
				$params["iSortCol_0"] = '0';
			}
	
			if(!isset($params["sSortDir_0"])){
				$params["sSortDir_0"] = 'ASC';
			}
	
			$entityManager = $this->getEntityManager()
				->getRepository('Collection\Entity\Element');
	
			$dataTable = new \Collection\Model\ElementDataTable($params);
			$dataTable->setEntityManager($entityManager);
	
			$dataTable->setConfiguration(array(
					'titre',
					'type'
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
	
				$titre = '<a class="href-type-element" href="'.$this->url()->fromRoute('element/voir', array('id' => $element->id)).'">'.
					'<i class="icon-picture"> </i> '.$escapeHtml($element->titre).'</a>';

				$bouton = '<a href="#" class="btn btn-primary ajouter btn-block" data-url="'.$this->url()->fromRoute('relation/addRelationArtefactMedia', array('idMedia' => $element->id)).'"><i class="icon-plus"></i> Lier </a>';
	
				$aaData[] = array(
						$titre,
						$element->type_element->nom,
						$bouton
				);
			}
	
			$dataTable->setAaData($aaData);
	
			return $this->getResponse()->setContent($dataTable->findAll());
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}

}
