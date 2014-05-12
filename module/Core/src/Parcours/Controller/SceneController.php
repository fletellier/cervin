<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Parcours\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Parcours\Entity\SceneRecommandee;
use Parcours\Entity\SceneSecondaire;
use Parcours\Entity\TransitionRecommandee;
use Zend\Json\Json;

/**
 * Controleur des scènes
 *
 * Permet la création, lecture, modification et suppression d'une scène
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class SceneController extends AbstractActionController
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

    public function indexAction()
    {
    	return $this->redirect()->toRoute('parcours');
    }

    /**
     * Consultation la fiche d'une scène
     * 
     * @return void|\Zend\View\Model\ViewModel
     */
    public function voirSceneAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
		try {
			$Scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		} catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
            return;
		}
		if ($Scene==null || !$id) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		if (!$Scene->sous_parcours->parcours->public && !$this->isAllowed('Utilisateur')) {
			$this->flashMessenger()->addErrorMessage(sprintf('Ce parcours n\'est pas accessible au public, vous devez vous connecter pour pouvoir le consulter.'));
			return $this->redirect()->toRoute('zfcuser/login');
		}
		
		return new ViewModel(array('scene' => $Scene));
    }

    /**
     * Création d'une scène secondaire dans le vide
     * au sein d'un sous-parcours passé en paramètre
     */
    public function creerSceneSecondaireAction()
    {
		$id = (int) $this->params()->fromRoute('idsp', 0);
		try {
			$SousParcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$id));
		} catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
            return;
		}
		if ($SousParcours==null || !$id) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$newScene = new SceneSecondaire();
		$newScene->titre = "Nouvelle scène";
		$newScene->narration = "Narration à écrire...";
		$SousParcours->addScene($newScene);
		$this->getEntityManager()->flush();

    	$this->flashMessenger()->addSuccessMessage(sprintf('Une nouvelle scène a été ajoutée.'));
    	return $this->redirect()->toRoute('parcours/voir', array('id' => $SousParcours->parcours->id));
    }
    
    /**
	 * Suppression d'une scène secondaire
	 * 
	 * On ne peut supprimer une scène secondaire d'un parcours que si elle est isolée
	 * (aucune transition entrante ou sortante)
	 */
    public function retirerSceneSecondaireAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		
		if ($id === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		$sceneSecondaire = $this->getEntityManager()->getRepository('Parcours\Entity\SceneSecondaire')->findOneBy(array('id'=>$id));
		
		if ($sceneSecondaire === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$parcours = $sceneSecondaire->sous_parcours->parcours;
		$presenceTransition = null;
		
		if( ( $sceneSecondaire->transitions_secondaires !== null && $sceneSecondaire->transitions_secondaires->count() > 0 )
			|| ( $sceneSecondaire->transitions_secondaires_entrantes !== null && $sceneSecondaire->transitions_secondaires_entrantes->count() > 0 ) ){
			$presenceTransition = true;
		} else {
			$presenceTransition = false;
		}

		if ($this->getRequest()->isXmlHttpRequest()){
			
			$viewModel = new ViewModel( array( 'sceneSecondaire' => $sceneSecondaire, 'presenceTransition' => $presenceTransition ));
			$viewModel->setTerminal(true);
			return $viewModel->setTemplate('Parcours/Scene/modal-suppression.phtml');
			
		} else {
			if(!$presenceTransition){
				try{
					$this->getEntityManager()->remove($sceneSecondaire);
					$this->getEntityManager()->flush();
				} catch (Zend_Exception $e) {
					//echo "Caught exception: " . get_class($e) . "\n";
					//echo "Message: " . $e->getMessage() . "\n";
					$this->flashMessenger()->addErrorMessage(sprintf('Une erreur est survenue.'));
					return $this->redirect()->toRoute('scene/voirScene',array('id' => $sceneSecondaire->id));
				}
				$this->flashMessenger()->addSuccessMessage(sprintf('La scène a bien été supprimée.'));
				return $this->redirect()->toRoute('parcours/voir', array('id' => $parcours->id));
			} else {
				$this->flashMessenger()->addErrorMessage(sprintf('Vous ne pouvez pas supprimer cette scène car elle est rattachée à une ou plusieurs transitions.'));
				return $this->redirect()->toRoute('scene/voirScene',array('id' => $sceneSecondaire->id));
			}
			//return $this->getResponse()->setContent(Json::encode( array( 'success' => true)));
		}

	}
	
	/**
	 * Insertion d'une scène dans le chemin recommandé
	 * 
	 * Deux types de requêtes sont traitées ici, 
	 * selon si on veut ajouter une scène avant ou après une scène existante
	 * dans le chemin recommandé
	 * On sait de quel type de requête il s'agit grâce à l'attribut 'name' envoyé dans la requête
	 * Si l'attribut idNouvelleScene vaut 0, c'est qu'on créé une nouvelle scène
	 * sinon il désigne la scène existante que l'on insère dans le chemin recommandé
	 */
	public function insererSceneRecommandeeAction()
	{

		$request = $this->params()->fromPost();
		$idScene = (int) $request['idScene'];
		$idNouvelleScene = (int) $request['idNouvelleScene'];
        $type = $request['type'];
        if (null === $idScene or null === $type) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        $scene = $this->getEntityManager()->getRepository('Parcours\Entity\SceneRecommandee')->findOneBy(array('id'=>$idScene));
		if ($scene === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		// On commence par créer une nouvelle scène et une nouvelle 
		// transition recommandée dans le sous-parcours
		$newScene = new SceneRecommandee();
		$newScene->titre = 'Nouvelle scène';
		$newScene->narration = 'Narration à écrire';
		$scene->sous_parcours->addScene($newScene);
		$newTransitionRecommandee = new TransitionRecommandee();
		$newTransitionRecommandee->narration = 'Nouvelle Transition';
		$this->getEntityManager()->persist($newScene);
		$this->getEntityManager()->persist($newTransitionRecommandee);
        switch ($type) {
        	
        	case 'ajAvant': // On ajoute une scène avant $scene
        		$tr_before = $this->getEntityManager()->getRepository('Parcours\Entity\TransitionRecommandee')->findOneBy(array('scene_destination'=>$scene));
        		if ($tr_before === null) { 
        			// c'est la première scène du parcours :
        			// on change la scene de depart qui est alors $newScene
        			// et $newTransitionRecommandee relie $newScene à $scene
        			$scene->sous_parcours->scene_depart = $newScene;

        			// on ajoute la transition au sous_parcours
					$scene->sous_parcours->addTransition($newTransitionRecommandee);
        			$newTransitionRecommandee->scene_origine = $newScene;
        			$newTransitionRecommandee->scene_destination = $scene;

        		} elseif($tr_before->sous_parcours == null) {
        			// Ce n'est pas la première du parcour mais la première scène du sous parcours: on doit insérer $newScene entre $sceneBefore et $scene
        			$sceneBefore = $tr_before->scene_origine;

        			// On defini cette nouvelle scène comme sene de depart.
        			$scene->sous_parcours->scene_depart = $newScene;
        			// $newTransitionRecommandee relie $sceneBefore et $newScene
        			$newTransitionRecommandee->scene_origine = $sceneBefore;
        			$newTransitionRecommandee->scene_destination = $newScene;
        			// on ajoute la transition au parcours
					$scene->sous_parcours->parcours->addTransition($newTransitionRecommandee);
        			// On ajoute la tr_before au sous parcours 
        			$tr_before->sous_parcours = $scene->sous_parcours;
        			// Et on la supprime du parcours
        			$tr_before->parcours = null;
        			// La transition qui reliait $sceneBefore et $scene ($tr_before) relie maintenant $newScene et $scene
        			$tr_before->scene_origine = $newScene;
        		} else{ 
        			// Ce n'est pas la première : on doit insérer $newScene entre $sceneBefore et $scene
        			$sceneBefore = $tr_before->scene_origine;
        			// on ajoute la transition au sous_parcours
					$scene->sous_parcours->addTransition($newTransitionRecommandee);
        			// $newTransitionRecommandee relie $sceneBefore et $newScene
        			$newTransitionRecommandee->scene_origine = $sceneBefore;
        			$newTransitionRecommandee->scene_destination = $newScene;
        			// La transition qui reliait $sceneBefore et $scene ($tr_before) relie maintenant $newScene et $scene
        			$tr_before->scene_origine = $newScene;
        		}
        		break;
        		
        	case 'ajApres':
        		// On ajoute une scène après $scene
        		$tr_after = $scene->transition_recommandee;
        		// on ajoute la transition au sous_parcours
				$scene->sous_parcours->addTransition($newTransitionRecommandee);
        		if ($tr_after === null) {
        			// c'est la dernière scène du parcours : $newTransitionRecommandee relie $newScene à $scene
        			$newTransitionRecommandee->scene_origine = $scene;
        			$newTransitionRecommandee->scene_destination = $newScene;
        		} else {
        			// Ce n'est pas la dernière : on doit insérer $newScene entre $scene et $sceneAfter
        			$sceneAfter = $tr_after->scene_destination;
        			// $newTransitionRecommandee relie $scene et $newScene
        			$newTransitionRecommandee->scene_origine = $scene;
        			$newTransitionRecommandee->scene_destination = $newScene;
        			// La transition qui reliait $scene et $sceneAfter ($tr_after) relie maintenant $newScene et $sceneAfter
        			$tr_after->scene_origine = $newScene;
        		}
        		break;
        		
        	default:
        		$this->getResponse()->setStatusCode(404);
        		return;
        		break;
        }
        
        if ($idNouvelleScene != 0) {
        	// On veut en fait insérer une scène existante dans le chemin recommandé
        	$sceneAInserer = $this->getEntityManager()->getRepository('Parcours\Entity\SceneSecondaire')->findOneBy(array('id'=>$idNouvelleScene));
        	if ($scene === null) {
        		$this->getResponse()->setStatusCode(404);
        		return;
        	}
        	// On remplit la nouvelle scène avec les données de $sceneAInserer
        	$newScene->titre = $sceneAInserer->titre;
        	$newScene->narration = $sceneAInserer->narration;
        	$newScene->elements = $sceneAInserer->elements;
        	// On relie les transitions
        	foreach ($sceneAInserer->transitions_secondaires as $tr) {
        		$tr->scene_origine = $newScene;
        	}
        	foreach ($sceneAInserer->transitions_secondaires_entrantes as $tr) {
        		$tr->scene_destination = $newScene;
        	}
        	// On supprime la scène $sceneAInserer
        	$this->getEntityManager()->remove($sceneAInserer);
        }
        $this->getEntityManager()->flush();
        $this->flashMessenger()->addSuccessMessage(sprintf('Une nouvelle scène a été ajoutée.'));
        return $this->redirect()->toRoute('parcours/voir', array ('id' => $scene->sous_parcours->parcours->id));
	}
	
	/**
	 * Retirer une scène du chemin recommandé
	 * 
	 * La scène est remplacée par une scène secondaire 
	 * et conserve toutes ses transitions secondaires environnantes
	 * Les scènes recommandées voisine sont reliées pour garder la
	 * structure du chemin recommandé
	 */
	public function retirerSceneRecommandeeAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\SceneRecommandee')->findOneBy(array('id'=>$id));
		if (null === $id || $scene === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$parcours = $scene->sous_parcours->parcours;
		$tr_before = $scene->transition_recommandee_entrante;
		$tr_after = $scene->transition_recommandee;
		if ( ($tr_before === null || $tr_before->scene_origine->sous_parcours != $scene->sous_parcours)
				&& ($tr_after === null || $tr_after->scene_destination->sous_parcours != $scene->sous_parcours))
			// La scène que est la seule recommandée du sous-parcours
			// On ne peut pas l'enlever
		{
			$this->flashMessenger()->addErrorMessage(sprintf('Impossible de retirer cette scène du chemin recommandé car c\'est la seule dans ce sous-parcours'));
			return $this->getResponse()->setContent(Json::encode(true));
		}
		// On créé une scène secondaire dans le même sous-parcours
		// qui va remplacer la scène recommandée qu'on retire
		$newScene = new SceneSecondaire();
		$newScene->titre = $scene->titre;
		$newScene->narration = $scene->narration;
		$newScene->elements = $scene->elements;
		$scene->sous_parcours->addScene($newScene);
		foreach ($scene->transitions_secondaires as $tr) {
			$tr->scene_origine = $newScene;
		}
		foreach ($scene->transitions_secondaires_entrantes as $tr) {
			$tr->scene_destination = $newScene;
		}
		
		// On retire la scène du chemin recommandé
		if($tr_before === null) 
		// c'est la première scène recommandée du parcours
		{
			// la nouvelle première est la suivante
			$scene->sous_parcours->scene_depart = $tr_after->scene_destination;
			$this->getEntityManager()->remove($tr_after);
		}
		elseif($tr_after === null)
		// c'est la dernière scène recommandée du parcours
		{
			$this->getEntityManager()->remove($tr_before);
		}
		else 
		// elle est au milieu
		{
			// C'est la première scène recommandée du sous_parcours
			if ($scene->sous_parcours->scene_depart == $scene) {
				$tr_after->parcours = $parcours;
				$tr_after->sous_parcours = null;
				$scene->sous_parcours->scene_depart = $tr_after->scene_destination;
			}
			// rediriger la transition d'après sur la scène d'avant pour garder la cohérence
			$tr_after->scene_origine = $tr_before->scene_origine;
			$this->getEntityManager()->remove($tr_before);
		}
		// On supprime la scène qu'on vient de retirer du chemin recomandée
		$this->getEntityManager()->remove($scene);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La scène a bien été retirée du chemin recommandé.'));
		return $this->getResponse()->setContent(Json::encode(true));
	}

	/**
	 * Modification d'une donnée d'une scène
	 * 
	 * Selon l'attribut 'name' de la requête, on sait si on
	 * modifie le titre où la description de la scène
	 * 
	 * @return void|\Zend\View\Model\ViewModel
	 */
	public function editSceneAction()
	{
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
		$escapeHtml = $viewHelperManager->get('escapeHtml');
		$id = (int) $this->params()->fromRoute('id', 0);
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$id));
		if (!$id or $scene === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        if ($scene->sous_parcours->utilisateur != $this->zfcUserAuthentication()->getIdentity()) {
        	$this->flashMessenger()->addErrorMessage(sprintf('Le sous-parcours <em>'. $escapeHtml($scene->sous_parcours->titre) .'</em> doit faire partie de vos chantiers en cours pour que vous puissiez modifier cette scène.'));
        	return $this->redirect()->toRoute('scene/voirScene', array('id'=>$scene->id));
        }
        
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'titre':
					$scene->titre = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;

				case 'description':
					$scene->narration = $request['value'];
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(true));
				break;
			}
			return $this->getResponse()->setContent(Json::encode(true));
		}
		$SemantiqueTransitions = $this->getEntityManager()
			->getRepository('Parcours\Entity\SemantiqueTransition')
			->findBy(array(), array('semantique'=>'asc'));
		$scenes_parcours = $scene->sous_parcours->scenes;
		return new ViewModel(array(
				'scene' => $scene,
				'SemantiqueTransitions' => $SemantiqueTransitions,
				'scenes_parcours' => $scenes_parcours
		));
	}

	/**
	 * Supprimer un élément du contenu de la scène
	 * 
	 * La liaison entre la scène et l'élément est supprimée
	 */
	public function deleteElementAction()
	{
		$idScene = (int) $this->params('idScene', null);
		$idElement = (int) $this->params('idElement', null);
		$scene = $this->getEntityManager()->getRepository('Parcours\Entity\Scene')->findOneBy(array('id'=>$idScene));
		$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$idElement));

		$scene->elements->removeElement($element);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('L\'élément a bien été retiré de la scène'));
		return $this->getResponse()->setContent(Json::encode(true));
	}
	
	/**
	 * Retourne une liste de tous les éléments de la scène à la Datatable
	 *
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle prend en paramètre les conditions renvoyées par le widget Datatable et précisés
	 * au moment de l'instanciation du widget. Ces paramètres sont ensuite envoyé à la classe
	 * Datatable qui se charge de renvoyer les données récupérées en base de donnée. Ces données
	 * sont ensuite passées à la Datatable qui se chargera de les afficher.
	 *
	 */
	public function getAllElementAction()
	{
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
				if($element->type_element->type == 'artefact'){
					$titre = '<p class="text-success"><i class="icon-tag"> </i><a class="href-type-element text-success" href="'.$this->url()->fromRoute('artefact/voirArtefact', array('id' => $element->id)).'">'.$element->titre.'</a></p>';
				} elseif($element->type_element->type == 'media'){
					$titre = '<p class="text-warning"><i class="icon-picture"> </i><a class="href-type-element text-warning" href="'.$this->url()->fromRoute('media/voirMedia', array('id' => $element->id)).'">'.$element->titre.'</a></p>';
				} else {
					$titre = $element->titre;
				}
				$bouton = '<a href="#" class="btn btn-primary ajouter" data-url="'.$this->url()->fromRoute('scene/addRelationSceneElement', array('idElement' => $element->id)).'"><i class="icon-plus"></i> Lier </a>';
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
	 * Crée la relation entre un élément et une scène
	 * 
	 * Cette action est déclenchée par un appel AJAX sinon elle renvoie une erreur 404.
	 * Elle récupère l'id de l'élément présent dans les paramètres de la route puis l'id 
	 * de la scène depuis les variables POST. On vérifie ensuite que tous les ids 
	 * sont bien présents et on vérifie que les ids correspondent à un élément en 
	 * base de donnée. Et enfin on ajoute la relation. 
	 * 
	 * @return void|\Zend\Stdlib\mixed
	 */
	public function addRelationSceneElementAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
	
			$idElement = (int) $this->params()->fromRoute('idElement', 0);
			$idScene   = (int) $this->params()->fromPost('idScene', 0);
	
			if (!$idElement) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour l\'élément.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
	
			if (!$idScene) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Id manquant pour la scène.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
			}
	
			$element = $this->getEntityManager()
			->getRepository('Collection\Entity\Element')
			->findOneBy( array( 'id' => $idElement ));
	
			$scene = $this->getEntityManager()
			->getRepository('Parcours\Entity\Scene')
			->findOneBy( array( 'id' => $idScene ));
	
			if ( $element === null || $scene === null ) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Une des entités est introuvable.'));
				return $this->getResponse()->setContent(Json::encode(array( 'success' => false, 'error' => 'Une des entités est introuvable' )));
			}

			foreach($scene->elements as $elementScene){
				if($elementScene->id === $element->id ){
					$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Cette relation existe déjà.'));
					return $this->getResponse()->setContent(Json::encode(array( 'success' => false)));
				}
			}
	
			try {
				$scene->elements->add($element);
				$this->getEntityManager()->flush();
			} catch (Exception $e) {
				$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"></i> Erreur durant l\'insertion en base de donnée.'));
				return $this->getResponse()->setContent(Json::encode( array( 'success' => false, 'error' => 'Erreur durant l\'insertion en base de donnée' ) ));
			}
			
			$this->flashMessenger()->addSuccessMessage(sprintf('L\'élément a bien été ajouté à la scène.'));
			return $this->getResponse()->setContent(Json::encode( array( 'success' => true)));
	
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
	}
	
}