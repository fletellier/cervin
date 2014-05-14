<?php
// ./module/Application/src/Application/View/Helper/AbsoluteUrl.php
namespace Application\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

 /**
  * Retourne la liste des rôles auxquelles un utilisateur peut postuler.
  * 
  * récupère la liste des rôles et crée un dropdown avec.
  * Quand un utilisateur choisi un rôle un appel Ajax sera fait a la route : admin/demandeRole/:id ( id = id du rôle choisi)
  * 
  * @return string
  */
class demandeRole extends AbstractHelper
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
	
    public function __invoke($rolesFils = false)
    {
    	$urlHelper = $this->view->plugin('url');
		$roles = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findAll();
        $return = '
            <div class="dropdown">
              <a class="dropdown-toggle btn btn-primary" id="roles" role="button" data-toggle="dropdown" href="#"><i class="icon-plus"></i> Demande de droits <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="roles">';
        foreach ($roles as $role) :
			if (!in_array($role->getRoleId(),$rolesFils)) {
        		$return .= '<li><a role="menuitem" tabindex="-1" href="'.$urlHelper("admin/demandeRole", array("id" => $role->getId())).'">'.$role->getRoleId().'</a></li>';
            }
		endforeach;
		$return .= '</ul> </div>';
        return $return;
    }
}

