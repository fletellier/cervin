<?php
namespace SamUser\Service;


use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use ZfcUser\Service\User as ZfcUser2;

use SamUser\Entity\User;
use SamUser\Entity\Role;
use Doctrine\ORM\EntityManager;

class User2 extends ZfcUser2 implements ServiceLocatorAwareInterface
{
    protected $em;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) 
    { 
        $this->serviceLocator = $serviceLocator; 
        return $this; 
    } 

    public function getServiceLocator()
    { 
        return $this->serviceLocator; 
    } 
 
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    } 

    public function register(array $data)
    {
        $registerresult = parent::register($data);

        if($registerresult !== false) {

            $User = $this->getEntityManager()->find('SamUser\Entity\User', $registerresult->getId());
            $Role = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findOneBy(array('roleId' => 'Utilisateur'));
            $User->addRole($Role);
            $this->getEntityManager()->persist($User);
            $this->getEntityManager()->flush();

        }
        return $registerresult;
    }

}


