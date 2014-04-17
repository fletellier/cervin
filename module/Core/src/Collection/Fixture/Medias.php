<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Medias implements FixtureInterface
{
	/*
	 * Initialisation des types de bases d'artefacts
	 * et des champs qui les décrivent
	 */
	public function load(ObjectManager $manager)
	{
		
		/* ********************************* *
		 * TYPES DE MEDIAS + CHAMPS ASSOCIES *
		* ********************************* */
		
		/*
		 * Média : Image
		 */
		$type_media_image = new Collection\Entity\TypeElement('Image', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_image, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant l\'image');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_image, 'date');
		$champ_date->__set('description', 'La date de publication de l\'image');
		
		$manager->persist($type_media_image);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		
		/*
		 * Média : Video
		*/
		$type_media_video = new Collection\Entity\TypeElement('Vidéo', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_video, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant la vidéo');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_video, 'date');
		$champ_date->__set('description', 'La date de publication de la vidéo');
		
		$manager->persist($type_media_video);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		
		/*
		 * Média : Son
		*/
		$type_media_son = new Collection\Entity\TypeElement('Son', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_son, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le son');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_son, 'date');
		$champ_date->__set('description', 'La date de publication du son');
		
		$manager->persist($type_media_son);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		
		/*
		 * Média : Logiciel
		*/
		$type_media_logiciel = new Collection\Entity\TypeElement('Logiciel', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_logiciel, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le code source du logiciel');
		
		$champ_version = new Collection\Entity\Champ('Version', $type_media_logiciel, 'texte');
		$champ_version->__set('description', 'Le numéro de version du logiciel');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_logiciel, 'date');
		$champ_date->__set('description', 'La date de publication du logiciel');
		
		$manager->persist($type_media_logiciel);
		$manager->persist($champ_version);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		
		/*
		 * Média : Modèle 3D
		*/
		$type_media_modele3d = new Collection\Entity\TypeElement('Modèle 3D', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_modele3d, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le modèle 3D');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_modele3d, 'date');
		$champ_date->__set('description', 'La date de publication du modèle 3D');
		
		$manager->persist($type_media_modele3d);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		
		/*
		 * Média : Jeu de données
		*/
		$type_media_jeudonnees = new Collection\Entity\TypeElement('Jeu de données', 'media');
		
		$champ_fichier = new Collection\Entity\Champ('Fichier', $type_media_jeudonnees, 'fichier');
		$champ_fichier->__set('description', 'Le fichier contenant le jeu de données');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_media_jeudonnees, 'date');
		$champ_date->__set('description', 'La date de publication du jeu de données');
		
		$manager->persist($type_media_jeudonnees);
		$manager->persist($champ_fichier);
		$manager->persist($champ_date);
		
		$manager->flush();
		
		/*
		 * Média : Test démo
		*/
		$type_media_test = new Collection\Entity\TypeElement('Test démo', 'media');
		
		$champ_texte = new Collection\Entity\Champ('Label texte', $type_media_test, 'texte');
		$champ_texte->__set('description', 'Description du champ texte');
		
		$champ_textarea = new Collection\Entity\Champ('Label textarea', $type_media_test, 'textarea');
		$champ_textarea->__set('description', 'Description du champ textarea');
		
		$champ_nombre = new Collection\Entity\Champ('Label nombre', $type_media_test, 'nombre');
		$champ_nombre->__set('description', 'Description du champ nombre');
		
		$champ_date = new Collection\Entity\Champ('Label date', $type_media_test, 'date');
		$champ_date->__set('description', 'Description du champ date');
		
		$champ_fichier = new Collection\Entity\Champ('Label fichier', $type_media_test, 'fichier');
		$champ_fichier->__set('description', 'Description du champ fichier');
		
		$champ_url = new Collection\Entity\Champ('Label url', $type_media_test, 'url');
		$champ_url->__set('description', 'Description du champ url');
		
		$champ_geoposition = new Collection\Entity\Champ('Label géoposition', $type_media_test, 'geoposition');
		$champ_geoposition->__set('description', 'Description du champ géoposition');
		
		$manager->persist($type_media_test);
		$manager->persist($champ_texte);
		$manager->persist($champ_textarea);
		$manager->persist($champ_nombre);
		$manager->persist($champ_date);
		$manager->persist($champ_fichier);
		$manager->persist($champ_url);
		$manager->persist($champ_geoposition);
		
		$manager->flush();

		/* ***************************** *
		 * QUELQUES INSANCES DE MEDIAS   *
		* ****************************** */
		
		/*
		 * Une image
		 */
		/*$logo_cervin = new Collection\Entity\Media('Logo Cervin', $type_media_image);
		$logo_cervin->description = '<h2><u>Le logo du projet CERVIN</u></h2>';
		$logo_cervin->datas = new \Doctrine\Common\Collections\ArrayCollection();

		$champ_fichier = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fichier', 'type_element'=>$type_media_image));
		if ($champ_fichier == null) {
			throw new Exception('unexpected');
		}
		$data_fichier = new Collection\Entity\Data($logo_cervin, $champ_fichier);
		$data_fichier->fichier = 'inconnu.jpg';
		$logo_cervin->datas->add($data_fichier);
		
		$champ_date = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date', 'type_element'=>$type_media_image));
		if ($champ_date == null) {
			throw new Exception('unexpected');
		}
		$data_date = new Collection\Entity\Data($logo_cervin, $champ_date);
		$data_date->date = new DateTime('1999-10-09');
		$logo_cervin->datas->add($data_date);
		
		$manager->persist($logo_cervin);
		$manager->flush();*/

		/*
		 * Un logiciel
		 */
		/*$logiciel = new Collection\Entity\Media('Logiciel sans nom', $type_media_logiciel);
		$logiciel->description = '<ul><li>Exemple de logiciel de la collection...</li><li>Ceci est un exemple</li></ul>';
		$logiciel->datas = new \Doctrine\Common\Collections\ArrayCollection();

		$champ_fichier = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fichier', 'type_element'=>$type_media_logiciel));
		if ($champ_fichier == null) {
			throw new Exception('unexpected');
		}
		$data_fichier = new Collection\Entity\Data($logiciel, $champ_fichier);
		$data_fichier->fichier = 'inconnu.exe';
		$logiciel->datas->add($data_fichier);

		$champ_version = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Version', 'type_element'=>$type_media_logiciel));
		if ($champ_version == null) {
			throw new Exception('unexpected');
		}
		$data_version = new Collection\Entity\Data($logiciel, $champ_version);
		$data_version->texte = '2.0';
		$logiciel->datas->add($data_version);
		
		$champ_date = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date', 'type_element'=>$type_media_logiciel));
		if ($champ_date == null) {
			throw new Exception('unexpected');
		}
		$data_date = new Collection\Entity\Data($logiciel, $champ_date);
		$data_date->date = new DateTime('1999-10-09');
		$logiciel->datas->add($data_date);
		
		$manager->persist($logiciel);
		$manager->flush();*/

		/*
		 * Un son
		 */
		/*$son_sample = new Collection\Entity\Media('Teaser audio', $type_media_son);
		$son_sample->description = '<b>Un fichier audio pour annoncer la parution prochaine du <h3>back-office de <u>CERVIN</u></h3></b>';
		$son_sample->datas = new \Doctrine\Common\Collections\ArrayCollection();

		$champ_fichier = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Fichier', 'type_element'=>$type_media_son));
		if ($champ_fichier == null) {
			throw new Exception('unexpected');
		}
		$data_fichier = new Collection\Entity\Data($son_sample, $champ_fichier);
		$data_fichier->fichier = 'inconnu.mp3';
		$son_sample->datas->add($data_fichier);
		
		$champ_date = $manager->getRepository('Collection\Entity\Champ')->findOneBy(array('label'=>'Date', 'type_element'=>$type_media_son));
		if ($champ_date == null) {
			throw new Exception('unexpected');
		}
		$data_date = new Collection\Entity\Data($son_sample, $champ_date);
		$data_date->date = new DateTime('1999-10-09');
		$son_sample->datas->add($data_date);
		
		$manager->persist($son_sample);
		$manager->flush();*/
		
	}
}
