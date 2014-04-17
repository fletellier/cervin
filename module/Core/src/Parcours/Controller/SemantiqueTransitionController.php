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
use Parcours\Form\SemantiqueTransitionForm;
use Parcours\Entity\SemantiqueTransition;
use Zend\Json\Json;
use Exception;

/**
 * Controleur des sémantiques des transitions
 *
 * Permet la création, lecture, modification et suppression de la sémantique des transitions
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class SemantiqueTransitionController extends AbstractActionController
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
	 * Renvoie à la vue toutes les sémantiques pour les afficher dans un tableau
	 * 
	 * @return \Zend\View\Model\ViewModel
	 */
	public function indexAction()
	{
		$semantiques = $this->getEntityManager()
							->getRepository('Parcours\Entity\SemantiqueTransition')
							->findBy(array(), array('semantique'=>'asc'));
		return new ViewModel(array('semantiques'=>$semantiques));
	}

	/**
	 * Ajout d'une nouvelle sémantique
	 * 
	 * Renvoie le formulaire à la vue
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
        $form = new SemantiqueTransitionForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$semantiqueTransition = new SemantiqueTransition();
		    $form->setInputFilter($semantiqueTransition->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$post = $request->getPost();
				$semantiqueTransition->populate($form->getData());
				$this->getEntityManager()->persist($semantiqueTransition);
			    $this->getEntityManager()->flush();
			 	$this->flashMessenger()->addSuccessMessage(sprintf('La sémantique a bien été créée.'));
	            return $this->redirect()->toRoute('semantiquetransition');
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
	 * Deux types de requêtes sont traitées ici, 
	 * selon si on veut modifier la sémantique elle-même ou bien sa description
	 * On sait de quel type de requête il s'agit grâce à l'attribut 'name' envoyé par la vue
	 */
	public function modifierAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) 
        {
			$id = (int) $this->params('id', null);
			$semantiqueTransition = $this->getEntityManager()
										->getRepository('Parcours\Entity\SemantiqueTransition')
										->findOneBy(array('id'=>$id));
			if ($semantiqueTransition === null || $id === null) {
				$this->getResponse()->setStatusCode(404);
				return;
			}
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'semantique':
					$semantiqueTransition->semantique = $request['value'];
			    	$this->getEntityManager()->flush();
					break;
					
				case 'description':
					$semantiqueTransition->description = $request['value'];
					$this->getEntityManager()->flush();
					break;
			
				default:
					$this->getResponse()->setStatusCode(404);
					break;
			}
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
	 * On vérifie ensuite si la sémantique est déjà utilisée dans une transition existante :
	 * 		Si non, on peut la supprimer sans problème
	 * 		Si oui, on ne doit pas la supprimer, on le signale à l'utilisateur 
	 */
	public function supprimerAction()
	{
		$id = (int) $this->params('id', null);
		$semantiqueTransition = $this->getEntityManager()
									->getRepository('Parcours\Entity\SemantiqueTransition')
									->findOneBy(array('id'=>$id));
		if ($semantiqueTransition === null || $id === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$transitions = $this->getEntityManager()->getRepository("Parcours\Entity\Transition")->findBy(array('semantique' => $semantiqueTransition));
		if(count($transitions) != 0){
			// La sémantique est déjà utilisée dans une transition, on ne peut pas la supprimer
			$this->flashMessenger()->addErrorMessage(sprintf('<i class="icon-warning-sign"> </i> La sémantique "'. $semantiqueTransition->semantique .'" ne peut pas être supprimée car elle est déjà utilisée dans une transition existante.'));
			return $this->getResponse()->setContent(Json::encode(true));
		} else {
			$this->getEntityManager()->remove($semantiqueTransition);
			$this->getEntityManager()->flush();
			$this->flashMessenger()->addSuccessMessage(sprintf('La sémantique "'. $semantiqueTransition->semantique .'" a bien été supprimée.'));
			return $this->getResponse()->setContent(Json::encode(true));
		}
	}

}
