<?php
// ./module/Application/src/Application/View/Helper/AbsoluteUrl.php
namespace Application\View\Helper;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class Notification extends AbstractHelper
{
	protected $em;
	protected $serviceLocator;

    public function setServiceLocator(ServiceManager $serviceLocator) 
    { 
        $this->serviceLocator = $serviceLocator; 
    } 

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if ($this->em === null) {
            $this->em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    // Retourne le nombres de notifications
    public function __invoke($module = null, $user = null)
    {
        switch ($module) {
            case 'user' :
                $Notification = $this->getEntityManager()->getRepository('SamUser\Entity\User')->countAttenteRole();
                break;
            case 'chantier':
            	$Notification = 0;
            	if ($user->elements_chantier != null) {
            		$Notification += $user->elements_chantier->count();
            	}
            	if ($user->sous_parcours_chantier != null) {
            		$Notification += $user->sous_parcours_chantier->count();
            	}
            	break;
            case 'chantier_admin':
            	$Notification = 0;
            	$em = $this->getEntityManager();
		    	$query = $em->createQuery('SELECT e FROM Collection\Entity\Element e WHERE e.utilisateur IS NOT NULL');
				$elements = $query->getResult();
				$Notification += count($elements);
				$query = $em->createQuery('SELECT s FROM Parcours\Entity\SousParcours s WHERE s.utilisateur IS NOT NULL');
				$sous_parcours = $query->getResult();
				$Notification += count($sous_parcours);
            	break;
            default:
                # code...
                break;
        }
    return $Notification;
    }
}