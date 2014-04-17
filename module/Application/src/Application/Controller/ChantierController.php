<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Page;

class ChantierController extends AbstractActionController
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Return a EntityManager
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

    public function indexAction() {
        return new ViewModel();
    }

    public function demarrerChantierElementAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idElement = (int) $this->params()->fromRoute('idElement', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$idElement));
		if (!$idUser || !$idElement || $user == null || $element == null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		if ($element->utilisateur != null && $element->utilisateur != $idUser) {
			$user_chantier = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$element->utilisateur->id));
			$this->flashMessenger()->addErrorMessage(sprintf('L\'élément <em> '. $escapeHtml($element->titre) .'</em> est déjà en chantier par '. $escapeHtml($user_chantier->displayName) .'.'));
			return $this->redirect()->toRoute('element/voir', array('id'=>$idElement));
		}
		$element->utilisateur = $user;
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('L\'élément <em> '. $escapeHtml($element->titre) .'</em> fait maintenant partie de vos chantiers en cours.'));
		
		return $this->redirect()->toRoute('element/editer', array('id'=>$idElement));
    }
    
    public function terminerChantierElementAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idElement = (int) $this->params()->fromRoute('idElement', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$idElement));
    	if (!$idUser || !$idElement || $user == null || $element == null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$element->utilisateur = null;
    	$this->getEntityManager()->flush();
    	if ($element instanceOf \Collection\Entity\Artefact) {
    		$this->flashMessenger()->addSuccessMessage(sprintf('L\'artefact <em>'. $escapeHtml($element->titre) .'</em> n\'est plus en chantier.'));
    	} else {
    		$this->flashMessenger()->addSuccessMessage(sprintf('Le média <em>'. $escapeHtml($element->titre) .'</em> n\'est plus en chantier.'));
    	}
    	if (!$element->public) {
    		$this->flashMessenger()->addInfoMessage(sprintf('<i class="info-sign"></i> Cet élément est un <strong>Brouillon</strong>, si vos modifications sont terminées et vérifiées, pensez à le passer en public pour les rendre visibles (depuis la fiche de l\'élément).'));
    	}
    	$return = $this->params()->fromRoute('return', 0);
    	if ($return == 'admin') {
    		return $this->redirect()->toRoute('chantier/admin');
    	} elseif ($return == 'perso'){
    		return $this->redirect()->toRoute('chantier');
    	} else {
    		return $this->redirect()->toRoute('element/voir', array('id'=>$idElement));
    	}
    }
    
    public function demarrerChantierSousParcoursAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idSousParcours = (int) $this->params()->fromRoute('idSousParcours', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$idSousParcours));
    	if (!$idUser || !$idSousParcours || $user == null || $sous_parcours == null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	if ($sous_parcours->utilisateur != null  && $sous_parcours->utilisateur != $idUser) {
    		$user_chantier = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$sous_parcours->utilisateur->id));
    		$this->flashMessenger()->addErrorMessage(sprintf('Le sous parcours <em>'. $escapeHtml($sous_parcours->titre) .'</em> du parcours <em>'. $escapeHtml($sous_parcours->parcours->titre) .'</em> est déjà en chantier par '. $escapeHtml($user_chantier->displayName) .'.'));
    		return $this->redirect()->toRoute('parcours/voir', array('id'=>$sous_parcours->parcours->id));
    	}
    	$sous_parcours->utilisateur = $user;
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('Le sous parcours <em>'. $escapeHtml($sous_parcours->titre) .'</em> du parcours <em>'. $escapeHtml($sous_parcours->parcours->titre) .'</em> fait maintenant partie de vos chantiers en cours.'));

    	$return = $this->params()->fromRoute('return');
    	if ($return == 'parcours') {
    		return $this->redirect()->toRoute('parcours/voir', array('id'=>$sous_parcours->parcours->id));
    	} else {
    		$idReturn = $this->params()->fromRoute('idReturn');
    		if ($return == 'scene') {
	    		return $this->redirect()->toRoute('scene/editScene', array('id'=>(int)$idReturn));
    		} else {
    			return $this->redirect()->toRoute('transition/modifier', array('id'=>(int)$idReturn));
    		}
    	} 
    }
    
    public function terminerChantierSousParcoursAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$idUser = (int) $this->params()->fromRoute('idUser', 0);
    	$idSousParcours = (int) $this->params()->fromRoute('idSousParcours', 0);
    	$user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$idUser));
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$idSousParcours));
    	if (!$idUser || !$idSousParcours || $user == null || $sous_parcours == null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$sous_parcours->utilisateur = null;
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('Le sous parcours <em>'. $escapeHtml($sous_parcours->titre) .'</em> du parcours <em>'. $escapeHtml($sous_parcours->parcours->titre) .'</em> n\'est plus en chantier.'));
    	
    	/* Si aucun sous-parcours n'est en chantier
    	 * et que le parcours est brouillon
    	 * on affiche une notif pour passer le parcours en public*/
    	$aucun_chantier = true;
    	foreach ($sous_parcours->parcours->sous_parcours as $sous_parcours) {
    		if ($sous_parcours->utilisateur != null) {
    			$aucun_chantier = false;
    			break;
    		}
    	}
    	if ($aucun_chantier && !$sous_parcours->parcours->public) {
    		$this->flashMessenger()->addInfoMessage(sprintf('<i class="icon-info-sign"></i> Aucun sous-parcours n\'est maintenant en chantier, pourtant le parcours <em>'. $escapeHtml($sous_parcours->parcours->titre) .'</em> est un <strong>Brouillon</strong>. <br/> Si vos modifications sont terminées et vérifiées, pensez à le passer en public pour les rendre visibles (depuis la page d\'accueil du parcours).'));
    	}
    	$return = $this->params()->fromRoute('return');
    	if ($return == 'admin') {
    		return $this->redirect()->toRoute('chantier/admin');
    	} elseif ($return == 'perso'){
    		return $this->redirect()->toRoute('chantier');
    	} else {
    		return $this->redirect()->toRoute('parcours/voir', array('id'=>$sous_parcours->parcours->id));
    	}
    }
    
    public function adminAction() {
    	$em = $this->getEntityManager();
    	$query = $em->createQuery('SELECT e FROM Collection\Entity\Element e WHERE e.utilisateur IS NOT NULL');
		$elements = $query->getResult();
		$query = $em->createQuery('SELECT s FROM Parcours\Entity\SousParcours s WHERE s.utilisateur IS NOT NULL');
		$sous_parcours = $query->getResult();
		return new ViewModel(array('elements'=>$elements, 'sous_parcours'=>$sous_parcours));
    }
    
}
