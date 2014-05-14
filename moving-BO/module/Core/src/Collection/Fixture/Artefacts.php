<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Artefacts implements FixtureInterface
{
	
	public function load(ObjectManager $manager)
	{


		/* ************************************ *
		 * Ajout d'un Select Liste des pays     *
		 * ************************************ */

		$liste_des_pays = array("Afghanistan","Afrique du Sud","Albanie","Algérie","Allemagne","Andorre","Angola","Anguilla","Antarctique","Antigua-et-Barbuda","Antilles néerlandaises","Arabie saoudite","Argentine","Arménie","Aruba","Australie","Autriche","Azerbaïdjan","Bénin","Bahamas","Bahreïn","Bangladesh","Barbade","Belau","Belgique","Belize","Bermudes","Bhoutan","Biélorussie","Birmanie","Bolivie","Bosnie-Herzégovine","Botswana","Brésil","Brunei","Bulgarie","Burkina Faso","Burundi","Côte d'Ivoire","Cambodge","Cameroun","Canada","Cap-Vert","Chili","Chine","Chypre","Colombie","Comores","Congo","Corée du Nord","Corée du Sud","Costa Rica","Croatie","Cuba","Danemark","Djibouti","Dominique","Égypte","Émirats arabes unis","Équateur","Érythrée","Espagne","Estonie","États-Unis","Éthiopie","Finlande","France","Géorgie","Gabon","Gambie","Ghana","Gibraltar","Grèce","Grenade","Groenland","Guadeloupe","Guam","Guatemala","Guinée","Guinée équatoriale","Guinée-Bissao","Guyana","Guyane française","Haïti","Honduras","Hong Kong","Hongrie","Ile Bouvet","Ile Christmas","Ile Norfolk","Iles Cayman","Iles Cook","Iles Féroé","Iles Falkland","Iles Fidji","Iles Géorgie du Sud et Sandwich du Sud","Iles Heard et McDonald","Iles Marshall","Iles Pitcairn","Iles Salomon","Iles Svalbard et Jan Mayen","Iles Turks-et-Caicos","Iles Vierges américaines","Iles Vierges britanniques","Iles des Cocos (Keeling)","Iles mineures éloignées des États-Unis","Inde","Indonésie","Iran","Iraq","Irlande","Islande","Israël","Italie","Jamaïque","Japon","Jordanie","Kazakhstan","Kenya","Kirghizistan","Kiribati","Koweït","Laos","Lesotho","Lettonie","Liban","Liberia","Libye","Liechtenstein","Lituanie","Luxembourg","Macao","Madagascar","Malaisie","Malawi","Maldives","Mali","Malte","Mariannes du Nord","Maroc","Martinique","Maurice","Mauritanie","Mayotte","Mexique","Micronésie","Moldavie","Monaco","Mongolie","Montserrat","Mozambique","Népal","Namibie","Nauru","Nicaragua","Niger","Nigeria","Nioué","Norvège","Nouvelle-Calédonie","Nouvelle-Zélande","Oman","Ouganda","Ouzbékistan","Pérou","Pakistan","Panama","Papouasie-Nouvelle-Guinée","Paraguay","Pays-Bas","Philippines","Pologne","Polynésie française","Porto Rico","Portugal","Qatar","République centrafricaine","République démocratique du Congo","République dominicaine","République tchèque","Réunion","Roumanie","Royaume-Uni","Russie","Rwanda","Sénégal","Sahara occidental","Saint-Christophe-et-Niévès","Saint-Marin","Saint-Pierre-et-Miquelon","Saint-Siège","Saint-Vincent-et-les-Grenadines","Sainte-Hélène","Sainte-Lucie","Salvador","Samoa","Samoa américaines","Sao Tomé-et-Principe","Seychelles","Sierra Leone","Singapour","Slovénie","Slovaquie","Somalie","Soudan","Sri Lanka","Suède","Suisse","Suriname","Swaziland","Syrie","Taïwan","Tadjikistan","Tanzanie","Tchad","Terres australes françaises","Territoire britannique de l'Océan Indien","Thaïlande","Timor Oriental","Togo","Tokélaou","Tonga","Trinité-et-Tobago","Tunisie","Turkménistan","Turquie","Tuvalu","Ukraine","Uruguay","Vanuatu","Venezuela","Viêt Nam","Wallis-et-Futuna","Yémen","Yougoslavie","Zambie","Zimbabwe");

		$selectPays = new Collection\Entity\Select();
		$selectPays->__set('description', 'Liste des pays du monde');
		$selectPays->__set('label', 'Pays');

		foreach ($liste_des_pays as $key => $pays) {
			$select_option =  new Collection\Entity\SelectOption($selectPays);
			$select_option->__set('text',$pays);
			$manager->persist($select_option);

		}
		

		$manager->persist($selectPays);


		$liste_des_departements_fr = array(
"Ain","Aisne","Allier","Alpes-de-Haute-Provence","Hautes-Alpes","Alpes-Maritimes","Ardèche","Ardennes","Ariège","Aube","Aude","Aveyron","Bouches-du-Rhône","Calvados","Cantal","Charente","Charente-Maritime","Cher","Corrèze","Corse-du-Sud","Haute-Corse","Côte-d'Or","Côtes-d'Armor","Creuse","Dordogne","Doubs","Drôme","Eure","Eure-et-Loir","Finistère","Gard","Haute-Garonne","Gers","Gironde","Hérault","Ille-et-Vilaine","Indre","Indre-et-Loire","Isère","Jura","Landes","Loir-et-Cher","Loire","Haute-Loire","Loire-Atlantique","Loiret","Lot","Lot-et-Garonne","Lozère","Maine-et-Loire","Manche","Marne","Haute-Marne","Mayenne","Meurthe-et-Moselle","Meuse","Morbihan","Moselle","Nièvre","Nord","Oise","Orne","Pas-de-Calais","Puy-de-Dôme","Pyrénées-Atlantiques","Hautes-Pyrénées","Pyrénées-Orientales","Bas-Rhin","Haut-Rhin","Rhône","Haute-Saône","Saône-et-Loire","Sarthe","Savoie","Haute-Savoie","Paris","Seine-Maritime","Seine-et-Marne","Yvelines","Deux-Sèvres","Somme","Tarn","Tarn-et-Garonne","Var","Vaucluse","Vendée","Vienne","Haute-Vienne","Vosges","Yonne","Territoire de Belfort","Essonne","Hauts-de-Seine","Seine-Saint-Denis","Val-de-Marne","Val-d'Oise","Guadeloupe","Martinique","Guyane","La Réunion",			);

		$select_departements_fr = new Collection\Entity\Select();
		$select_departements_fr->__set('description', 'Liste des départements français');
		$select_departements_fr->__set('label', 'Départements');

		foreach ($liste_des_departements_fr as $key => $dp) {
			$select_option =  new Collection\Entity\SelectOption($select_departements_fr);
			$select_option->__set('text',$dp);
			$manager->persist($select_option);

		}
		
		$manager->persist($select_departements_fr);


$liste_states = array(
		"Aquitaine","Auvergne","Bourgogne","Bretagne","Centre","Champagne Ardenne","Corse","DOM/TOM","Franche Comté","Ile de France","Languedoc Roussillon","Limousin","Lorraine","Midi Pyrénées","Nord Pas de Calais","Haute Normandie","Pays de la Loire","Picardie","Poitou Charentes","Provence Alpes Côte d'azur","Rhône Alpes","Alsace","Basse-Normandie");

		$states = new Collection\Entity\Select();
		$states->__set('description', 'Liste des régions français');
		$states->__set('label', 'Régions');

		foreach ($liste_states as $key => $dp) {
			$select_option =  new Collection\Entity\SelectOption($states);
			$select_option->__set('text',$dp);
			$manager->persist($select_option);

		}
		
		$manager->persist($states);




		/* *********************************** *
		 * TYPES D'ARTEFACTS + CHAMPS ASSOCIES *
		 * *********************************** */
		
		/*
		 * Artefact : Matériel
		 */
		$type_artefact_materiel = new Collection\Entity\TypeElement('Matériel', 'artefact');
		
		$champ_fabriquant = new Collection\Entity\Champ('Fabriquant', $type_artefact_materiel, 'texte');
		$champ_fabriquant->__set('description', 'La société qui fabrique ce matériel');
		
		$champ_debut = new Collection\Entity\Champ('Début de période', $type_artefact_materiel, 'date');
		$champ_debut->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		
		$champ_fin = new Collection\Entity\Champ('Fin de période', $type_artefact_materiel, 'date');
		$champ_fin->__set('description', 'Date du début de la période standard d\'utilisation du matériel');
		
		$manager->persist($type_artefact_materiel);
		$manager->persist($champ_fabriquant);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		
		/*
		 * Artefact : Logiciel
		 */
		$type_artefact_logiciel = new Collection\Entity\TypeElement('Logiciel', 'artefact');
		
		$champ_editeur = new Collection\Entity\Champ('Editeur', $type_artefact_logiciel, 'texte');
		$champ_editeur->__set('description', 'L\'éditeur du logiciel');

		$champ_auteur = new Collection\Entity\Champ('Auteur(s)', $type_artefact_logiciel, 'texte');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du logiciel, personne(s) ou société(s)');
		
		$champ_langage = new Collection\Entity\Champ('Langages', $type_artefact_logiciel, 'texte');
		$champ_langage->__set('description', 'Les principaux languages de programmation utilisés dans le code du logiciel');
		
		$champ_debut = new Collection\Entity\Champ('Début de période', $type_artefact_logiciel, 'date');
		$champ_debut->__set('description', 'Date du début de la période standard d\'utilisation du logiciel');
		
		$champ_fin = new Collection\Entity\Champ('Fin de période', $type_artefact_logiciel, 'date');
		$champ_fin->__set('description', 'Date du début de la période standard d\'utilisation du logiciel');
		
		$manager->persist($type_artefact_logiciel);
		$manager->persist($champ_editeur);
		$manager->persist($champ_auteur);
		$manager->persist($champ_langage);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		
		/*
		 * Artefact : Document
		 */
		$type_artefact_document = new Collection\Entity\TypeElement('Document', 'artefact');
		
		$champ_editeur = new Collection\Entity\Champ('Editeur', $type_artefact_document, 'texte');
		$champ_editeur->__set('description', 'L\'éditeur du document');
		
		$champ_auteur = new Collection\Entity\Champ('Auteur(s)', $type_artefact_document, 'texte');
		$champ_auteur->__set('description', 'Le (les) auteur(s) du document, personne(s) ou société(s)');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_artefact_document, 'date');
		$champ_date->__set('description', 'Date de parution du document');
		
		$manager->persist($type_artefact_document);
		$manager->persist($champ_editeur);
		$manager->persist($champ_auteur);
		$manager->persist($champ_date);
		
		/*
		 * Artefact : Institution
		 */
		$type_artefact_institution = new Collection\Entity\TypeElement('Institution', 'artefact');
		
		$champ_debut = new Collection\Entity\Champ('Création', $type_artefact_institution, 'date');
		$champ_debut->__set('description', 'Date du création de l\'institution');
		
		$champ_fin = new Collection\Entity\Champ('Fin', $type_artefact_institution, 'date');
		$champ_fin->__set('description', 'Date de disparition de l\'institution');
		
		$champ_adresse = new Collection\Entity\Champ('Adresse(s)', $type_artefact_institution, 'texte');
		$champ_adresse->__set('description', 'La (les) adresse(s) des implantations de l\'institution');
		
		$manager->persist($type_artefact_institution);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		$manager->persist($champ_adresse);
		
		/*
		 * Artefact : Lieu
		 */
		$type_artefact_lieu = new Collection\Entity\TypeElement('Lieu', 'artefact');
		
		$champ_adresse = new Collection\Entity\Champ('Adresse', $type_artefact_lieu, 'texte');
		$champ_adresse->__set('description', 'L\'adresse du lieu');
		
		$manager->persist($type_artefact_lieu);
		$manager->persist($champ_adresse);
		
		/*
		 * Artefact : Personne
		 */
		$type_artefact_personne = new Collection\Entity\TypeElement('Personne', 'artefact');
		
		$champ_nationnalite = new Collection\Entity\ChampSelect('Nationnalité', $type_artefact_personne, 'select');
		$champ_nationnalite->__set('select', $selectPays);
		
		$champ_naissance = new Collection\Entity\Champ('Date de naissance', $type_artefact_personne, 'date');
		$champ_naissance->__set('description', 'La date de naissance de la personne');
		
		$champ_deces = new Collection\Entity\Champ('Date de décès', $type_artefact_personne, 'date');
		$champ_deces->__set('description', 'La date de décès de la personne');

		$champ_geo = new Collection\Entity\Champ('Lieux de résidence', $type_artefact_personne, 'geoposition');
		$champ_geo->__set('description', 'Lieux de résidence de la personne');
		
		$manager->persist($type_artefact_personne);
		$manager->persist($champ_nationnalite);
		$manager->persist($champ_naissance);
		$manager->persist($champ_deces);
		$manager->persist($champ_geo);
		
		/*
		 * Artefact : Projet
		 */
		$type_artefact_projet = new Collection\Entity\TypeElement('Projet','artefact');
		
		$champ_acteurs = new Collection\Entity\Champ('Acteurs', $type_artefact_projet, 'texte');
		$champ_acteurs->__set('description', 'Les acteurs du projet, personnes ou entités');
		
		$champ_debut = new Collection\Entity\Champ('Début', $type_artefact_projet, 'date');
		$champ_debut->__set('description', 'La date de début du projet');
		
		$champ_fin = new Collection\Entity\Champ('Fin', $type_artefact_projet,  'date');
		$champ_fin->__set('description', 'La date de fin du projet');
		
		$manager->persist($type_artefact_projet);
		$manager->persist($champ_acteurs);
		$manager->persist($champ_debut);
		$manager->persist($champ_fin);
		
		/*
		 * Artefact : Evenement
		*/
		$type_artefact_evenement = new Collection\Entity\TypeElement('Evènement', 'artefact');
		
		$champ_date = new Collection\Entity\Champ('Date', $type_artefact_evenement, 'date');
		$champ_date->__set('description', 'La date de l\'évènement');
		
		$champ_adresse = new Collection\Entity\Champ('Adresse', $type_artefact_evenement, 'texte');
		$champ_adresse->__set('description', 'L\'adresse de l\'évènement');
		
		$champ_organisateurs = new Collection\Entity\Champ('Organisateurs', $type_artefact_evenement, 'texte');
		$champ_organisateurs->__set('description', 'Les organisateurs de l\'évènement, personnes ou entités');
		
		$champ_participants = new Collection\Entity\Champ('Participants', $type_artefact_evenement, 'texte');
		$champ_participants->__set('description', 'Les personnes ou entités ayant participé à l\'évènement');
	
		$manager->persist($type_artefact_evenement);
		$manager->persist($champ_date);
		$manager->persist($champ_adresse);
		$manager->persist($champ_organisateurs);
		$manager->persist($champ_participants);
		
		/*
		 * Artefact : Site Web
		*/
		$type_artefact_site = new Collection\Entity\TypeElement('Site Web', 'artefact');
		
		$champ_url = new Collection\Entity\Champ('Date', $type_artefact_site, 'date');
		$champ_url->__set('description', 'L\'adresse url du site web');
		
		$manager->persist($type_artefact_site);
		$manager->persist($champ_url);
		
		/*
		 * Artefact : Test démo
		*/
		$type_artefact_test = new Collection\Entity\TypeElement('Test démo', 'artefact');
		
		$champ_texte = new Collection\Entity\Champ('Label texte', $type_artefact_test, 'texte');
		$champ_texte->__set('description', 'Description du champ texte');
		
		$champ_textarea = new Collection\Entity\Champ('Label textarea', $type_artefact_test, 'textarea');
		$champ_textarea->__set('description', 'Description du champ textarea');
		
		$champ_nombre = new Collection\Entity\Champ('Label nombre', $type_artefact_test, 'nombre');
		$champ_nombre->__set('description', 'Description du champ nombre');
		
		$champ_date = new Collection\Entity\Champ('Label date', $type_artefact_test, 'date');
		$champ_date->__set('description', 'Description du champ date');
		
		$champ_fichier = new Collection\Entity\Champ('Label fichier', $type_artefact_test, 'fichier');
		$champ_fichier->__set('description', 'Description du champ fichier');
		
		$champ_url = new Collection\Entity\Champ('Label url', $type_artefact_test, 'url');
		$champ_url->__set('description', 'Description du champ url');

		$champ_geoposition = new Collection\Entity\Champ('Label géoposition', $type_artefact_test, 'geoposition');
		$champ_geoposition->__set('description', 'Description du champ géoposition');
		
		$manager->persist($type_artefact_test);
		$manager->persist($champ_texte);
		$manager->persist($champ_textarea);
		$manager->persist($champ_nombre);
		$manager->persist($champ_date);
		$manager->persist($champ_fichier);
		$manager->persist($champ_url);
		$manager->persist($champ_geoposition);
		
		$manager->flush();
		
		/*
		 * Quelques sémantiques de relations
		 */
		
		$types = $manager->getRepository("Collection\Entity\TypeElement")->findBy(array("type"=>"artefact"));
		
		/*foreach ($types as $type) {
			$types_destination = $manager->getRepository("Collection\Entity\TypeElement")->findBy(array("type"=>"artefact"));
			foreach ($types_destination as $type_destination) {
				$semantique = new Collection\Entity\SemantiqueArtefact();
				$semantique->__set('type_origine', $type);
				$semantique->__set('type_destination', $type_destination);
				$semantique->__set('semantique', 'Autre');
				$manager->persist($semantique);
			}
			$semantique = new Collection\Entity\SemantiqueArtefact();
			$semantique->__set('type_origine', $type_artefact_document);
			$semantique->__set('type_destination', $type);
			$semantique->__set('semantique', 'Décrit');
			$manager->persist($semantique);
			
			$semantique = new Collection\Entity\SemantiqueArtefact();
			$semantique->__set('type_origine', $type);
			$semantique->__set('type_destination', $type_artefact_document);
			$semantique->__set('semantique', 'Est décrit dans');
			$manager->persist($semantique);
			
			$semantique = new Collection\Entity\SemantiqueArtefact();
			$semantique->__set('type_origine', $type_artefact_site);
			$semantique->__set('type_destination', $type);
			$semantique->__set('semantique', 'Décrit');
			$manager->persist($semantique);
			
			$semantique = new Collection\Entity\SemantiqueArtefact();
			$semantique->__set('type_origine', $type);
			$semantique->__set('type_destination', $type_artefact_site);
			$semantique->__set('semantique', 'Est décrit dans');
			$manager->persist($semantique);
		}*/
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'Est composé de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'Est une partie de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_logiciel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'Est utilisée par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'Est fabriquée par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'A été inventée par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_lieu);
		$semantique->__set('semantique', 'A été inventée à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_lieu);
		$semantique->__set('semantique', 'Est stocké à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_personne);
		$semantique->__set('semantique', 'A été inventée par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_materiel);
		$semantique->__set('type_destination', $type_artefact_projet);
		$semantique->__set('semantique', 'Est utilisée dans');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'Est utilisé par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_logiciel);
		$semantique->__set('semantique', 'Est une partie de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_logiciel);
		$semantique->__set('semantique', 'Est composé de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_logiciel);
		$semantique->__set('semantique', 'utilise');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'Est utilisé par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'A été publié par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_personne);
		$semantique->__set('semantique', 'A été écrit par');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_logiciel);
		$semantique->__set('type_destination', $type_artefact_projet);
		$semantique->__set('semantique', 'Est utilisé dans');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'Est le fabriquant de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_logiciel);
		$semantique->__set('semantique', 'Utilise');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_logiciel);
		$semantique->__set('semantique', 'A publié');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_document);
		$semantique->__set('semantique', 'A publié');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_lieu);
		$semantique->__set('semantique', 'Est basée à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_personne);
		$semantique->__set('semantique', 'A pour membre');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_personne);
		$semantique->__set('semantique', 'A pour chef');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_projet);
		$semantique->__set('semantique', 'A mené');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_projet);
		$semantique->__set('semantique', 'A financé');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_projet);
		$semantique->__set('semantique', 'A participé à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_evenement);
		$semantique->__set('semantique', 'A participé à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_institution);
		$semantique->__set('type_destination', $type_artefact_evenement);
		$semantique->__set('semantique', 'A organisé');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_lieu);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'Est l\'endroit où a été inventée');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_lieu);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'Est l\'endroit où est stoké');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_lieu);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'Est l\'endroit où est basée');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_lieu);
		$semantique->__set('type_destination', $type_artefact_personne);
		$semantique->__set('semantique', 'Est l\'endroit où est né(e)');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_lieu);
		$semantique->__set('type_destination', $type_artefact_personne);
		$semantique->__set('semantique', 'Est l\'endroit où est décédé(e)');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_lieu);
		$semantique->__set('type_destination', $type_artefact_evenement);
		$semantique->__set('semantique', 'Est l\'endroit où a eu lieu');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_materiel);
		$semantique->__set('semantique', 'A inventé');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_logiciel);
		$semantique->__set('semantique', 'A écrit');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'Est membre de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_institution);
		$semantique->__set('semantique', 'Est chef de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_lieu);
		$semantique->__set('semantique', 'Est né(e) à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_lieu);
		$semantique->__set('semantique', 'Est décédé(e) à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_projet);
		$semantique->__set('semantique', 'Est membre de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_projet);
		$semantique->__set('semantique', 'Est chef de');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_evenement);
		$semantique->__set('semantique', 'A participé à');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_personne);
		$semantique->__set('type_destination', $type_artefact_evenement);
		$semantique->__set('semantique', 'A organisé');
		$manager->persist($semantique);
		/*
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_projet);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);
		
		$semantique = new Collection\Entity\SemantiqueArtefact();
		$semantique->__set('type_origine', $type_artefact_);
		$semantique->__set('type_destination', $type_artefact_);
		$semantique->__set('semantique', '');
		$manager->persist($semantique);*/
		
		
		$manager->flush();
	}
}
