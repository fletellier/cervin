<?php
namespace Collection\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

/**
 * Widget permettant d'appeler facilement une Datatable depuis une vue
 */
class DatatableWidget extends AbstractHelper
{
	/**
	 * @var Doctrine\ORM\EntityManager Entity Manager
	 */
	protected $em;
	
	/**
	 * @var Zend\ServiceManager\ServiceManager Service Manager
	 */
	protected $serviceLocator;
	
	/**
	 * Initialisation du Service Manager
	 *
	 * @param Zend\ServiceManager\ServiceManager Service Manager
	 * @return void
	 */
    public function setServiceLocator(ServiceManager $serviceLocator) 
    { 
        $this->serviceLocator = $serviceLocator; 
    }
    
    /**
     * Initialisation de l'Entity Manager
     *
     * @param Doctrine\ORM\EntityManager Entity Manager
     * @return void
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
    
    /**
     * Retourne l'Entity Manager
     *
     * @return Doctrine\ORM\EntityManager Entity Manager
     */
    public function getEntityManager()
    {
        if ($this->em === null) {
            $this->em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    /**
     * Fonction appelée lors de l'appel du widget
     * 
     * Elle permet d'inclure la bonne Datatable selon le paramètre passé 
     * et de passer les paramètres pour la requête à la Datatable.
     * 
     * @param string $view Vue de la Datatable à appeler
     * @param string $params Conditions pour la requête de la Datatable
     */
    public function __invoke($view = null, $params = null)
    {
    	$js_table = null;
    	if(isset($params)){
    		foreach ($params as $param){
    			$js_table .= ' data.push('.json_encode($param, JSON_FORCE_OBJECT).'); ';
    		}
    	}
    	$viewFile = null;
		
    	if($view === "scene"){
    		$viewFile = 'Parcours/Scene/RelationSceneElementWidget.phtml';
    	} else if($view === "semantique"){
    		$viewFile = 'Collection/Element/RelationArtefactSemantiqueWidget.phtml';
    	} else if($view === "artefact"){
    		$viewFile = 'Collection/Element/RelationArtefactMediaWidget.phtml';
    	} else if($view === "media"){
    		$viewFile = 'Collection/Element/RelationMediaArtefactWidget.phtml';
    	} else {
    		$viewFile = 'Collection/Collection/CollectionWidget.phtml';
    	}
    	
    	return $this->getView()->partial( $viewFile, array(  
	    	'js_table' => $js_table, 
	    ));
    }
}