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
use Collection\Form\ChampTypeElementForm;
use Zend\Form\Form;
use Zend\Form\Element;
use Exception;
use Collection\Entity\Data;
use Collection\Entity\RelationArtefacts;
use Zend\File\Transfer\Adapter\Http;
use Zend\Json\Json;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

/**
 * Controleur des elements de la collection numérique
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class ElementController extends AbstractActionController
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
     * Change la visibilité d'un élément de la collection
     * 
     * Si l'élément est public, il devient brrouillon
     * Si l'élément est brouillon, il devient public
     *
     */
	public function changerVisibiliteAction() {
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
		$escapeHtml = $viewHelperManager->get('escapeHtmlAttr');
		$id = (int) $this->params()->fromRoute('id', 0);
		$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$id));
		if (!$id or $element === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		$element->public = !$element->public;
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('La visibilité de l\'élément <em>'. $escapeHtml($artefact->titre) .'</em> a bien été changée'));
		$return = $this->params()->fromRoute('return', 0);
		if ($return == 'editer') {
			return $this->redirect()->toRoute('element/editer', array('id' => $id));
		} else {
			return $this->redirect()->toRoute('element/voir', array('id' => $id));
		}
	}
	
	/**
	 * Création d'un élément
	 *
	 * On envoi à la vue la liste des types d'artefacts ou de média possibles
	 * Lorsque l'utilisateur en a choisi un, javascript dans le vue fait rappelle cette action.
	 * On envoie alors à la vue la formulaire correspondant pour créer un élément du type choisi
	 * Lorsque le formulaire est posté, on traite la requête
	 * et on créé l'élément avec les données remplies
	 *
	 * @return \Zend\View\Model\ViewModel
	 */
	public function ajouterAction()
	{
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
		$escapeHtml = $viewHelperManager->get('escapeHtml');
		$type = $this->params()->fromRoute('type', 0);
		$types_elements = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>$type));
		$type_element_id = (int) $this->params()->fromRoute('type_element_id', 0);
		$form = null;
		if ($type_element_id) {
			// Un type d'artefact a été choisi dans le select
			// On affiche le formulaire correspondant à ce type d'artefact
			$type_element = $this->getEntityManager()
				->getRepository('Collection\Entity\TypeElement')
				->findOneBy(array('id'=>$type_element_id));
			if ($type_element) {
				$form = new ChampTypeElementForm($this->getEntityManager(), $type_element);
			} else {
				$this->getResponse()->setStatusCode(404);
				return;
			}
			$request = $this->getRequest();
			if ($request->isPost()) {
				// Le formulaire a été posté
				// On créé le nouvel élément
				if ($type == 'artefact') {
					$element = new \Collection\Entity\Artefact(null, $type_element);
				} else {
					$element = new \Collection\Entity\Media(null, $type_element);
				}

				$form->setInputFilter($element->getInputFilter($form));
				
				$data = array_merge_recursive(
						$this->getRequest()->getPost()->toArray(),
						$this->getRequest()->getFiles()->toArray()
				);
				$form->setData($data);
				if ($form->isValid()) {
					$element->populate($this->getEntityManager(), $data);
					$this->getEntityManager()->persist($element);
					$this->getEntityManager()->flush();
					$this->flashMessenger()->addSuccessMessage(sprintf('L\'élément "%1$s" a bien ete créé.', $escapeHtml($element->titre)));
					//return $this->redirect()->toRoute('element/voirElement', array('id'=>$element->id));
					return $this->redirect()->toRoute('element/voir', array('id'=>$element->id));
				} else {
					return new ViewModel(array('type'=>$type, 'types_elements' => $types_elements, 'form' => $form, 'type_element_id'=>$type_element_id));
				}
			}
		}
		return new ViewModel(array('type'=>$type, 'types_elements' => $types_elements, 'form' => $form, 'type_element_id'=>$type_element_id));
	}
	
	/**
	 * Renvoie à la vue l'élément à afficher
	 *
	 * Renvoie à la vue l'élément à afficher
	 * après l'avoir cherché en base de données
	 * à partir de l'id passé dans l'url
	 *
	 * @return void|\Zend\View\Model\ViewModel
	 */
	public function voirAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		try {
			$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$id));
		}
		catch (\Exception $ex) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		if($element==null){
			$this->getResponse()->setStatusCode(404);
			return;
		}
	
		if (!$element->public && !$this->isAllowed('Utilisateur')) {
			$this->flashMessenger()->addErrorMessage(sprintf('Cet élément n\'est pas accessible au public, vous devez vous connecter pour pouvoir le consulter.'));
			return $this->redirect()->toRoute('zfcuser/login');
		}
	
		$ChampsDatasElement = $this->getEntityManager()
			->getRepository('Collection\Entity\Champ')
			->getChampsDatasElement($element, $element->type_element);
	
		return new ViewModel(array(
			'element' => $element,
			'ChampsDatasElement' => $ChampsDatasElement
		));
	}
	
	public function editerAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$id));
		if (!$id or $element === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		
		if ($element->utilisateur != $this->zfcUserAuthentication()->getIdentity()) {
			$this->flashMessenger()->addErrorMessage(sprintf('L\'élément doit faire partie de vos chantiers en cours pour que vous puissiez le modifier.'));
			return $this->redirect()->toRoute('element/voir', array('id'=>$id));
		}
		
		if ($this->getRequest()->isXmlHttpRequest())
		{
			$request = $this->params()->fromPost();
			switch ($request['name']) {
				case 'titre':
					$element->titre = $request['value'];
					$this->getEntityManager()->flush();
					return $this->getResponse()->setContent(Json::encode(true));
					break;
		
				case 'description':
					$element->description = $request['value'];
					$this->getEntityManager()->flush();
					return $this->getResponse()->setContent(Json::encode(true));
					break;
		
				case 'data':
					$idData = (int) $this->params()->fromRoute('idData', 0);
					$champData = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->getChampData($element, $idData);
					if (!$idData or $champData === null) {
						$this->getResponse()->setStatusCode(404);
						return;
					}
					if ($champData['data'] != null ) {
						$data = $champData['data'];
					} else {
						$champ = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->findOneBy(array('id'=>$champData['champ']->id));
						$data = 'new';
					}
					switch ($champData['champ']->format) {
						case 'select':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataSelect($element,$champ);
								$element->datas->add($data);
							}
							if ($request['value'] != null) {
								$select_option = $this->getEntityManager()->getRepository('Collection\Entity\SelectOption')->findOneBy(array('id'=>$request['value']));
								if ($select_option === null) {
									$this->getResponse()->setStatusCode(404);
									return;
								}
							} else {
								$select_option = null;
							}
							$data->option = $select_option;
							break;
						case 'texte':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataTexte($element,$champ);
								$element->datas->add($data);
							}
							$data->texte = $request['value'];
							break;
						case 'textarea':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataTextarea($element,$champ);
								$element->datas->add($data);
							}
							$data->textarea = $request['value'];
							break;
						case 'date':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataDate($element,$champ);
								$element->datas->add($data);
								$data->element = $element;
							}
							$data->format = $request['format'];
							switch ($request['format']) :
								case 2:
									$data->date = \DateTime::createFromFormat('Y', $request['value']);
									break;
								case 1:
									$data->date = \DateTime::createFromFormat('Y-m', $request['value']);
									break;
								case 0:
									$data->date = \DateTime::createFromFormat('Y-d-m', $request['value']);
									break;
							endswitch;
							break;
						case 'nombre':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataNombre($element,$champ);
								$element->datas->add($data);
							}
							$data->nombre = $request['value'];
							break;
						case 'fichier':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataFichier($element,$champ);
								$element->datas->add($data);
							}
							$files = $this->params()->fromFiles();
							$file = $files['file-input'];
							if ($file != null) {
								$element->deleteFile($data);
								$element->updateFile($data, $file['tmp_name'], $file['name'], $file['type']);
							}
							break;
						case 'url':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataUrl($element,$champ);
								$element->datas->add($data);
							}
							$data->url = $request['value'];
							break;
						case 'geoposition':
							if ($data == 'new') {
								$data = new \Collection\Entity\DataGeoposition($element,$champ);
								$element->datas->add($data);
							}
							$data->adresse = $request['adresse'];
							$data->latitude = $request['latitude'];
							$data->longitude = $request['longitude'];
							//return $this->getResponse()->setContent(Json::encode($request));
							break;
						default:
							return $this->getResponse()->setContent(Json::encode(false));
							break;
					} // end switch format
					$this->getEntityManager()->persist($data);
					$this->getEntityManager()->flush();
					return $this->getResponse()->setContent(Json::encode(true));
					break;
				default:
					return $this->getResponse()->setContent(Json::encode(false));
					break;
			} // end switch request name
		}
		$ChampsDatasElement = $this->getEntityManager()
				->getRepository('Collection\Entity\Champ')
				->getChampsDatasElement($element,$element->type_element);

		return new ViewModel(array(
				'element' => $element,
				'ChampsDatasElement' => $ChampsDatasElement));
	}
	
	/**
	 * Suppression d'un artefact
	 *
	 * On commence par récupérer l'artefact à supprimer :
	 * son ID est passé en paramètre dans la requête AJAX
	 * On pense bien à supprimer les éventuels fichiers uploadés pour cet artefact
	 */
	public function supprimerAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$element = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findOneBy(array('id'=>$id));
		if ($element === null or $id === null) {
			$this->getResponse()->setStatusCode(404);
			return;
		}
		foreach( ($element->datas) as $data){
			if($data->fichier !== null){
				$element->deleteFile($data);
			}
		}
		$this->getEntityManager()->remove($element);
		$this->getEntityManager()->flush();
		$this->flashMessenger()->addSuccessMessage(sprintf('L\'élément <em>'. $element->titre .'</em> a bien été supprimé.'));
		return $this->redirect()->toRoute('collection/consulter');
	}
	
}
