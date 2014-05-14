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
use Collection\Entity\SelectOption;
use Collection\Entity\Select;
use Doctrine\DBAL\DriverManager;
use Zend\Json\Json;

/**
 * Controleur du champ select
 *
 * Permet l'ajout , la modification ou la supression des Selects
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class ChampSelectController extends AbstractActionController
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
	 * Affiche la Datatable avec la liste des Select
	 *
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');

        if ($this->getRequest()->isXmlHttpRequest()) {
            $params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('Collection\Entity\Select');
        
            $dataTable = new \Admin\Model\LogsDataTable($params);
            $dataTable->setEntityManager($entityManager);
            
            $dataTable->setConfiguration(array(
	    		'label',
		        'description',
            ));

            $aaData = array();

            foreach ($dataTable->getPaginator() as $select) {

            	$apercu = '<select id="select2_'.$select->id.'" class="select">';

			    foreach ($select->select_options as $select_option) {
			    	$apercu .= '<option value="'.$select_option->id.'">'.$escapeHtml($select_option->text).'</option>';
			    }

			    $apercu .= '</select>';

                $action = '<a href="#" 
	            			data-url="'.$this->url()->fromRoute("champSelect/modifierOptionAjax", array("id" => $select->id)).'" 
	            			class="btn btn-primary modifierOption"
	            			data-toggle="popover"
	            			data-content="Ajouter / Modifier une valeur">
	            				<i class="icon-folder-open-alt"></i>
	            			</a>
	            			<a href="#ajouterCSVModal" 
	            			data-toggle="modal"
	            			data-url="'.$this->url()->fromRoute("champSelect/modifierOptionAjax", array("id" => $select->id)).'" 
	            			class="btn btn-primary ajouterCSV classPopover"
	            			data-content="Ajouter une liste CSV">
	            				<i class="icon-upload"></i>
	            			</a>
	            			<a href="#" 
	            			data-toggle="modal"
	            			data-id="'.$select->id.'" 
	            			class="btn btn-primary exportCSV classPopover"
	            			data-content="Exporter la liste au format CSV">
	            				<i class="icon-download"></i>
	            			</a>
	            			<a href="#" 
	            			data-url="'.$this->url()->fromRoute("champSelect/modifier", array("id" => $select->id)).'" 
	            			class="btn btn-danger supprimerSelect"
	            			data-toggle="popover"
	            			data-content="Supprimer le select ainsi que ces valeurs">
	            				<i class="icon-trash"></i>
	            			</a>';


                $aaData[] = array(
                	'<span id="modifierLable" 
                        class="text CursorPointer" 
                        data-url="'.$this->url()->fromRoute("champSelect/modifier", array("id" => $select->id)).'" 
                        data-value="'.$escapeHtml($select->label).'" data-placement="right" data-type="text" data-pk="1">'.$escapeHtml($select->label).'
                    </span>',
                    '<span id="modifierDescription" 
                        class="text CursorPointer" 
                        data-url="'.$this->url()->fromRoute("champSelect/modifier", array("id" => $select->id)).'" 
                        data-value="'.$escapeHtml($select->description).'" data-placement="right" data-type="textarea" data-pk="1">'.$escapeHtml($select->description).'
                    </span>',
                    $apercu,
	    			$action
                );
            }
            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
        } else {
            return new ViewModel();

        }
    }

    /**
	 * Ajouter un nouveaux formulaire 
	 *
	 * Enregistre un nouveaux select 
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function ajouterAction()
    {
    	
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			$postData = $this->params()->fromPost();

			$newSelect = new Select();
			$newSelect->label = $postData['labelSelect'];
			$newSelect->description = $postData['descriptionSelect'];
            $this->getEntityManager()->persist($newSelect);
            $this->getEntityManager()->flush();
            
            return $this->getResponse()->setContent(Json::encode(
	            array(
		                'message'=>'Le select à bien été créé',
		                'type'=>'success'
	                  	)
            ));
        }

		$this->getResponse()->setStatusCode(404);
    }

    /**
	 * Permet de podifier le nom, la descitpion d'un select. Permet aussi de supprimer un sélect avec ces options si celui ci n’est pas utilisé par un champSelect. 
	 *
	 * 
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function modifierAction()
    {
    	$id = (int) $this->params('id', null);
		$select = $this->getEntityManager()->getRepository('Collection\Entity\Select')->findOneBy(array('id'=>$id));
		if ($select == null or $id == null) {
			$this->getResponse()->setStatusCode(404);
			return; 
		}

        $postData = $this->params()->fromPost();
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			switch ($postData['name']) {
				case 'supprimerSelect':
					if ($select->champs_select->isEmpty()) {
						$this->getEntityManager()->remove($select);
						$this->getEntityManager()->flush();
						return $this->getResponse()->setContent(Json::encode(array('message'=>'Le select "'.$select->label.'" à bien été supprimée','type'=>'success')));
					}
					return $this->getResponse()->setContent(Json::encode(array('message'=>'Le select "'.$select->label.'" ne peut être supprimée car il est utilisé par type d\'élément','type'=>'error')));
					break;
				case 'modifierLable':
					$select->label = $postData['value'];
					$this->getEntityManager()->flush();
					return $this->getResponse()->setContent(Json::encode(array(true)));
					break;
				case 'modifierDescription':
					$select->description = $postData['value'];
					$this->getEntityManager()->flush();
					return $this->getResponse()->setContent(Json::encode(array(true)));
					break;
				default:
					$this->getResponse()->setStatusCode(404);
					return; 
					break;
			}
			$this->getResponse()->setStatusCode(404);
		}
    }

    /**
	 * 
	 *
	 * 
	 *
     * @return \Zend\View\Model\ViewModel
     */
    public function modifierOptionAjaxAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');

    	$id = (int) $this->params('id', null);
		$select = $this->getEntityManager()->getRepository('Collection\Entity\Select')->findOneBy(array('id'=>$id));
		if ($select == null or $id == null) {
			$this->getResponse()->setStatusCode(404);
			return; 
		}

        $postData = $this->params()->fromPost();
		if ($this->getRequest()->isXmlHttpRequest()) 
		{
			switch ($postData['name']) {
				case 'voirListe':
					$viewModel = new ViewModel(array('select' => $select));
                    $viewModel->setTerminal(true);
                    return $viewModel->setTemplate('Collection/Champ-Select/modifierOptionAjax.phtml');
					break;

				case 'ajouterOptionCSV':
					if(!empty($postData['delimiteur']) and !empty($postData['liste']))
					{

						$ListeCSV = str_getcsv($postData['liste'],$postData['delimiteur']);
						foreach ($ListeCSV as $key => $value) {
							$newOption = new SelectOption($select);
							$newOption->text = $value ;
		                    $this->getEntityManager()->persist($newOption);
						}
	                    $this->getEntityManager()->flush();
	                	return $this->getResponse()->setContent(Json::encode(array('message'=>'La liste CSV a bien été importée','type'=>'success')));
	                }
	                return $this->getResponse()->setContent(Json::encode(array('message'=>"Erreur lors de l'import de la liste CSV",'type'=>'error')));
	                break;

				case 'ajouterOption':
					$newOption = new SelectOption($select);
					$newOption->text = $postData['value'];
                    $this->getEntityManager()->persist($newOption);
                    $this->getEntityManager()->flush();
                    $addTable = '<td id="'.$newOption->id.'">
	                    <span id="label" 
	                        class="text CursorPointer" 
	                        data-url="'.$this->url()->fromRoute("champSelect/modifierOptionAjax", array("id" => $select->id, "idOption" => $newOption->id)).'" 
	                        data-value="'.$escapeHtml($newOption->text).'" 
	                        data-name="modifierTexte" 
	                        data-placement="right" 
	                        data-type="text" 
	                        data-pk="1">'.$escapeHtml($newOption->text).'
	                    </span>
                    </td>
                    <td>
			            <a class="btn btn-danger SupprimerOption" 
			            data-url="'.$this->url()->fromRoute("champSelect/modifierOptionAjax", array("id" => $select->id, "idOption" => $newOption->id)).'"
			            href="#">
			                <i class="icon-trash "></i> 
			            </a>
                	</td>
                    ';

                    return $this->getResponse()->setContent(Json::encode(array('message'=>'L\'Option à bien été ajoutée','type'=>'success','addTable'=>$addTable,'id'=>$newOption->id)));
					break;

				case 'modifierTexte':
					$idOption = (int) $this->params('idOption', null);
					$SelectOption = $this->getEntityManager()->getRepository('Collection\Entity\SelectOption')->findOneBy(array('id'=>$idOption));
					if ($SelectOption == null or $id == null) {
						$this->getResponse()->setStatusCode(404);
						return; 
					}

					$SelectOption->text = $postData['value'];
                    $this->getEntityManager()->flush();
                    return $this->getResponse()->setContent(Json::encode(true));
					break;
				case 'supprimerOption':
					$idOption = (int) $this->params('idOption', null);
					$SelectOption = $this->getEntityManager()->getRepository('Collection\Entity\SelectOption')->findOneBy(array('id'=>$idOption));
					if ($SelectOption == null or $id == null) {
						$this->getResponse()->setStatusCode(404);
						return; 
					}
					// si l'Option du select n'est pas utilisé dans un element alors on a supprime
					if ($SelectOption->datas->isEmpty()) {
	                    $this->getEntityManager()->remove($SelectOption);
	                    $this->getEntityManager()->flush();
	                    return $this->getResponse()->setContent(Json::encode(array('message'=>'L\'Option "'.$SelectOption->text.'" à bien été supprimée','type'=>'success')));
					}
	                return $this->getResponse()->setContent(Json::encode(array('message'=> 'L\'Option "'.$SelectOption->text.'" ne peut étre supprimée car elle est utilisée dans un element.','type'=>'error')));
					break;
				
				default:
					$this->getResponse()->setStatusCode(404);
					return; 
					break;
			}


		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}
    }


    
}
