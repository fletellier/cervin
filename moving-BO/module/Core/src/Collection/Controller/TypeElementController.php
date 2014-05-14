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
use Zend\View\Model\JsonModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Collection\Entity\Element;
use Collection\Entity\TypeElement;
use Collection\Entity\Data;
use Collection\Entity\DataDate;
use Collection\Entity\DataFichier;
use Collection\Entity\DataNombre;
use Collection\Entity\DataTexte;
use Collection\Entity\DataUrl;
use Collection\Entity\DataTextarea;
use Collection\Entity\Champ;
use Collection\Entity\ChampSelect;
use Collection\Form\ChampForm;
use Collection\Form\ChampSelectForm;
use Collection\Form\TypeElementForm;

/**
 * Controleur des types élément
 *
 * Permet d'ajouter, modifier et supprimer des types d'éléments qui sont composés de champs
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class TypeElementController extends AbstractActionController
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
     * Renvoie à la vue tous les types d'artefacts et de médias qu'elle doit gérer
     * 
     * @return multitype:unknown
     */
    public function indexAction()
    {
    	$TEartefacts = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'artefact'), array('nom' => 'ASC'));
    	$TEmedias = $this->getEntityManager()->getRepository('Collection\Entity\TypeElement')->findBy(array('type'=>'media'), array('nom' => 'ASC'));
    	return array(
    		'TEartefacts' => $TEartefacts,
    		'TEmedias' => $TEmedias,
    	);
    }

    /**
     * Ajout d'un nouveau type d'élément
     * 
     * L'ajout se fait en Ajax. Quand la fonction est appelée elle retourne 
     * le formulaire d'ajout d'un nouveau type d’élément. Et quand le formulaire est validé 
     * on crée le nouveau type d'element et on retourne True en json.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml        = $viewHelperManager->get('escapeHtml');
        
        $mediaArtefact     = $this->params()->fromRoute('media-artefact');
        
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $postData = $this->params()->fromPost();
            if($postData['name'] == 'ajTypeMedia')
            {
                $form = new TypeElementForm();
                $request = $this->getRequest();
                if ($postData['submit'] == 'true') {
                    $TypeElement = new TypeElement(null,$mediaArtefact);
                    $form->setInputFilter($TypeElement->getInputFilter());
                    $form->setData($request->getPost());
                    if ($form->isValid()) {
                        $TypeElement->populate($form->getData()); 
                        $this->getEntityManager()->persist($TypeElement);
                        $this->getEntityManager()->flush();
                        $this->flashMessenger()->addSuccessMessage(sprintf('Le Type d\'element "%1$s" a bien ete créé.', $escapeHtml( $TypeElement->nom ) ) );
                        return $this->getResponse()->setContent(Json::encode(true));
                    }
                }
                $viewModel = new ViewModel(array('form'=>$form));
                $viewModel->setTerminal(true);
                return $viewModel;
            }
        }
    }

	/**
	 * Modifie les types d'éléments
	 * 
	 * Cette fonction est forcément appelée à Ajax. Et elle permet de modifier les attributs
	 * des types d’éléments et aussi d'ajouter/modifier et supprimer des champs dans les types
	 *   d’éléments.
	 * Lors de l'appel Ajax l'URL doit contenir l'id du type l’élément sur lequel on souhaite 
	 * intervenir. 
	 * L'URL peut aussi avoir un 2e paramètre qui lui contiens l'id du champ sur lequel 
	 * on souhaite intervenir. 
	 * Un 3e paramètre permet de choisir l'action à effectuer ( $postData['name'; )
	 * Il y a donc 2 États différents : 
	 * - uniquement avec l'id du type d'élément :
	 * si name = nom > on set le nom du type d'élément avec :$postData['value'] 
	 * si name = ajchamp > on retourne le formulaire d'ajout d'un champ. Une fois valider les données du formulaire est aussi retournée ici et est enregistrées. Retourne true une fois le champ crée.
	 * si name = supprimerTypeElement > on supprime le type d’élément.
	 * - Avec l'id du type d'élément et l'id du champ :
	 * si name = label > on set le lable du champ 
	 * si name = descripetion > on set la description 
	 * si name = supprimerChamp > on supprime le champ identifié
	 * 
	 */
    public function editTypeElementAjaxAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
    	if ($this->getRequest()->isXmlHttpRequest()) 
        {
        	$id = (int) $this->params()->fromRoute('id', 0);
            $TypeElement = $this->getEntityManager()->find('Collection\Entity\TypeElement', $id);
            if (null === $TypeElement or $id === null) {
                $this->getResponse()->setStatusCode(404);
                return; 
            }
            $postData = $this->params()->fromPost();
            $idChamp = (int) $this->params()->fromRoute('idChamp', 0);
            if (!empty($idChamp)) {
                $Champ = $this->getEntityManager()->find('Collection\Entity\Champ', $idChamp);
	            if (null === $Champ) {
                    $this->getResponse()->setStatusCode(404);
                    return; 
                }
            	switch ($postData['name']) {
            		case 'label':
            			$Champ->label = $postData['value'];
		                $this->getEntityManager()->persist($Champ);
		                $this->getEntityManager()->flush();
                        return $this->getResponse()->setContent(Json::encode(array(true)));
            			break;
            		case 'description':
            			$Champ->description = $postData['value'];
		                $this->getEntityManager()->persist($Champ);
		                $this->getEntityManager()->flush();
                        return $this->getResponse()->setContent(Json::encode(array(true)));
            			break;
                    case 'supprimerChamp':
						if( $Champ->format === 'fichier' ){
							$Champ->deleteFiles();
						}
						$this->getEntityManager()->remove($Champ);
						$this->getEntityManager()->flush();
                        return $this->getResponse()->setContent(Json::encode(array('success'=>true,'message'=>'Le champ a bien été supprimé', 'type'=>'success')));
                        break;
            		default:
            			return $this->getResponse()->setContent(Json::encode(array('success'=>false,'error'=>'name inconu')));
            			break;
            	}
            	return $this->getResponse()->setContent(Json::encode(array('success'=>false,'error'=>'switch ??')));
            } else {
            	switch ($postData['name']) {
            		
            	case 'nom':
            		$TypeElement->nom = $postData['value'];
		            $this->getEntityManager()->persist($TypeElement);
		            $this->getEntityManager()->flush();
		            return $this->getResponse()->setContent(Json::encode(array('success'=>true)));
                    break;
                    
            	case 'ajChamp':
                    $formChamp = new ChampForm();
                    $selects = $this->getEntityManager()->getRepository('Collection\Entity\Select')->findAll();
                    $selectsArray = array();
                    $selectsArray2 = array();
                    foreach ($selects as $select) {
                        $selectsArray[$select->id] = $select->label;
                        $selectsArray2[]=$select->id;
                    }

                    $formChampSelect = new ChampSelectForm($selectsArray);
                    if ($postData['submit'] != 'false')
                    {
                        $request = $this->getRequest();
                        if ($request->getPost('typeChamp') == 'classique') {

                            $champ = new Champ();
                            $formChamp->setInputFilter($champ->getInputFilter());
                            $formChamp->setData($request->getPost());
                            if ($formChamp->isValid()) {
                                $champ->label = $request->getPost('label');
                                $champ->format = $request->getPost('format');
                                $champ->description = $request->getPost('description');
                                $champ->type_element = $TypeElement;

                                $this->getEntityManager()->persist($champ);
                                $this->getEntityManager()->flush();
                                
                                
                                $this->getEntityManager()->flush();
                                $this->flashMessenger()->addSuccessMessage(sprintf('Le Champ "%1$s" a bien été ajouté.', $escapeHtml($champ->label)));
                                return $this->getResponse()->setContent(Json::encode(true));
                            } else {
                            	// Form non valide
                                $viewModel = new ViewModel(array('formChamp' => $formChamp,'formChampSelect' => $formChampSelect,'Champ'=>'active','ChampSelect'=>''));
                                $viewModel->setTerminal(true);
                                return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');
                            }

                        } elseif ($request->getPost('typeChamp') == 'champSelect') {
                            $champSelect = new ChampSelect();
                            $formChampSelect->setInputFilter($champSelect->getInputFilter($selectsArray2));
                            $formChampSelect->setData($request->getPost());
                            if ($formChampSelect->isValid()) {
                                $idSelect = (int) $request->getPost('select');
                                $select = $this->getEntityManager()->getRepository('Collection\Entity\Select')->findOneBy(array('id'=>$idSelect));

                                $champSelect->label = $request->getPost('label');
                                $champSelect->format = 'select';
                                $champSelect->description = $request->getPost('description');
                                $champSelect->select = $select;
                                $champSelect->type_element = $TypeElement;

                                $this->getEntityManager()->persist($champSelect);
                                $this->getEntityManager()->flush();
                                $this->flashMessenger()->addSuccessMessage(sprintf('Le Champ "%1$s" a bien été ajouté.', $escapeHtml($champSelect->label)));
                                return $this->getResponse()->setContent(Json::encode(true));
                            } else {
                                // Form non valide
                                $viewModel = new ViewModel(array('formChamp' => $formChamp,'formChampSelect' => $formChampSelect,'Champ'=>'','ChampSelect'=>'active'));
                                $viewModel->setTerminal(true);
                                return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');
                            }
                        }
                    } 
                    $viewModel = new ViewModel(array('formChamp' => $formChamp,'formChampSelect' => $formChampSelect,'Champ'=>'active','ChampSelect'=>''));
                    $viewModel->setTerminal(true);
                    return $viewModel->setTemplate('Collection/Type-Element/addChampModal.phtml');
                    break; // end case ajChamp
                    
                case 'supprimerTypeElement':
	                $champsFichier = $this->getEntityManager()->getRepository('Collection\Entity\Champ')->findBy(array('type_element' => $TypeElement, 'format' => 'fichier'));
	                if ($champsFichier !== null) {
	                	foreach ($champsFichier as $champ) {
	                		$champ->deleteFiles();
	                	}
	                }
                    $this->getEntityManager()->remove($TypeElement);
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
                    break;
                    
                default:
                    return $this->getResponse()->setContent(Json::encode(array('success'=>false)));
                    break;
                } //end swith $postData['nama']
            } // end if (!empty($idChamp))
        } // end if ($this->getRequest()->isXmlHttpRequest()) 
    } // end action
    
}
