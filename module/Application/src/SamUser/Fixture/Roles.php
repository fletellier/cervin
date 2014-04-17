<?php


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Zend\Crypt\Password\Bcrypt;
class Roles implements FixtureInterface
{
	/*
	 * Initialisation des types de bases d'artefacts
	 * et des champs qui les décrivent
	 */
	public function load(ObjectManager $manager)
	{
		
		/* *************************************** *
		 * Création des Roles et de 5 utilisateurs *
		 * *************************************** */
		
		/*
		 * Roles
		 */
		$role_Visiteur = new SamUser\Entity\Role();
		$role_Visiteur->setRoleId('Visiteur');

		$role_Utilisateur = new SamUser\Entity\Role();
		$role_Utilisateur->setRoleId('Utilisateur');
		$role_Utilisateur->setParent($role_Visiteur);

		$role_Collection = new SamUser\Entity\Role();
		$role_Collection->setRoleId('Collection');
		$role_Collection->setParent($role_Utilisateur);

		$role_Parcours = new SamUser\Entity\Role();
		$role_Parcours->setRoleId('Parcours');
		$role_Parcours->setParent($role_Collection);
		
		$role_Modeleur = new SamUser\Entity\Role();
		$role_Modeleur->setRoleId('Modeleur');
		$role_Modeleur->setParent($role_Parcours);
		
		$role_Admin = new SamUser\Entity\Role();
		$role_Admin->setRoleId('Admin');
		$role_Admin->setParent($role_Modeleur);

		$manager->persist($role_Visiteur);
		$manager->persist($role_Utilisateur);
		$manager->persist($role_Collection);
		$manager->persist($role_Parcours);
		$manager->persist($role_Modeleur);
		$manager->persist($role_Admin);

		/*
		 * Utilisateurs
		 */

		$adresse     = '12 rue Joseph REY';
		$code_postal  = '38000';
		$ville        = 'Grenoble';
		$pays         = 'France';
		
		$admin = new SamUser\Entity\User();
		$admin->setUsername('adminlogin');
		$admin->setEmail('admin@mail.fr');
		$admin->setTelephone('0600000000');
		$admin->setAdresse($adresse);
		$admin->setCodePostal($code_postal);
		$admin->setVille($ville);
		$admin->setPays($pays);
		$admin->setDisplayName('Administrateur Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$admin->setPassword($bcrypt->create('toto123'));
		$admin->addRole($role_Admin);
		$admin->setState(1);

		$utilisateur = new SamUser\Entity\User();
		$utilisateur->setUsername('utilisateurlogin');
		$utilisateur->setEmail('utilisateur@mail.fr');
		$utilisateur->setTelephone('0600000001');
		$utilisateur->setAdresse($adresse);
		$utilisateur->setCodePostal($code_postal);
		$utilisateur->setVille($ville);
		$utilisateur->setPays($pays);
		$utilisateur->setDisplayName('Utilisateur Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$utilisateur->setPassword($bcrypt->create('toto123'));
		$utilisateur->addRole($role_Utilisateur);
		$utilisateur->setState(1);

		$collection = new SamUser\Entity\User();
		$collection->setUsername('collectionlogin');
		$collection->setEmail('collection@mail.fr');
		$collection->setTelephone('0600000002');
		$collection->setAdresse($adresse);
		$collection->setCodePostal($code_postal);
		$collection->setVille($ville);
		$collection->setPays($pays);
		$collection->setDisplayName('Collection Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$collection->setPassword($bcrypt->create('toto123'));
		$collection->addRole($role_Collection);
		$collection->setState(1);

		$parcours = new SamUser\Entity\User();
		$parcours->setUsername('parcourslogin');
		$parcours->setEmail('parcours@mail.fr');
		$parcours->setTelephone('0600000003');
		$parcours->setAdresse($adresse);
		$parcours->setCodePostal($code_postal);
		$parcours->setVille($ville);
		$parcours->setPays($pays);
		$parcours->setDisplayName('Parcours Test');
		$bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
		$parcours->setPassword($bcrypt->create('toto123'));
		$parcours->addRole($role_Parcours);
		$parcours->setState(1);

		$modeleur = new SamUser\Entity\User();
		$modeleur->setUsername('modeleurlogin');
		$modeleur->setEmail('modeleur@mail.fr');
		$modeleur->setTelephone('0600000004');
		$modeleur->setAdresse($adresse);
		$modeleur->setCodePostal($code_postal);
		$modeleur->setVille($ville);
		$modeleur->setPays($pays);
		$modeleur->setDisplayName('Modeleur Test');
		$bcrypt = new Bcrypt;
		$bcrypt->setCost(14);
		$modeleur->setPassword($bcrypt->create('toto123'));
		$modeleur->addRole($role_Modeleur);
		$modeleur->setState(1);

		$manager->persist($admin);
		$manager->persist($utilisateur);
		$manager->persist($collection);
		$manager->persist($parcours);
		$manager->persist($modeleur);
		$manager->flush();
		
	}
	
}
