<?php
// ./module/Application/src/Application/View/Helper/AbsoluteUrl.php
namespace Application\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class ConditionsGenerales extends AbstractHelper
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
     * Affiche les conditions générales
     */ 
    public function __invoke($module = null, $user = null)
    {
    	$page = $this->getEntityManager()->getRepository('Application\Entity\Page')->findOneBy(array('slug' => 'conditions-generales'));
    	 
    	return $this->getView()->partial( 'zfc-user/user/ConditionsGenerales.phtml', array(
    			'page' => $page,
    	));
    }
}