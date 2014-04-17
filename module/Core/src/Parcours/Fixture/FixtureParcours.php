<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class FixtureParcours implements FixtureInterface
{
	
	public function load(ObjectManager $manager)
	{

		/********************************
		 *	Parcour n°1
		 ********************************/
		
		/*
		 * Quelques artefacts et sémantiques pour remplir les scènes
		 */
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Personne'));
		$jean_kuntzmann = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$jean_kuntzmann->populate($manager, null);
		$jean_kuntzmann->titre = 'Jean Kutzmann';
		$jean_kuntzmann->description = "Jean Kuntzmann (1912-1992) fut un mathématicien français qui joua un rôle décisif dans le développement de l'informatique et des mathématiques appliquées dans la recherche et l'enseignement supérieur en France.
				<br>
				<br>
				Après des études de mathématiques à l'École Normale Supérieure, Kuntzmann soutient en 1940 une thèse de doctorat en algèbre. Prisonnier de guerre, il est en captivité jusqu'en 1945, date à laquelle il rejoint Grenoble où il avait été nommé professeur en 1942. Dès son arrivée, il crée un enseignement de mathématiques pour l'ingénieur, initiative novatrice pour l'époque. Il établit une collaboration avec des entreprises industrielles de la région (Neyrpic, Merlin Gerin), qui ont de gros besoins de calcul numérique. Il perçoit très vite le potentiel du calcul automatique et créée en 1951 un Laboratoire de Calcul, auquel les contrats industriels apporteront des ressources substantielles.
				<br>
				<br>
				Initialement équipé de machines mécaniques, ce laboratoire acquiert en 1952 un calculateur analogique OME 12 de la SEA et développe ses collaborations (ministère de l'Air, EDF, CNET). Ne possédant pas d'ordinateur, le Laboratoire utilise en 1955-56 des machines extérieures : le Gamma 3 de la société Normacem à Lyon, puis l'IBM 650 de Neyrpic-Sogreah à Grenoble.
				<br>
				<br>
				Les premiers enseignements de programmation sont mis en place à cette occasion en 1956, d'abord de manière informelle, puis avec la création d'une section \"mathématiques appliquées\" à l'Institut Polytechnique de Grenoble (IPG). Cette initiative préfigure la création en 1960, au sein de l'IPG, d'une École d'ingénieurs en informatique et mathématiques appliquées, qui deviendra l'ENSIMAG, et dont Kuntzmann sera le premier directeur.
				<br>
				<br>
				En 1957, Kuntzmann créée l'AFCAL, Association Française de Calcul (qui deviendra plus tard l'AFCALTI, puis l'AFCET) et, en 1958, la revue \"<i>Chiffres</i>\". En 1957 également, le Laboratoire de Calcul obtient une dotation pour l'achat d'un ordinateur. Sera choisi le Bull Gamma ET, inauguré en janvier 1958. L'arrivée de cet ordinateur marque le début d'une activité de recherche en informatique, qui se concrétisera au début des années 1960 par la soutenance de nombreuses thèses dans ce domaine. Les thèmes de recherche initiaux sont les langages de programmation et la compilation, ainsi que l'architecture des ordinateurs. Le Laboratoire de calcul, devenu Institut de Mathématiques Appliquées de Grenoble (IMAG), élargira plus tard le spectre de ses activités et deviendra en 1966 l'un des premiers laboratoires associés au CNRS (LA n° 7).
				<br>
				<br>
				Kuntzmann gardera la direction de l'IMAG, devenu l'un des tout premiers centres de recherche en informatique en France,  jusqu'à sa retraite en 1977. Dans les années 1970, il avait créé une équipe de recherche sur la didactique des mathématiques, sujet sur lequel il continuera à travailler, publiant plusieurs ouvrages.
				<br>
				<br>
				En 2007, le nom de Jean Kuntzmann est donné à l'un des laboratoires créés à la suite de la dissolution de la fédération IMAG. Le 14 décembre 2012, une journée de commémoration a été organisée à Grenoble pour le centenaire de sa naissance.
				<br>
		";
		$manager->persist($jean_kuntzmann);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$gamma_3 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$gamma_3->populate($manager, null);
		$gamma_3->titre = 'Gamma 3';
		$gamma_3->description = "Le calculateur Bull Gamma 3A symbolise la transition entre mécanographie et informatique. Cette machine est composée d’une tabulatrice dont l’organe de calcul est un calculateur électronique, qui est donc “esclave” de la tabulatrice. Ce calculateur est programmable au moyen d’un tableau de connexion, ce qui lui permet d’enchaîner plusieurs opérations en vue de calculs complexes.
				<br>
				<br>
				Cette machine, produite en 1 200 exemplaires à partir de 1952-53, connut un grand succès pour les applications de gestion dans l’industrie, les banques et les assurances, car elle permettait de réutiliser le matériel mécanographique existant. Une version Gamma 3M, munie d’un opérateur en virgule flottante, fut introduite pour le calcul scientifique. Le successeur du Gamma 3, le Bull Gamma ET (“Extension Tambour”), livré à partir de 1957, était muni d’une mémoire à tambour magnétique contenant le programme et les données. Dans le Gamma ET, les rôles de la tabulatrice et du calculateur étaient inversés : l’organe maître était le calculateur, la tabulatrice servant de périphérique d’entrée-sortie. La transition entre mécanographie et informatique était accomplie.
				<br>
		";
		$manager->persist($gamma_3);
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Personne'));
		$rene_perret = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$rene_perret->populate($manager, null);
		$rene_perret->titre = 'René Perret';
		$rene_perret->description = "René Perret (1924-2003) a été l’un des pionniers de l'enseignement et de la recherche universitaire en automatique en France. En 1957, il a fondé le Laboratoire de Servomécanismes qui deviendra le Laboratoire d'Automatique de Grenoble (LAG), puis le Gipsa-Lab. Il a été le directeur de ce laboratoire de 1957 à 1982, puis directeur honoraire de 1983 à 1994. Il a été à l'origine du premier calculateur industriel issu d'une université française (MAT 01) ; un des premiers calculateurs au monde utilisant la technologie des circuits intégrés. Ce calculateur, construit par la société Mors, était la version industrielle d'un calculateur conçu par deux thésards du LAG dirigés par R. Perret. Ce calculateur a permis au LAG d'entreprendre des recherches sur les méthodes de contrôle/commande de procédés par calculateur et à la société Mors de réaliser les premières installations industrielles de contrôle/commande.
				<br>
		";
		$manager->persist($rene_perret);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$MAT_01 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$MAT_01->populate($manager, null);
		$MAT_01->titre = 'Calculateur MAT 01';
		$manager->persist($MAT_01);
		
		$type_artefact_document = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Document'));
		$cours = new Collection\Entity\Artefact(null, $type_artefact_document);
		$cours->populate($manager, null);
		$cours->titre = 'Cours "Calculateurs Electroniques" de René Perret';
		$cours->description = "En 1961-62, René Perret inaugure un cours sur les calculateurs électroniques, en 3-ème année de l'EIEG (École d'Ingénieurs Électroniciens de Grenoble). C'est l'un des tout premiers enseignements délivrés en France sur ce sujet. Il est notamment alimenté par les recherches menées au LAG (Laboratoire d'Automatique de Grenoble).
				<br>
				<br>
				L'EIEG, créée par Jean Benoît, devait devenir l'ENSERG (École Nationale Supérieure d'Électronique et de Radioélectricité de Grenoble, appartenant à l'Institut National Polytechnique de Grenoble).
				<br>
		";
		$manager->persist($cours);
		
		$semantique_chronologie = new Parcours\Entity\SemantiqueTransition();
		$semantique_chronologie->semantique = "Chronologique";
		$semantique_chronologie->description = "La scène destination suit chronologiquement la scène origine.";
		$manager->persist($semantique_chronologie);

		$semantique_logique = new Parcours\Entity\SemantiqueTransition();
		$semantique_logique->semantique = "Logique";
		$semantique_logique->description = "La scène destination suit la scène origine dans un raisonnement, une explication, une démonstration.";
		$manager->persist($semantique_logique);
		
		$semantique_analogie = new Parcours\Entity\SemantiqueTransition();
		$semantique_analogie->semantique = "Analogie";
		$semantique_analogie->description = "La scène destination est une transposition de la scène origine à un autre domaine";
		$manager->persist($semantique_analogie);
		
		$semantique_illustration = new Parcours\Entity\SemantiqueTransition();
		$semantique_illustration->semantique = "Illustration";
		$semantique_illustration->description = "Le scène destination illustre plus concrètement la scène origine, plus abstraite.";
		$manager->persist($semantique_illustration);
		
		$semantique_digression = new Parcours\Entity\SemantiqueTransition();
		$semantique_digression->semantique = "Digression";
		$semantique_digression->description = "La scène destination élargit le discours autour de la scène origine, sans y être indispensable.";
		$manager->persist($semantique_digression);
		
		$semantique_precision = new Parcours\Entity\SemantiqueTransition();
		$semantique_precision->semantique = "Précision";
		$semantique_precision->description = "La scène destination apporte une information complémentaire précise sur une partie de la scène origine, sans être indispensable à la compréhension de celle-ci.";
		$manager->persist($semantique_precision);
		
		$semantique_experience = new Parcours\Entity\SemantiqueTransition();
		$semantique_experience->semantique = "Expérience";
		$semantique_experience->description = "La scène destination propose au visiteur de \"faire l'expérience\" d'une notion présentée dans la scène origine.";
		$manager->persist($semantique_experience);
		
		$semantique_prolepse = new Parcours\Entity\SemantiqueTransition();
		$semantique_prolepse->semantique = "Prolepse";
		$semantique_prolepse->description = "La scène destination est une scène qui apparaît plus tard dans le chemin recommandé (il s'agit donc d'un avant goût).";
		$manager->persist($semantique_prolepse);
		
		$semantique_analepse = new Parcours\Entity\SemantiqueTransition();
		$semantique_analepse->semantique = "Analepse";
		$semantique_analepse->description = "La scène destination est une scène qui apparaît plus tôt dans le chemin recommandé (il s'agit donc d'un rappel).";
		$manager->persist($semantique_analepse);
		
		$semantique_enallage = new Parcours\Entity\SemantiqueTransition();
		$semantique_enallage->semantique = "Enallage";
		$semantique_enallage->description = "La scène destination introduit une rupture (de sujet, de ton, de rythme) par rapport à la scène origine.";
		$manager->persist($semantique_enallage);
		
		$semantique_secret = new Parcours\Entity\SemantiqueTransition();
		$semantique_secret->semantique = "Passage secret";
		$semantique_secret->description = "La scène destination appartient à un autre parcours que la scène origine, la transition est proposée.";
		$manager->persist($semantique_secret);
		
		$manager->flush();
		
		/*
		 * Parcours, Sous-parcours
		 */
		$parcours = new Parcours\Entity\Parcours();
		$parcours->titre = "L'histoire de l'informatique à Grenoble";
		$parcours->description = "Grenoble est l'un des principaux centres d'activité informatique en France, caractérisé par une synergie entre formation, recherche et industrie. Ce parcours retrace les principales étapes du développement de l'informatique à Grenoble et dans sa région.";
		$parcours->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		$parcours->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		$parcours->public = false;
		
		$sous_parcours_debut = $parcours->sous_parcours_depart;
		$sous_parcours_debut->titre = "Les débuts (1950-1965)";
		$sous_parcours_debut->description = "Dans les années 1950, la France souffre d'un important retard en informatique. Néanmoins, grâce à leur clairvoyance et à leur ténacité, quelques précurseurs sauront créer les formations, les infrastructures de recherche et les collaborations industrielles qui permettront le développement de cette nouvelle discipline et de ses applications.";
		$sous_parcours_debut->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement = new Parcours\Entity\SousParcours();
		$sous_parcours_developpement->titre = "Développement, perturbations (1965-1980)";
		$sous_parcours_developpement->description = "La période 1965-1980 voit se développer l'industrie informatique à Grenoble (création de Sogeti, implantation de Hewlett-Packard, naissance de la ZIRST). Mais c'est aussi une période de fortes perturbations : restructurations en série dans le domaine des mini-ordinateurs, chemin cahoteux vers la consolidation d'une industrie nationale des semi-conducteurs, fortes restrictions de crédits pour l'enseignement supérieur et la recherche, crise de croissance de l'IMAG.";
		$sous_parcours_developpement->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		$sous_parcours_developpement->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		
		$parcours->addSousParcours($sous_parcours_developpement);
		
		$sous_parcours_debut->sous_parcours_suivant = $sous_parcours_developpement;
		
		$sous_parcours_changement = new Parcours\Entity\SousParcours();
		$sous_parcours_changement->titre = "Changement de visage (1980-1995)";
		$sous_parcours_changement->description = "L'arrivée de l'Internet et de l'informatique personnelle marque un changement profond dans les techniques et les usages de l'informatique, qui se décentralise et commence à se diffuser largement. Cette mutation touchera aussi bien la recherche que l'industrie. Parallèlement, l'évolution du marché et des technologies des semi-conducteurs impose un changement d'échelle : c'est au niveau européen, puis mondial, que va se construire un nouvel acteur industriel.";
		$sous_parcours_changement->scenes = new \Doctrine\Common\Collections\ArrayCollection();
		$sous_parcours_changement->transitions = new \Doctrine\Common\Collections\ArrayCollection();
		
		$parcours->addSousParcours($sous_parcours_changement);
		
		$sous_parcours_developpement->sous_parcours_suivant = $sous_parcours_changement;
		$sous_parcours_changement->sous_parcours_suivant = null;
		
		$manager->persist($parcours);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Première scène
		 */
		$scene1 = $sous_parcours_debut->scene_depart;
		$scene1->titre = "Tout commence par le calcul";
		$scene1->narration = "L'histoire de l'informatique à Grenoble commence avec l'arrivée du professeur Jean Kuntzmann en 1945. Sollicité par Félix Esclangon, directeur de l'Institut Polytechnique de Grenoble (École d'ingénieurs rattachée à l'université), il met en place un enseignement de mathématiques à l'usage des ingénieurs. Sensibilisé aux besoins en calcul numérique par ses contacts industriels (Neyrpic, Merlin Gerin), il crée en 1951 un Laboratoire de calcul qui tirera une grande partie de ses ressources de contrats avec l'industrie (son intitulé précise : \"Laboratoire d'essai ouvert aux applications industrielles\"). Ce laboratoire est implanté dans les combles de l'Institut Polytechnique, avenue Félix Viallet, au centre de Grenoble.
				<br>
				<br>
				Initialement équipé de calculatrices mécaniques et électromécaniques, le Laboratoire de calcul acquiert en 1952 un calculateur analogique, l'OME 12 de la SEA (Société d'Électronique appliquée à l'Automatisme), grâce à ses contacts avec le ministère de l'Air.
				<br>
				<br>
				À partir de 1956, le Laboratoire de calcul, qui a recruté un ingénieur, Louis Bolliet, se tourne vers l'informatique, en utilisant initialement les ordinateurs de ses partenaires industriels (Gamma 3 de Normacem à Lyon, puis IBM 650 de la Sogreah à Grenoble). En 1957, le Laboratoire obtient une dotation pour l'achat d'un ordinateur : ce sera le Bull Gamma ET (extension tambour).
				<br>
				<br>
				Parallèlement, les automaticiens, sous la conduite du professeur René Perret, développent une activité, également soutenue par des contacts industriels, qui conduira à la construction des premiers ordinateurs de commande de procédés. Mais la collaboration entre informatique et automatique ne s'établira pas, malgré un intérêt mutuel et des contacts suivis en 1959-1960. Cette scission initiale marquera durablement le paysage scientifique et industriel grenoblois.
				<br>
				<br>
				Au début des années 1960, le Laboratoire de calcul entame une activité de recherche en informatique. Les premiers doctorants sont issus des premières promotions de la nouvelle école d'ingénieurs créée par Kuntzmann, et qui deviendra l'ENSIMAG.
				<br>
				<br>
				Les années 1963-64 marquent une étape importante : premières thèses d'informatique, installation sur le nouveau campus (dont l'informatique sera le premier occupant), acquisition d'un puissant ordinateur, l'IBM 7044. Le Laboratoire de calcul devient un institut de recherche, l'IMAG (Institut de Mathématiques Appliquées de Grenoble), qui sera en 1966 l'un des premiers laboratoires associés au CNRS. L'exploitation des ressources informatiques est dévolue à un prestataire de services, le centre de calcul, futur CICG (Centre interuniversitaire de calcul de Grenoble). Cette organisation restera en place jusqu'aux années 1980.
				<br>
		";
		$scene1->elements = new \Doctrine\Common\Collections\ArrayCollection();
		$scene1->elements->add($jean_kuntzmann);
		$scene1->elements->add($gamma_3);
		
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Deuxième scène
		*/
		$scene2 = new Parcours\Entity\SceneRecommandee();
		$scene2->titre = "L'automatique, moteur de l'industrie";
		$scene2->narration = "En 1957, René Perret, qui vient de soutenir une thèse à l'université de Grenoble et revient d'un séjour aux États-Unis, crée un Laboratoire de Servomécanismes, rattaché à la faculté des sciences et à l'Institut polytechnique, qui deviendra en 1961 le Laboratoire d'Automatique de Grenoble (LAG). Devenu rapidement professeur, il établit dès le départ de nombreux contacts avec le monde industriel. Les contacts avec le Laboratoire de calcul (futur IMAG) de Jean Kuntzmann, créé quelques années auparavant et dans un esprit analogue, n'aboutiront pas à une collaboration, et les deux laboratoires évolueront indépendamment.
				<br>
				<br>
				À partir de 1960, le laboratoire s'intéresse à l'utilisation des circuits à transistors pour la logique booléenne. En 1961, ces travaux trouvent une application chez la société Mors, constructeur d'automatismes à relais, pour remplacer les relais électromagnétiques par des relais statiques. En 1962, un département \"automatisme et électronique\" est créé au sein de la société Mors, dans les locaux de l'IPG, sous l'impulsion de Guy Jardin, ingénieur venu suivre une formation dans la section spéciale \"automatique\" de l'IPG, et de Michel Deguerry, qui quitte le LAG pour une carrière industrielle.
				<br>
				<br>
				Son activité étant en forte croissance, ce département s'installe dans de nouveaux locaux, tout en renforçant sa collaboration avec le LAG. Les clients viennent de nombreux secteurs d'activité : pétrole, chimie, marine, énergie atomique, houillères et sidérurgie. La société conçoit une gamme de produits, dont un calculateur industriel, le MAT 01 (photo ci-contre), issu d'un travail de thèse au LAG, qui sera construit à une vingtaine d'exemplaires. C'est l'un des premiers calculateurs industriels au monde utilisant des circuits intégrés.
				<br>
				<br>
				Est alors créée au sein de Mors, en 1965, une division \"automatismes, transmission, matériel\" (ATM) qui s'installera dans une nouvelle usine à Crolles, près de Grenoble.
				<br>
				<br>
				Le cas de Mors dans les années 1960 est un exemple de collaboration fructueuse entre recherche et industrie. De nombreuses recherches du LAG sont effectuées en coopération avec Mors et une partie des thèses est réalisée sur des sites industriels. Des actions concertées tripartites associent le LAG, Mors et un client \"automatisé\", comme Naphtachimie.
				<br>
		";
		$scene2->elements = new \Doctrine\Common\Collections\ArrayCollection();
		$scene2->elements->add($rene_perret);
		$scene2->elements->add($MAT_01);
		
		$sous_parcours_debut->addScene($scene2);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Transition scene1->scene2
		 */
		
		$transition1 = new Parcours\Entity\TransitionRecommandee();
		$transition1->narration = "Vers l'automatique.";
		$transition1->semantique = $semantique_chronologie;
		$transition1->scene_origine = $scene1;
		$transition1->scene_destination = $scene2;
		
		$sous_parcours_debut->addTransition($transition1);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Troisième scène
		*/
		$scene3 = new Parcours\Entity\SceneRecommandee();
		$scene3->titre = "Inventer la formation";
		$scene3->narration = "Dans les années 1950, pour la formation à la discipline naissante de l'informatique, tout est à inventer, à commencer par la formation des formateurs. À Grenoble, les cours de mathématiques appliquées de Jean Kuntzmann sont complétés par des travaux pratiques, initialement effectués à l'aide de calculatrices de bureau, sous la direction de Jean Laborde. À partir de 1952, un calculateur analogique SEA OME 12 permet de traiter l'intégration d'équations différentielles et d'équations aux dérivées partielles. Mais la transition vers l'informatique reste à accomplir.
				<br>
				<br>
				Le Laboratoire de calcul n'avait pas initialement d'ordinateur et utilisait ceux de ses partenaires industriels. C'est ainsi que le premier cours de programmation fut donné en 1956 par M. Sollaud, ingénieur à la société Normacem de Lyon, sur le calculateur  Bull Gamma 3 muni d'une extension permettant d'introduire un programme sur cartes, au lieu d'utiliser le tableau de connexion. Les cours avaient lieu à Lyon le samedi matin. Louis Bolliet rappelle qu'il y avait 4 auditeurs : Jean Kuntzmann, Jean Laborde, Henri Rohrbach (élève ingénieur à l'IPG) et lui-même. L'année suivante, Sogreah s'équipa d'un IBM 650 et des cours de programmation eurent encore lieu sur cette machine.
				<br>
				<br>
				Enfin, à partir de 1958, le Laboratoire de calcul possède son propre ordinateur, un Bull Gamma ET, qui sert aussi de support à l'enseignement de la programmation. Outre le code machine, les premiers langages utilisés sont Fortran et Cobol, Algol ne devant apparaître qu'un peu plus tard. Ci-contre (collection Aconit), des cartes utilisées pour le premier cours de programmation donné dès 1956-57 par Louis Bolliet sur Bull Gamma 3 et Gamma ET (cliquer sur l'image pour plus de détails).
				<br>
				<br>
				Parmi les autres cours marquants, il faut citer :
				<ol>
			   		<li> le cours \"Calculateurs électroniques\" donné par René Perret à partir de 1961-62 à l'EIEG (École des Ingénieurs Électroniciens de Grenoble, école de l'institut Polytechnique de Grenoble, ou IPG) ; </li>
    				<li> le cours \"Logique et programmation\" donné par Bernard Vauquois à partir de 1959. </li>
				</ol>
				Jean Kuntzmann crée en 1956 une section spéciale \"Mathématiques Appliquées\" à l'institut Polytechnique de Grenoble. La première année, cette section n'a qu'un élève, Henri Rohrbach, qui obtient son diplôme avec la promotion suivante (5 étudiants) ; puis la croissance s'accélère. En 1960 est créée une section \"normale\" de Mathématiques appliquées, constituant une École d'ingénieurs à part entière, qui deviendra l'ENSIMAG. La première promotion, sortie en 1963, compte 13 élèves (photo ci-contre).
				<br>
				<br>
				La section spéciale de Mathématiques appliquées (qui accueille des ingénieurs déjà diplômés dans un autre domaine), bientôt étendue à l'informatique,  continuera de fonctionner jusqu'en 2012.
				<br>
				<br>
				La formation continue avait démarré dès 1951 avec la Promotion Supérieure du Travail (PST). À partir de 1959, elle s'étend au calcul numérique, puis à l'informatique et devient un institut rattaché à l'université. Plus tard, celui-ci sera associé au Conservatoire National des Arts et Métiers (CNAM) et formera des ingénieurs en informatique.
				<br>
				<br>
				Au début des années 1960 sont créées de nouvelles formations.
				<ol>
			   		<li> DEST (diplôme d'études supérieures techniques) de programmation, </li>
    				<li> licence de sciences appliquées comprenant un certificat de Techniques de la programmation, </li>
    				<li> 3ème cycle de mathématiques appliquées et d'informatique. </li>
				</ol>
				Les enseignants, souvent issus de ces mêmes filières, ont alors peu d'avance sur leurs étudiants.
				<br>
		";
		$scene3->elements = new \Doctrine\Common\Collections\ArrayCollection();
		$scene3->elements->add($cours);
		
		$sous_parcours_debut->addScene($scene3);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Transition scene2->scene3
		*/		
		$transition2 = new Parcours\Entity\TransitionRecommandee();
		$transition2->narration = "Vers la formation";
		$transition2->semantique = $semantique_chronologie;
		$transition2->scene_origine = $scene2;
		$transition2->scene_destination = $scene3;
		
		$sous_parcours_debut->addTransition($transition2);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Quatrième scène
		*/
		$scene4 = new Parcours\Entity\SceneRecommandee();
		$scene4->titre = "Les débuts de la recherche en informatique";
		$scene4->narration = "La recherche commence dès la création du Laboratoire de calcul. En effet, les nombreuses applications traitées par le laboratoire nécessitent de perfectionner les méthodes et les outils de ce qui deviendra plus tard l'analyse numérique. Les avancées réalisées font l'objet, en 1955, des Journées alpines de calcul numérique, organisées par le Laboratoire de calcul, IBM et la Sogreah.
				<br>
				<br>
				En 1956 commence l'activité proprement informatique, avec l'arrivée de Louis Bolliet, initialement ingénieur au Laboratoire de calcul. En 1957, Jean Kuntzmann crée l'AFCAL (Association Française de Calcul), qui deviendra plus tard l'AFCALTI, puis l'AFCET. En 1958, il crée la revue Chiffres, dont il sera le premier rédacteur en chef. Cette association et cette revue seront les premiers lieux d'échange d'information en France sur les domaines émergents de l'analyse numérique et de la programmation des ordinateurs. Le premier congrès de l'AFCAL, qui réunit 270 participants, se tiendra à Grenoble en 1960. Il attire divers spécialistes étrangers, dont Friedrich L. Bauer et  Maurice Wilkes.
				<br>
				<br>
				En 1957, arrive Noël Gastinel, mathématicien qui va diriger l'équipe de recherche en analyse numérique. S'intéressant de près aux techniques de l'informatique, il sera également plus tard le premier directeur du centre de calcul. En 1958 arrive Bernard Vauquois, qui s'est orienté vers l'informatique après un début de carrière dans l'astronomie. Il lance une activité autour de la traduction automatique, qui aboutira en 1959 à la création du CETA (Centre d'Études pour la Traduction Automatique) par le CNRS et la DRME (Direction des Recherches et Moyens d'Essai du ministère des Armées). Vauquois fait par ailleurs partie du comité scientifique qui définit le langage Algol 60 entre 1958 et 1961.				
				<br>
				<br>
				En 1961 démarrent des recherches dans deux domaines de l'informatique : l'algèbre de Boole, avec Kuntzmann, et la compilation des langages de programmation, avec Bolliet. Les premières thèses sont lancées, les doctorants venant des formations locales, et notamment de la section spéciale \"mathématiques appliquées\" de l'IPG. Suivant la pratique inaugurée par le Laboratoire de calcul, ces recherches font l'objet de nombreuses collaborations avec l'industrie.
				<br>
				<br>
				Les années 1963-64 voient l'installation du laboratoire (devenu IMAG, Institut de Mathématiques Appliquées de Grenoble) sur le campus créé à Saint-Martin d'Hères et Gières, l'acquisition d'un ordinateur puissant, l'IBM 7044, et l'aboutissement des premières thèses en informatique :
				<ol>
				    <li>Jean-Loup Baer, thèse de 3-ème cycle : \"Principes de compilation de COBOL\", 1963.</li>
				    <li>Jean Le Palmec, thèse de docteur-ingénieur : Étude d'un langage intermédiaire pour la compilation d'Algol 60, 1964</li>
				    <li>Jean-Claude Boussard, thèse d'État : Étude et réalisation d'un compilateur Algol 60 pour ordinateur 7040-44, 1964.</li>
				</ol>
				À noter que cette thèse d'État est en \"sciences appliquées\", la discipline Informatique n'étant pas encore officiellement reconnue (il faudra attendre 1969). Au total, cinq thèses de \"sciences appliquées\" seront soutenues dont, en 1967, celle de Louis Bolliet qui prendra alors un poste de professeur.
				<br>
				<br>
				Deux colloques, tenus en 1965, sur l'enseignement de la programmation et sur l'algèbre de Boole, témoignent de la vitalité scientifique du laboratoire. Le groupe Algol WG2.1 de l'IFIP (<i>International Federation for Information Processing</i>) tient cette même année une réunion de travail à Saint-Pierre de Chartreuse. Algol 60 est alors à l'IMAG un thème de travail et un outil privilégié (en témoigne le livre de L. Bolliet, N. Gastinel et P.-J. Laurent, <i>Un nouveau langage scientifique : Algol</i>, Hermann 1964).
				<br>
				<br>
				La recherche en informatique est maintenant lancée; elle va connaître un grand développement et une extension de son domaine dans les années qui suivent.
				<br>
		";
		$scene4->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut->addScene($scene4);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Transition scene3->scene4
		*/
		$transition3 = new Parcours\Entity\TransitionRecommandee();
		$transition3->narration = "Vers les débuts de la recherche en informatique";
		$transition3->semantique = $semantique_chronologie;
		$transition3->scene_origine = $scene3;
		$transition3->scene_destination = $scene4;
		
		$sous_parcours_debut->addTransition($transition3);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Cinquième scène
		*/
		$scene5 = new Parcours\Entity\SceneRecommandee();
		$scene5->titre = "Technologie et composants";
		$scene5->narration = "L'industrie électronique à Grenoble connaît un démarrage lent dans les années 1950. Nous replaçons ici ses débuts dans le contexte plus large de l'histoire des composants électroniques modernes.
				<br>
				<blockquote>
				Cette histoire commence avec l'invention du transistor en 1947. Ce dispositif semi-conducteur va rapidement remplacer les tubes électroniques, avec une fiabilité bien plus élevée, un faible encombrement et une consommation d'énergie réduite. Dès 1950, le transistor est intégré dans des produits de grande consommation. Le premier ordinateur transistorisé est construit par les Bell Labs en 1954. Dès lors, l'emploi du transistor dans les circuits des ordinateurs va se généraliser.
				</blockquote>
				En 1955, la Compagnie Générale de Télégraphie sans fil (CSF) transforme son usine de Saint-Égrève (banlieue ouest de Grenoble), dédiée à la fabrication de tubes à vide, en une usine de production de transistors (ci-contre, vue d'un atelier). Après des déboires initiaux dus à un changement mal maîtrisé des méthodes de production, cette activité sera filialisée en 1960 sous le nom de COSEM (Compagnie générale des semi-conducteurs). En 1961-62, la COSEM détenait près de 45% du marché des semi-conducteurs en France et réalisait 30% de son chiffre d'affaires à l'exportation.
				<br>
				<br>
				En 1956, le Commissariat à l'Énergie Atomique (CEA) crée le Centre d'Études Nucléaires de Grenoble (CENG), également implanté à l'ouest de Grenoble. En 1957 est créé au CENG, sous la direction de Michel Cordelle, un service électronique dont la mission initiale est la conception, la réalisation et la maintenance de l'appareillage de commande et de mesure du réacteur nucléaire Mélusine.
				<br><br>
				<blockquote>
				En 1958, Jack Kilby invente le premier circuit intégré à base de germanium : les transistors ne sont plus des composants discrets (séparés), mais fondus dans la masse même du semi-conducteur. Quelques mois plus tard, en 1959, Robert Noyce invente le circuit intégré à base de silicium, qui deviendra la technique dominante. En France, dans les années 1960, la plus grande partie des circuits intégrés est produite dans des usines d'entreprises américaines (Texas Instruments, Motorola, IBM).
				</blockquote>
				En 1962, le CEA décide de créer sa propre technologie des transistors et circuits intégrés afin de maîtriser l'environnement électronique des réacteurs. La mission du service électronique du CENG (futur LETI) s'élargit en conséquence. En 1963 sortent les premiers transistors et au début de 1965 le premier circuit intégré, comportant 10 transistors (photo ci-contre).
				<br><br>
				<blockquote>
				En 1965, Gordon Moore énonce sa \"loi\" : le nombre de transistors dans les circuits intégrés doublera environ tous les 18 mois. Plus de 40 ans après, cette loi s'applique toujours, mais on en perçoit les limites.
				</blockquote>
				";
		$scene5->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_debut->addScene($scene5);
		$manager->flush();
		
		/*
		 * Premier sous-parcours
		 * Transition scene4->scene5
		*/
		$transition4 = new Parcours\Entity\TransitionRecommandee();
		$transition4->narration = "Vers les technos et composants";
		$transition4->semantique = $semantique_chronologie;
		$transition4->scene_origine = $scene4;
		$transition4->scene_destination = $scene5;
		
		$sous_parcours_debut->addTransition($transition4);
		$manager->flush();
		
		
		//
		// Deuxième sous-parcours
		// Sixième scène
		//
		$scene6 = new Parcours\Entity\SceneRecommandee();
		$scene6->titre = "Usages de l'informatique";
		$scene6->narration = "La période 1965-1980 voit le début de la pénétration de l'informatique dans un nombre croissant d'activités. Mais c'est encore souvent une informatique lourde, centralisée ; l'apparition de la micro-informatique au milieu des années 1970 mettra quelques années à produire ses effets dans les usages. L'informatique s'introduit dans le domaine des télécommunications (on parle de téléinfomatique), mais dans la pratique on est encore dans l'ère pré-Internet : à la fin des années 1970, on travaille sur des réseaux point à point et on utilise le modèle rigide du vidéotex. En 1979, une étape importante est franchie avec le lancement du réseau Transpac. La grande révolution des réseaux se fera dans les années 1980.
				<br><br>
				Cette période voit aussi le développement des sociétés de service et de conseil en informatique et le début de l'informatisation de l'administration. Si l'informatique de gestion reste le domaine majeur, on doit noter l'essor de l'informatique industrielle qui trouve de multiples champs d'application.
				<br><br>
				Si l'usage de l'informatique est encore très largement une affaire de professionnels, son impact sur la société se fait déjà sentir. D'abord par l'évolution des métiers ; ensuite par la prise de conscience des menaces sur la vie privée, qui aboutira en 1978 à la loi \"informatique et libertés\". Cette même année 1978, le rapport Nora-Minc sur l'informatisation de la société sera largement diffusé et commenté.
				<br><br>
				En France, cette période est aussi celle du plan calcul, destiné à rattraper le retard en matière d'ordinateurs de moyenne puissance pour la gestion. Mais cette tentative de pilotage par l'État se soldera globalement par un échec. On en retiendra néanmoins la création de l'IRIA, devenu INRIA, aujourd'hui acteur majeur de la recherche en informatique, qui faillit d'ailleurs disparaître à la fin des années 1970.

				<h3>Comment cette période est-elle vécue à Grenoble ?</h3>
				<blockquote>
				On constate une explosion de la demande de services informatiques, qu'il s'agisse de prestations \"classiques\" en calcul scientifique ou en informatique de gestion, ou de services plus spécialisés comme l'informatique industrielle (commande de procédés, instrumentation). Face à cette demande, on trouve une offre très complète : les SSII, à l'image de SoGETI, multiplient leurs implantations ; les services \"sur mesure\" tels que les réseaux spécialisés pour l'industrie, l'analyse et la synthèse d'images, la robotique, sont fournies par de nouvelles entreprises , notamment celles implantées sur la ZIRST, qui occupent ces marchés de niches.
				<br><br>
				Dans les années 1970 arrivent les bases de données, d'abord sur les modèles hiérarchique ou réseau, à l'image de Socrate. L'accès à ces bases de données va se faire par des réseaux point à point, en mode transactionnel, ce qui signera la fin progressive de l'usage des cartes perforées et des ateliers dédiés à ce mode d'exploitation. Ces techniques accompagnent la montée de l'informatisation du tertiaire (assurances, banques, etc.). Les bases de données relationnelles apparaissent à la fin de la période.
				<br><br>
				La recherche connaît une croissance rapide, et maintient un contact étroit avec l'industrie. Les contingences politiques et économiques, et la rapidité même de la croissance, causeront néanmoins quelques perturbations.
				<br><br>
				L'explosion de la demande se répercute aussi sur la formation : de nouvelles filières sont créées pour répondre aux besoins. Beaucoup de petites entreprises qui s'équipent en matériel informatique doivent trouver les compétences pour l'exploiter ; ce \"service informatique\" se réduit souvent à une personne.
				</blockquote>
				";
		$scene6->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->scene_depart = $scene6;
		$sous_parcours_developpement->addScene($scene6);
		$manager->flush();
		
		//
		// Transition entre deux sous-parcours
		// Transition scene5->scene6
		//
		$transition5 = new Parcours\Entity\TransitionRecommandee();
		$transition5->narration = "Vers les usages de l'informatique";
		$transition5->semantique = $semantique_chronologie;
		$transition5->scene_origine = $scene5;
		$transition5->scene_destination = $scene6;
		
		$parcours->addTransition($transition5);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Septième scène
		//
		$scene7 = new Parcours\Entity\SceneRecommandee();
		$scene7->titre = "Développement de l'industrie";
		$scene7->narration = "
				Les années 1965-1980 voient d'importants changements dans l'industrie informatique à Grenoble : développements nombreux, mais aussi fortes perturbations.
				<br><br>
				La compétence acquise par la société Mors dans le domaine des calculateurs industriels va être transférée à la Télémécanique, qui développera avec succès une gamme de calculateurs. L'intervention de l'État, dans le cadre  du plan calcul, conduira à une série de fusions et acquisitions, sans bénéfice évident : création de la SEMS, de CII-Honeywell Bull, réintégration de la SEMS dans ce qui deviendra le groupe Bull. À partir de là, aucun ordinateur ne sera plus conçu à Grenoble.
				<br><br>
				Ces péripéties engendrent un effet secondaire sans doute imprévu : le départ d'un certain nombre d'ingénieurs, en désaccord avec les nouvelles orientations. Ceux-ci seront à l'origine de la création de nombreuses \"start-ups\", qui seront les premiers occupants de la ZIRST, parc d'activités de haute technologie créé à Meylan (banlieue de Grenoble) avec le concours actif des collectivités locales.
				<br><br>
				Un événement important est l'implantation à Eybens (banlieue de Grenoble), en 1971, de la société Hewlett-Packard, qui développera également plus tard des activités à L'Île d'Abeau (Isère).
				<br><br>
				Cette période marque également le début des sociétés de service. À Grenoble, la SoGETI, créée en 1967 par des transfuges de la direction commerciale de Bull, va devenir, après croissance interne et acquisitions, un des grands groupes mondiaux du domaine. Une autre création vient d'une entreprise utilisatrice de l'informatique, la Sogreah, dont le département informatique se détachera en 1968 pour créer la société 3I (Institut International d'Informatique). Celle-ci sera rapidement rachetée (en 1971) par la CGE (Compagnie Générale d’Électricité, futur Alcatel) pour former la GSI (Générale de Services Informatiques) spécialisée dans l'infogérance (externalisation de services informatiques) et basée à Paris. La GSI sera elle-même plus tard reprise par le groupe américain ADP.
				<br><br>
				Sur le front des semi-conducteurs, le service électronique du CENG, qui a acquis une grande compétence dans la conception de circuits intégrés, devient un département autonome au sein du CEA, le LETI (Laboratoire d'Électronique et de Technologie de l'Information). Le LETI sera désormais un acteur majeur dans l'industrie des semi-conducteurs et plus tard des micro- et nano-technologies. En 1972, il crée une entreprise destinée à valoriser ses résultats, EFCIS (Étude et Fabrication de Circuits Intégrés Spéciaux). Parallèlement, sous l'égide de Thomson, est créée la SESCOSEM (fusion de SESCO et COSEM). Le CNET, enfin, décide de développer sa propre filière de circuits intégrés et crée à cet effet en 1979, sur la ZIRST de Meylan, le centre Norbert Ségard.
				<br><br>
				Il faudra attendre la décennie suivante pour que tous ces efforts convergent vers l'émergence d'un grand acteur de l'industrie des semi-conducteurs.
		";
		$scene7->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene7);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Transition scene6->scene7
		//
		$transition6 = new Parcours\Entity\TransitionRecommandee();
		$transition6->narration = "Vers le développement de l'industrie";
		$transition6->semantique = $semantique_chronologie;
		$transition6->scene_origine = $scene6;
		$transition6->scene_destination = $scene7;
		
		$sous_parcours_developpement->addTransition($transition6);
		$manager->flush();
	
		//
		// Deuxième sous-parcours
		//	Scène secondaire 1
		//
		$scene_sec1 = new Parcours\Entity\SceneSecondaire();
		$scene_sec1->titre = "Sogeti et la naissance de l'industrie des services";
		$scene_sec1->narration = "
				Les premières sociétés de service et de conseil en informatique (SSCI) naissent au début des années 1960, pour combler le vide entre les constructeurs informatiques, concentrés sur le matériel et le logiciel de base, et leurs clients, qui ne souhaitent pas toujours s'investir dans la gestion d'un parc informatique et dans le développement d'applications avancées. Les créateurs de ces entreprises viennent souvent des constructeurs informatique ou du milieu du conseil.
				<br><br>
				En 1967, Serge Kampf, qui vient de la direction commerciale régionale de Bull, crée à Grenoble avec deux collègues la SoGETI (Société pour la Gestion des Entreprises et le Traitement de l'Information). Les services proposés sont une assistance technique pour la mise en place et le démarrage d'ordinateurs, et pour la mise en œuvre de programmes de gestion.
				<br><br>
				En 1968, après une tentative manquée de prise de contrôle de la part d'un groupe d'actionnaires, Serge Kampf détient l'essentiel (84%) du capital. La société remporte d'importants contrats, entre autres auprès du CEA, et va croître rapidement, notamment par le biais d'acquisitions. Elle élargira dès 1971 son activité au conseil aux entreprises et comptera quatorze agences régionales dès 1972, dont trois en Suisse.
				<br><br>
				<blockquote>
				SoGETI absorbera en 1974 deux entreprises importantes de son secteur : la société française CAP (Centre d'Analyse et de Programmation), puis CAP Europe, devenant Cap Sogeti ; ensuite, Gemini Computer Systems, devenant au 1-er janvier 1975 Cap Gemini Sogeti, première société de services en Europe, avec un effectif de 1700 personnes.
				<br><br>
				Le groupe est alors présent dans vingt pays, en Europe, Afrique et Moyen-Orient. En 1978, il prend pied aux États-Unis, où il multipliera les acquisitions dans les années 1980.
				</blockquote>
		";
		$scene_sec1->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec1);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene7->scene_sec1
		//
		$transition_sec1 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec1->narration = "Vers Sogeti et l'industrie de services";
		$transition_sec1->semantique = $semantique_chronologie;
		$transition_sec1->scene_origine = $scene7;
		$transition_sec1->scene_destination = $scene_sec1;
		
		$sous_parcours_developpement->addTransition($transition_sec1);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 2
		//
		$scene_sec2 = new Parcours\Entity\SceneSecondaire();
		$scene_sec2->titre = "Avatars des ordinateurs industriels ";
		$scene_sec2->narration = "
				Les années 1965-1980 vont marquer un fort développement des calculateurs industriels à Grenoble, dans un paysage très mouvant.
				<br><br>
				En 1965,  la division ATM de la société Mors, qui a construit le calculateur MAT 01 en collaboration avec le LAG, s'installe dans une nouvelle usine à Crolles. Elle compte 170 personnes en 1967, année où elle sera cédée à la société Télémécanique Électrique. Cette entreprise, spécialiste du contrôle industriel et de l'automatisation, crée à Grenoble une division d'informatique industrielle (DII) qui va développer une  gamme de calculateurs :
				<ul>
					<li>
				    En 1968, le T2000, dont il se vendra de 700 à 800 exemplaires.
				    </li>
					<li>
					En 1969, le T1000, version réduite et compatible du T2000.
					</li>
					<li>
					En 1972, le T1600, produit à quelques milliers d'exemplaires. Outre son usage principal pour la commande de procédés, cette machine sera utilisée pour l'enseignement de l'informatique dans les lycées.
					</li>
					<li>  
					En 1973 commence la conception de la gamme Solar 16, sous la direction d'une équipe franco-américaine dirigée par Jesse T. Quatse. Elle aboutira en 1975. Le Solar aura un succès considérable, se vendant à 16 000 exemplaires et occupant le deuxième rang mondial dans les ventes de calculateurs industriels.
					</li>
				</ul>
				Entre temps, en 1971, la division DII de Télémécanique s'est installée dans une nouvelle usine à Échirolles, dans la banlieue de Grenoble, tout en gardant le site de Crolles, qui abrite l'assemblage de sous-composants. Son effectif est alors d'environ 700 personnes, dont 400 ingénieurs et cadres.
				<br><br>
				<blockquote>
				En 1976, dans le cadre du plan calcul, l'État pousse Télémécanique à se séparer de sa division Informatique, qui fusionne avec le département \"Petits ordinateurs et systèmes\" de la Compagnie Internationale pour l'Informatique (qui devient CII-Honeywell Bull), pour former la Société Européenne de Mini-Informatique et de Systèmes (SEMS), filiale du groupe Thomson. La CII produisait déjà depuis 1971 la gamme Mitra de mini-ordinateurs, concurrente du Solar. Les deux lignes de produits coexisteront à la SEMS, la fabrication des Mitra étant transférée à Grenoble. Cette fusion modifie les orientations stratégiques de Télémécanique et provoque le départ d'un certain nombre de ses ingénieurs, qui seront à l'origine de créations d'entreprises contribuant au démarrage de la ZIRST.
				<br><br>
				En 1982, après la nationalisation de CII-Honeywell Bull, la SEMS sera fusionnée avec CII-HB et Transac pour former le groupe Bull. Cette opération entraînera une nouvelle vague de départs.
				<br><br>
				La Télémécanique, recentrée sur ses activités dans l'automatique, sera finalement reprise en 1988 par Schneider (qui deviendra alors Schneider Electric).
				</blockquote>
		";
		$scene_sec2->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec2);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec1->scene_sec2
		//
		$transition_sec2 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec2->narration = "Vers les avatars des ordinateurs industriels";
		$transition_sec2->semantique = $semantique_chronologie;
		$transition_sec2->scene_origine = $scene_sec1;
		$transition_sec2->scene_destination = $scene_sec2;
		
		$sous_parcours_developpement->addTransition($transition_sec2);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 3
		//
		$scene_sec3 = new Parcours\Entity\SceneSecondaire();
		$scene_sec3->titre = "HP à Grenoble";
		$scene_sec3->narration = "
					La société américaine Hewlett-Packard (ou HP), créée en 1939 à Palo Alto, était initialement spécialisée dans l'électronique et l'instrumentation. Elle se lança en 1960 dans le développement de semi-conducteurs et en 1966 dans la construction d'ordinateurs. Elle devait devenir par la suite un des acteurs majeurs de l'industrie informatique.
					<br><br>
					La premier établissement de production de HP hors de son siège de Palo Alto fut implanté en Allemagne en 1959, suivi d'un deuxième en Écosse. Pour développer ses activités en Europe, HP décida en 1970 d'ouvrir un établissement en France, en vue notamment de renforcer sa présence (déjà importante) sur le marché français. Le choix de Grenoble fut motivé par l'existence d'un environnement universitaire assurant une bonne formation en électronique et informatique, par l'attractivité du cadre de vie et la présence d'une main d'œuvre qualifiée, par la proximité du bureau commercial de HP à Genève, et enfin par l'aide apportée par les autorités locales et notamment par le maire de Grenoble de l'époque, Hubert Dubedout. HP put ainsi acquérir un terrain à Eybens, dans la proche banlieue de Grenoble.
					<br><br>
					HP s'installa en 1971 dans des locaux provisoires, sous la direction de Karl Schwarz, en attendant la construction du site d'Eybens. Celui-ci fut inauguré en septembre 1975, en présence des fondateurs de HP,  Bill Hewlett et Dave Packard.
					<br><br>
					Cet événement fut également marqué par une conférence de presse à Paris.
					<br><br>
					<blockquote>
					L'usine HP de Grenoble commença par fabriquer des ordinateurs 2100 destinés au marché européen. À partir de 1976, elle diversifia son activité vers les périphériques (lecteurs de cartes, unités de disques et terminaux). En 1979, la fabrication des disques fut concentrée aux États-Unis et Grenoble développa la production de terminaux d'acquisition de données.
					</blockquote>
		";
		$scene_sec3->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec3);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec2->scene_sec3
		//
		$transition_sec3 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec3->narration = "Vers HP à Grenoble";
		$transition_sec3->semantique = $semantique_chronologie;
		$transition_sec3->scene_origine = $scene_sec2;
		$transition_sec3->scene_destination = $scene_sec3;
		
		$sous_parcours_developpement->addTransition($transition_sec3);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 4
		//
		$scene_sec4 = new Parcours\Entity\SceneSecondaire();
		$scene_sec4->titre = "La ZIRST et les \"start-ups\"";
		$scene_sec4->narration = "
					Dès 1969, dans le cadre de la préparation du 6ème plan, se dégage à Grenoble l'idée d'un parc d'activité spécialisé dans les domaines scientifique et technique. Les universités et centres de recherche (notamment le CEA), la Chambre de Commerce et d'Industrie, l'Agence d'urbanisme et les collectivités locales créent alors une association pour promouvoir ce projet. Celle-ci en élabore les principes directeurs :
					<br>
					<ul>
						<li>
					    un comité d'agrément sélectionne les entreprises voulant s'implanter sur le site,
					    </li>
						<li>
						des bâtiments locatifs accueillent des entreprises en création,
					    </li>
						<li>
						des services communs (comme la restauration ou les transports) sont mis en place,
					    </li>
						<li>
						le paysage préexistant est préservé et la zone s'intègre dans la vie des environs.
						</li>
					</ul>
					La sélection des entreprises vise à préserver la fonction du parc comme pépinière d'innovation, en liaison avec l'environnement scientifique et universitaire. Les sociétés retenues doivent avoir un caractère hautement technologique, ou (dans la limite de 30%) fournir des services aux entreprises (comptabilité, logistique, etc.).
					<br><br>
					Le rôle des collectivités locales est déterminant dans la création de ce parc, initialement appelé ZIRST (Zone pour l'Innovation et les Réalisations Scientifiques et Techniques). Le département a notamment pris en charge l'acquisition des terrains. Initialement localisée à Meylan, la ZIRST s'est étendue à Montbonnot au début des années 1990 et a pris en 2005 le nom d'Inovallée.
					<br><br>
					<blockquote>
					La ZIRST est créée en 1972 et commence dès lors à accueillir ses premières entreprises, antennes de groupes existants (Merlin Gerin) ou entreprises nouvelles. Une étape importante est franchie en 1979 avec l'implantation d'un laboratoire du CNET (Centre National d'Études des Télécommunications), le centre Norbert Ségard, dont la vocation initiale est le développement d'une filière de circuits intégrés. En 1980, la ZIRST compte 58 entreprises totalisant plus de 2 000 personnes.
					<br><br>
					Mais l'image de la ZIRST est avant tout celle des \"start-up\", petites entreprises innovantes souvent issues du milieu de la recherche (comme ITMI en 1982, Getris Images en 1985, etc.). Les restructurations dans l'industrie des ordinateurs (la création de la SEMS en 1976 et sa réabsorption dans Bull en 1982) provoquent le départ d'ingénieurs qui vont alimenter la ZIRST, par la création d'entreprises nouvelles  ou de départements dans des sociétés existantes (SEMA, CERCI). C'est ainsi que seront créées Option puis X-Com, Influx, IF, CEFTI, et plus tard Aptor/Apsis, Télématique, Cybersys,  etc. Mais aucune de ces entreprises ne donnera lieu à un développement industriel propre de grande ampleur, certaines étant absorbées par de grands groupes, d'autres se spécialisant dans la réalisation de modèles ou de prototypes qui seront industrialisés ailleurs.
					<br><br>
					La ZIRST n'est toutefois pas le lieu unique de la création de nouvelles entreprises et centres de recherche. Les autres pôles principaux sont d'une part la zone du domaine universitaire, et d'autre part la \"presqu'île\", lieu d'implantation du CEA et, depuis 2006, de Minatec, centre dédié aux micro- et nano-technologies.
					</blockquote>
				";
		$scene_sec4->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec4);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec3->scene_sec4
		//
		$transition_sec4 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec4->narration = "Vers la ZIRST";
		$transition_sec4->semantique = $semantique_chronologie;
		$transition_sec4->scene_origine = $scene_sec3;
		$transition_sec4->scene_destination = $scene_sec4;
		
		$sous_parcours_developpement->addTransition($transition_sec4);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 5
		//
		$scene_sec5 = new Parcours\Entity\SceneSecondaire();
		$scene_sec5->titre = "L'industrie des semi-conducteurs";
		$scene_sec5->narration = "
					Les années 1965-1980 sont une période agitée en France, et spécialement à Grenoble, pour l'industrie naissante des semi-conducteurs. Plusieurs entreprises de taille sous-critique tentent de trouver leur place sur un marché difficile dominé par les sociétés américaines, dans un domaine technique en rapide évolution. Au fil des années, des interventions de l'État et des programmes européens, et des fusions et absorptions, des alliances se créent avec les entreprises américaines. La situation ne se clarifiera qu'à la fin des années 1980, avec l'émergence d'une entreprise initialement européenne, SGS Thomson, qui deviendra dans les années 1990, sous le nom de STMicroelectronics, un des acteurs mondiaux du domaine.
					<br><br>
					<blockquote>
					En 1965, deux pôles de développement de circuits intégrés existent à Grenoble : COSEM, filiale de CSF, et le laboratoire d'électronique du CENG, qui deviendra en 1967 le LETI (Laboratoire d'électronique et de technologie de l'information). Parallèlement, Thomson-Brandt a créé en 1962 une filiale, la SESCO (Société européenne de semi-conducteurs) dont l'usine de production est à Aix-en-Provence.
					<br><br>
					En 1967, le groupe électronique de Thomson-Brandt fusionne avec CSF. La nouvelle société devient Thomson CSF en 1968. En 1969, ses activités en semi-conducteurs (SESCO et COSEM) sont regroupées dans une filiale, la SESCOSEM, dont les usines sont à Aix-en-Provence et Saint-Égrève (photo ci-contre).
					<br><br>
					En 1972, le LETI crée une filiale industrielle pour valoriser ses recherches en semi-conducteurs, EFCIS (Études et fabrication de circuits intégrés spéciaux), dont le capital initial provient du CEA. Thomson entre en 1976 dans le capital d’EFCIS (il y deviendra majoritaire en 1982).
					<br><br>
					Malgré des accords de licence avec des sociétés américaines (EFCIS avec Motorola, SESCOSEM avec Texas Instruments), ces entreprises n'ont pas la taille et la capacité d'investissement suffisantes pour s'imposer sur le marché, et le retard de la France dans un domaine devenu stratégique ne fait que s'accentuer. Le \"plan composants\", lancé en 1977, vise à y remédier. Il aura deux effets notables :
					<br><br>
					<ul>
						<li>
					    l'arrivée d'un nouvel acteur, le CNET (Centre National d'Études des Télécommunications) qui essaiera de développer son propre programme dans son centre Norbert Ségard créé en 1979 dans la ZIRST de Meylan, près de Grenoble. Il faudra alors créer des structures de concertation pour unifier les efforts. La première de ces structures, le GCIS (Groupement Circuits Intégrés au Silicium) associe le CEA, le CNRS et le CNET pour harmoniser les politiques de recherche.
					    </li>
						<li>
						la création de nouvelles unités franco-américaines. Ainsi, Saint-Gobain s'associe à National Semiconductors sur le site de Rousset, près d’Aix-en-Provence, (qui reviendra à Thomson après le retrait de Saint-Gobain en 1982), et Matra avec Harris à Nantes.
						</li>
					</ul>
					La formation aux techniques des circuits intégrés commence à se développer, mais elle nécessite des moyens lourds. L'étape significative (création à Grenoble du Centre interuniversitaire de microélectronique, le CIME) n'adviendra qu’en 1981.
				</blockquote>
				";
		$scene_sec5->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec5);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec4->scene_sec5
		//
		$transition_sec5 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec5->narration = "Vers l'industrie des semi-sonducteurs";
		$transition_sec5->semantique = $semantique_chronologie;
		$transition_sec5->scene_origine = $scene_sec4;
		$transition_sec5->scene_destination = $scene_sec5;
		
		$sous_parcours_developpement->addTransition($transition_sec5);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		// Huitième scène
		//
		$scene8 = new Parcours\Entity\SceneRecommandee();
		$scene8->titre = "Hauts et bas de la recherche";
		$scene8->narration = "
				Les années 1965-1980 sont une période mouvementée pour la recherche en informatique à Grenoble.
				<br><br>
				D'un côté, l'IMAG connaît un fort développement au début de la période, avec une extension et un approfondissement de son champ de recherche, ainsi qu'une ouverture vers les collaborations industrielles avec les centres scientifiques (IBM puis CII).
				<br><br>
				D'un autre côté, à partir de 1974, la recherche publique est durement touchée par les restrictions budgétaires qui suivent le premier choc pétrolier. S'y ajoutent les limitations sur l'achat de matériel imposées par la politique à courte vue du plan calcul. Enfin, l'arrêt du projet de réseau Cyclades met un terme à une activité qui connaissait des débuts prometteurs.
				<br><br>
				Le laboratoire IMAG connaît par ailleurs à la fin des années 1970 une crise de croissance qui conduira ses autorités de tutelle à lui imposer, en 1982, un découpage en plusieurs laboratoires thématiques.
				<br><br>
				Malgré ces vicissitudes, la recherche parvient à préserver son potentiel et enregistre quelques avancées significatives.
				";
		$scene8->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene8);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Transition scene7->scene8
		//
		$transition7 = new Parcours\Entity\TransitionRecommandee();
		$transition7->narration = "Vers les hauts et bas de la recherche";
		$transition7->semantique = $semantique_chronologie;
		$transition7->scene_origine = $scene7;
		$transition7->scene_destination = $scene8;
		
		$sous_parcours_developpement->addTransition($transition7);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec5->scene8
		//
		$transition_sec5 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec5->narration = "Vers les hauts et les bas de la recherche";
		$transition_sec5->semantique = $semantique_chronologie;
		$transition_sec5->scene_origine = $scene_sec5;
		$transition_sec5->scene_destination = $scene8;
		
		$sous_parcours_developpement->addTransition($transition_sec5);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 6
		//
		$scene_sec6 = new Parcours\Entity\SceneSecondaire();
		$scene_sec6->titre = "L'IMAG";
		$scene_sec6->narration = "
					L'IMAG (Institut de Mathématiques Appliquées de Grenoble) est le nom que prend en 1964 le Laboratoire de Calcul créé en 1951 par Jean Kuntzmann. Il devient en 1966 l'un des tout premiers laboratoires associés au Centre National de la Recherche Scientifique (CNRS). Sa spécificité, qui fait aussi sa force, est d'associer mathématiques appliquées et informatique.
					<br><br>
					Organigramme de l'IMAG '1967) En informatique, les thèmes initiaux de l'IMAG sont les langages de programmation et leur compilation, ainsi que l'algèbre de Boole. Le champ d'activité va rapidement s'étendre à la conception de circuits, à l'architecture des machines, aux systèmes d'exploitation, aux réseaux informatiques, aux bases de données, à l'informatique de gestion, au génie logiciel. D'autres thèmes seront abordés plus tard et seront la source d'avancées majeures : les systèmes de transition (initialement, les réseaux de Petri), et l'analyse statique des programmes. Ci-contre, l'organigramme de l'IMAG, vers 1968 (cliquer dessus pour une image plus grande). On notera que l'IMAG inclut des services d'exploitation (le centre interuniversitaire de calcul ne sera créé qu'en 1972).
					<br><br>
					En mathématiques appliquées se développent des recherches en analyse numérique, particulièrement dans les domaines des systèmes linéaires et de l'approximation. Viendront ensuite le calcul des probabilités et les statistiques, l'optimisation combinatoire et les graphes, et la recherche opérationnelle. Enfin, sous l'impulsion de Jean Kuntzmann, va démarrer plus tard une activité autour de la didactique des mathématiques et de l'informatique.
					<br><br>
					Notons qu'à cette époque les activités liées à la traduction automatique ne sont pas formellement sous l'égide de l'IMAG, mais relèvent d'un autre laboratoire, initialement le CETA (Centre d'Études pour la Traduction Automatique, laboratoire propre du CNRS), puis, à partir de 1971, le GETA (Groupe d'Études pour la Traduction Automatique, laboratoire associé).
					<br><br>
					Outre l'association entre mathématiques appliquées et informatique, une autre spécificité de l'IMAG, héritée du Laboratoire de Calcul, est son ouverture aux collaborations industrielles. C'est ainsi que seront successivement créés deux \"centres scientifiques\", le premier avec IBM, le second avec la CII.
					<br><br>
					L'IMAG constitue enfin la base de connaissances et de compétences sur laquelle s'appuie une gamme complète de formations en informatique créées au cours de cette période.
					<br><br>
					À la fin des années 1970, l'IMAG traverse des années difficiles. Le bilan de cette période comporte néanmoins de belles avancées scientifiques et industrielles.
				";
		$scene_sec6->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec6);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene8->scene_sec6
		//
		$transition_sec6 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec6->narration = "Vers l'IMAG";
		$transition_sec6->semantique = $semantique_chronologie;
		$transition_sec6->scene_origine = $scene8;
		$transition_sec6->scene_destination = $scene_sec6;
		
		$sous_parcours_developpement->addTransition($transition_sec6);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 7
		//
		$scene_sec7 = new Parcours\Entity\SceneSecondaire();
		$scene_sec7->titre = "Les centres scientifiques";
		$scene_sec7->narration = "
					Les industries ont depuis longtemps cherché à exploiter les résultats de la recherche pour rester compétitives. Si les grands groupes ont souvent créé leur propre centre de recherche, ils ont également cherché à mettre en place des formes de collaboration avec les universités et les centres de recherche publics.
					<br><br>
					Les laboratoires communs sont l'un de ces instruments de collaboration. Ils ont l'avantage de faire travailler ensemble des chercheurs et des ingénieurs de l'industrie sur des projets communs et de favoriser le transfert des connaissances par la mobilité des hommes. Bien que déjà mise en œuvre dans les industries chimiques et pharmaceutiques, cette forme de collaboration était neuve en France pour une industrie informatique naissante.
					<br><br>
					<blockquote>
					La compagnie IBM, acteur majeur de l'industrie informatique, avait créé aux États-Unis, dans les années 1960, cinq \"centres scientifiques\" visant à établir des recherches communes avec des universités américaines. À la suite de contacts de Jean Kuntzmann et Louis Bolliet avec des responsables de la direction scientifique d'IBM France (Jacques Maisonrouge et René Moreau), il fut décidé en 1966 de créer un tel centre auprès de l'IMAG à Grenoble. Le thème de travail choisi fut l'utilisation conversationnelle des ordinateurs, sujet alors très actuel (en témoigne le projet Multics mené par le MIT en collaboration avec Bell Labs et General Electric), et qui était déjà exploré à l'IMAG.
					<br><br>
					Le centre scientifique IBM fut mis en place en 1967 et remplit sa mission, sous la direction de Jean-Jacques Duby, puis de Max Peltier et Alain Auroux. Néanmoins, au début des années 1970, l'existence du centre fut remise en question, en raison d'une part d'un changement de politique d'IBM vis-à-vis des centres scientifiques, d'autre part de la création à Grenoble d'un centre scientifique CII. Le centre IBM fut fermé en 1974.
					<br><br>
					Le centre scientifique CII (Compagnie Internationale pour l'Informatique) fut créé à Grenoble en 1970, dans les mêmes conditions que le centre IBM. Ses directeurs successifs furent Louis Bolliet, Jean-Pierre Verjus, Jean-Claude Chupin et Roland Balter. Il fonctionna jusqu'en 1990, date à laquelle la collaboration entre l'IMAG et le constructeur informatique national (devenu entre temps le groupe Bull), prit la forme d'une unité mixte de recherche, Bull-IMAG.
					</blockquote>
		";
		$scene_sec7->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec7);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec6->scene_sec7
		//
		$transition_sec7 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec7->narration = "Vers les centres scientifiques";
		$transition_sec7->semantique = $semantique_chronologie;
		$transition_sec7->scene_origine = $scene_sec6;
		$transition_sec7->scene_destination = $scene_sec7;
		
		$sous_parcours_developpement->addTransition($transition_sec7);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 8
		//
		$scene_sec8 = new Parcours\Entity\SceneSecondaire();
		$scene_sec8->titre = "Centre IBM";
		$scene_sec8->narration = "
					Le centre scientifique IBM de Grenoble fut créé en 1967 pour mener des travaux en collaboration avec l'IMAG sur le thème de l'exploitation conversationnelle des ordinateurs. Il fut dirigé jusqu'en 1969 par Jean-Jacques Duby et ensuite par Max Peltier et Alain Auroux. Il fut fermé en 1974.
					<br><br>
					Au début des années 1960, l'exploitation des ordinateurs en temps partagé faisait l'objet de nombreux travaux tant dans l'industrie que dans le monde de la recherche, notamment à l'IMAG sous l'impulsion de Louis Bolliet.
					<br><br>
					IBM avait lancé en 1964 sa famille d'ordinateurs IBM/360. Ces machines s'imposèrent sur le marché, mais leur architecture et leur système d'exploitation étaient conçus pour le traitement par lots (batch).
					<br><br>
					En 1966, pour aborder le domaine du temps partagé, IBM annonça le 360/67, qui disposait d'une mémoire virtuelle paginée et de mécanismes de protection, deux traits architecturaux adaptés au temps partagé. Néanmoins, son système d'exploitation, TSS (Time-Sharing System), échoua à fournir les performances requises. La solution vint du centre scientifique IBM de Cambridge (USA), qui réalisa un générateur de machines virtuelles appelé CP (Control Program). Initialement implanté sur le 360/40, CP fut porté sur le 360/67. Il fournissait à ses utilisateurs un ensemble extensible de machines virtuelles indépendantes, copies conformes de la machine physique. En équipant chacune de ces machines d'un système conversationnel mono-usager, le CMS (Cambridge Monitor System), on réalisait un système en temps partagé commode et efficace, CP/CMS.
					<br><br>
					<blockquote>
					Une part importante des travaux du centre IBM de Grenoble concernait CP/CMS. L'IMAG venait d'acquérir une machine IBM 360/67 (photo ci-dessus, ©IMAG), qui servit de support à ces travaux. Claude Hans, affecté au centre IBM de Grenoble, avait auparavant participé à Cambridge à la conception de CP, et c'est lui qui dirigea, avec Alain Auroux, l'équipe travaillant sur CP à Grenoble. Dans le domaine des langages, on peut citer la compilation incrémentale, la production de compilateurs, les langages extensibles, l'assistance (notamment graphique) au développement d'applications.
					<br><br>
					D'autres travaux sur CP concernent l'évaluation de performances et les mesures, ainsi que l'observation (une machine virtuelle spécialisée pouvant \"espionner\", voire dépanner les autres).
					<br><br>
					</blockquote>
					L'ensemble CP/CMS, auquel ont contribué les travaux réalisés à Grenoble, eut un grand succès et inspira directement la génération suivante de machines IBM, la série 370 et son système VM/370. Pendant son existence, le centre IBM de Grenoble accueillit de nombreux doctorants et prit ainsi sa part à la formation de chercheurs et d'ingénieurs. Après la fermeture du centre, son personnel IBM fut réaffecté aux centres de recherche de Paris et de La Gaude.
		";
		$scene_sec8->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec8);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec7->scene_sec8
		//
		$transition_sec8 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec8->narration = "Vers le centre IBM";
		$transition_sec8->semantique = $semantique_chronologie;
		$transition_sec8->scene_origine = $scene_sec7;
		$transition_sec8->scene_destination = $scene_sec8;
		
		$sous_parcours_developpement->addTransition($transition_sec8);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 9
		//
		$scene_sec9 = new Parcours\Entity\SceneSecondaire();
		$scene_sec9->titre = "Centre CII";
		$scene_sec9->narration = "
					Le centre scientifique CII fut créé en 1970, pour développer la collaboration entre les équipes de recherche de la Compagnie Internationale pour l'Informatique et celles de l'IMAG. Les thèmes initiaux touchaient l'architecture de systèmes. Les propositions de transfert de personnel CII depuis le centre de recherche situé en région parisienne eurent peu de succès, et le personnel fut en majeure partie recruté localement.
					<br><br>
					Les projets furent menés dans les axes suivants :
					<br>
					<ul>
						<li>
					    Systèmes d'exploitation et machines virtuelles. Le projet Gemau , mené sur l'ordinateur CII IRIS 80 (photo ci-contre), visa à réaliser un générateur de machines virtuelles. Il servit aussi de support à des travaux sur l'adressage et la protection dans les systèmes d'exploitation. Il fut prolongé par un projet d'outils pour la construction de systèmes mené par une équipe de l'IMAG.
					    </li>
						<li>
						Réseaux. Après l'arrêt du projet Cyclades en 1978, une partie des personnes travaillant sur ce projet rejoignirent le centre CII où elles continuèrent des travaux sur les protocoles de communication et sur l'architecture de systèmes répartis.
						</li>
						<li>
						Bases de données. Les années 1970 virent la naissance du modèle relationnel de bases de données, les premiers systèmes commerciaux apparaissant vers 1978-1980. Le centre CII participa à cet effort et travailla également sur les systèmes transactionnels répartis, en relation avec le thème précédent.
					    </li>
						<li>
						Calcul parallèle. Un projet d'architecture multi-microprocesseur fut mené dans les années 1970, mais ne fut pas exploité faute de support logiciel adapté.
					    </li>
						<li>
						Simulation et évaluation de performances. Un travail sur les modèles à réseaux de files d'attente aboutit à la création d'un outil, QNAP, développé en collaboration avec l'INRIA et l'IRISA. QNAP fut par la suite exploité commercialement par la société Simulog, issue de l'INRIA.
					    </li>
						<li>
						Interfaces homme-machine. Ces recherches furent menées dans les années 1980 et contribuèrent au développement de Motif, une boîte à outils pour la réalisation d'interfaces graphiques dans le système de fenêtrage X-Window utilisé par les systèmes Unix.
						</li>
					</ul>
					Il était prévu que le consortium européen Unidata (CII, Philips, Siemens), formé en 1973, implante à Grenoble son centre de recherche à partir de la base constituée par le centre scientifique CII. L'arrêt d'Unidata en 1975 mit fin à ce projet.
					<br><br>
					<blockquote>
					En 1990 (la CII ayant entre temps fusionné avec Bull), le personnel du centre scientifique rejoignit une unité mixte, Bull-IMAG, qui poursuivit la collaboration entre le groupe Bull et l'IMAG dans le domaine des systèmes et bases de données répartis et de l'édition de documents numériques. 
					</blockquote>
				";
		$scene_sec9->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec9);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec7->scene_sec9
		//
		$transition_sec9 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec9->narration = "Vers le centre CII";
		$transition_sec9->semantique = $semantique_chronologie;
		$transition_sec9->scene_origine = $scene_sec7;
		$transition_sec9->scene_destination = $scene_sec9;
		
		$sous_parcours_developpement->addTransition($transition_sec9);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec8->scene_sec9
		//
		$transition_sec10 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec10->narration = "Vers le centre CII";
		$transition_sec10->semantique = $semantique_chronologie;
		$transition_sec10->scene_origine = $scene_sec8;
		$transition_sec10->scene_destination = $scene_sec9;
		
		$sous_parcours_developpement->addTransition($transition_sec10);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec9->scene_sec8
		//
		$transition_sec11 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec11->narration = "Vers le centre IBM";
		$transition_sec11->semantique = $semantique_chronologie;
		$transition_sec11->scene_origine = $scene_sec9;
		$transition_sec11->scene_destination = $scene_sec8;
		
		$sous_parcours_developpement->addTransition($transition_sec11);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Scène secondaire 10
		//
		$scene_sec10 = new Parcours\Entity\SceneSecondaire();
		$scene_sec10->titre = "Difficultés et avancées";
		$scene_sec10->narration = "
					Après 1974, l'IMAG, comme l'ensemble de la recherche informatique en France, traverse une période difficile.
					<br><br>
					L'IMAG subit d'abord les restrictions budgétaires sévères qui suivent le premier choc pétrolier : les créations de postes sont bloquées ; les bourses de thèse elles-mêmes se raréfient, ce qui pèsera longtemps sur les recrutements ultérieurs. L'informatique, discipline très jeune et cherchant à s'affirmer, est particulièrement touchée.
					<br><br>
					L'IMAG souffre également de la politique à courte vue mise en place dans le cadre du plan calcul. Il devient impossible d'acheter une machine non française (ainsi, la communauté de recherche en informatique sera privée de tout accès au système d'exploitation Unix, initialement disponible uniquement sur du matériel américain DEC). Le projet de réseau Cyclades, dont Grenoble était un pôle important, est arrêté en 1978, alors que ses concepts étaient en avance sur ceux de l'Internet naissant.
					<br><br>
					Enfin, l'IMAG connaît à la fin des années 1970 une crise de croissance. Son organisation légère et peu formalisée, qui était bien adaptée à la taille initiale du laboratoire, ne fonctionne plus pour un ensemble comptant alors plus de 400 personnes (un exemple de dysfonctionnement est l'échec des négociations menées avec l'INRIA, à l'initiative de ce dernier, pour une implantation à Grenoble ; il faudra attendre 1992 pour que ce projet se réalise). Cette crise aboutira en 1983 à la scission de l'IMAG en plusieurs laboratoires.
					<br><br>
					<blockquote>
					Que peut-on retenir de l'histoire de l'IMAG dans ces années 1965-1980 ? D'abord, en dépit des difficultés évoquées, son affirmation comme un acteur majeur de la recherche française en informatique et mathématiques appliquées, et son enracinement dans le paysage scientifique et industriel local. Ensuite, son rôle de point d'appui à un éventail unique de formations dans son domaine, tant fondamentales que professionnelles. Enfin, les bases de quelques avancées scientifiques majeures. Citons, sans être exhaustifs :
					<br>
					<ul>
						<li>
					    Le système de gestion de bases de données Socrate, conçu et réalisé à l'IMAG en 1969-72 sous la direction de Jean-Raymond Abrial, et qui sera commercialisé par la société ECA-Automation.
					    </li><li>
						La création du concept d'interprétation abstraite, développé en 1977 par Patrick Cousot dans sa thèse, base d'une puissante méthode de vérification de programmes.
					    </li><li>
						Le développement, sous la conduite de Jean-Pierre Uhry et Christophe Lacôte, d'algorithmes et de logiciels pour le placement optimal de pièces pour la découpe, qui trouvera des applications dans des domaines très divers (industrie textile, construction mécanique). La société (SCOP) Alma sera créée en 1979 pour valoriser ces travaux.
					    </li><li>
						Le travail de Joseph Sifakis sur les systèmes de transition, présenté dans sa thèse en 1979, qui devait conduire quelques années plus tard à l'invention du model checking, autre méthode de vérification de systèmes matériels et logiciels.
						</li>
					</ul>
				</blockquote>			
				";
		$scene_sec10->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene_sec10);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec7->scene_sec10
		//
		$transition_sec12 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec12->narration = "Vers les difficultés et avancées";
		$transition_sec12->semantique = $semantique_chronologie;
		$transition_sec12->scene_origine = $scene_sec7;
		$transition_sec12->scene_destination = $scene_sec10;
		
		$sous_parcours_developpement->addTransition($transition_sec12);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//	Transition scene_sec8->scene_sec10
		//
		$transition_sec13 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec13->narration = "Vers es difficultées et avancées";
		$transition_sec13->semantique = $semantique_chronologie;
		$transition_sec13->scene_origine = $scene_sec8;
		$transition_sec13->scene_destination = $scene_sec10;
		
		$sous_parcours_developpement->addTransition($transition_sec13);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		// Transition scene_sec9->scene_sec10
		//
		$transition_sec14 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec14->narration = "Vers les difficultées et avancées";
		$transition_sec14->semantique = $semantique_chronologie;
		$transition_sec14->scene_origine = $scene_sec9;
		$transition_sec14->scene_destination = $scene_sec10;
		
		$sous_parcours_developpement->addTransition($transition_sec14);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		// Neuvième scène
		//
		$scene9 = new Parcours\Entity\SceneRecommandee();
		$scene9->titre = "La formation";
		$scene9->narration = "
				Au milieu des années 1960, l'informatisation des entreprises progresse rapidement. C'est aussi le début de l'industrie des services en informatique. Il y a donc une forte demande de personnel qualifié, alors que la formation est encore peu développée.
				<br><br>
				C'est pour répondre à cette demande que sont créées en 1966 deux formations originales à vocation professionnelle : les Instituts de programmation de Paris et de Grenoble. Il s'agit d'un cursus en deux ans, accueillant des étudiants sortis du premier cycle (bac+2), avec sélection des candidatures, et conduisant aux diplômes de Programmeur d'études (première année) et Programmeur expert en systèmes informatiques (deuxième année). Ces diplômes seront rapidement connus et appréciés sur le marché de l'emploi. L'Institut de programmation de Grenoble, initialement dirigé par Noël Gastinel, fonctionnera avec succès jusqu'en 1984, date à laquelle il sera transformé en Maîtrise de sciences et techniques (MST), sans changer de mode de fonctionnement. En 2001, cette MST laissera la place à une formation d'ingénieurs dans le cadre du réseau Polytech.
				<br><br>
				Alors que les Instituts de programmation sont orientés vers la technique, un autre cursus, celui-ci associant informatique, économie et gestion, est créé au plan national au début des années 1970 : la maîtrise MIAGE (Méthodes informatiques appliquées à la gestion des entreprises). La MIAGE de Grenoble, initialement dirigée par Claude Delobel, ouvre en 1972 et fonctionne toujours aujourd'hui.
				<br><br>
				Les Instituts Universitaires de Technologie, ou IUT (formation professionnelle en deux ans, post-baccalauréat) sont mis en place en 1966. L'IUT de Grenoble comporte un département d'informatique, créé et initialement dirigé par Louis Bolliet. En 1970, lors de la création des nouveaux établissements issus de l'université de Grenoble, l'IUT abritant ce département sera rattaché à l'université de sciences sociales (aujourd'hui université Pierre Mendès France), les autres formations universitaires en informatique étant à l'université scientifique, technologique et médicale (aujourd'hui université Joseph Fourier).
				<br><br>
				L'ENSIMAG (créée en 1960) poursuit son développement au sein de l'IPG (devenu en 1969 Institut national polytechnique de Grenoble, aujourd'hui Grenoble INP). Les promotions passent de 40 élèves en 1965 à 60 en 1972, pour atteidre 120 en 1980. Jusque vers 1975, une partie des cours sont encore communs avec ceux de la Maîtrise d'informatique. La croissance des effectifs conduit ensuite à séparer les deux formations.
				<br><br>
				<blockquote>
				En résumé, en 1975, Grenoble affiche une gamme complète de formations en informatique, tant fondamentales (maîtrise, 3ème cycle) que professionnelles (techniciens et techniciens supérieurs, ingénieurs), répartie sur trois établissements. Mise en place au gré de réformes successives et au prix d'un gros effort de la part d'un personnel encore peu nombreux, cette organisation est complexe et sans doute pas optimale du point de vue de la lisibilité et de l'usage des moyens, mais elle répond globalement aux besoins. Elle s'appuie sur le fonds commun de compétences et de connaissances développé au sein de l'IMAG.
				</blockquote>
				";
		$scene9->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_developpement->addScene($scene9);
		$manager->flush();
		
		//
		// Deuxième sous-parcours
		//Transition scene8->scene9
		//
		$transition8 = new Parcours\Entity\TransitionRecommandee();
		$transition8->narration = "Vers les hauts et bas de la recherche";
		$transition8->semantique = $semantique_chronologie;
		$transition8->scene_origine = $scene8;
		$transition8->scene_destination = $scene9;
		
		$sous_parcours_developpement->addTransition($transition8);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Dixième scène
		//
		$scene10 = new Parcours\Entity\SceneRecommandee();
		$scene10->titre = "Usages de l'informatique";
		$scene10->narration = "
				Le début des années 1980 voit une mutation profonde des usages de l'informatique, sous une double influence.
				<ol>
				    <li>L'accès généralisé aux réseaux, et spécialement à l'Internet, qui amorce la fusion entre informatique et télécommunications.
				    </li>
					<li>La large diffusion des ordinateurs personnels, qui conduit à l'avènement de la bureautique.
					</li>
				</ol>
				Ces avancées reposent sur des travaux de recherche et développement menés dans les années 1970. Le phénomène nouveau est leur pénétration universelle, qui va transformer les métiers et les conditions de travail. En parallèle, apparaît la notion de système d'information, support des connaissances, de la communication et des processus de travail au sein d'une entreprise, qui oblige à repenser l'organisation même de l'entreprise.
				<br><br>
				Le fonctionnement centralisé de l'informatique, sous le contrôle d'un centre de calcul fermé, laisse la place à un schéma beaucoup plus ouvert : le service informatique gère les serveurs, distribue et maintient les logiciels, et assure l'administration des réseaux, mais l'informatique \"cliente\", ordinateurs individuels et stations de travail, est proche des utilisateurs finaux et passe progressivement sous leur contrôle.
				<br><br>
				Cette période voit aussi une transformation de la communication : la messagerie électronique s'impose rapidement pour les échanges, et les documents deviennent numériques.
				<br><br>
				L'invention du World Wide Web en 1991 et surtout la diffusion des navigateurs et moteurs de recherche à partir de 1993-94 vont réellement faire pénétrer l'Internet dans le grand public et ouvrir l'ère des services.
				<br><br>
				<blockquote>
					Étant donné la large place que tient l'informatique dans le paysage grenoblois, ces évolutions y seront très visibles, tant dans la recherche et la formation que dans l'industrie. La montée en puissance des réseaux sera un aspect important : en témoigne la création en 1994 de Grenoble Network Initiative (devenu Grilog en 2007) club de réflexion et d'échanges pour l'industrie, la recherche et les collectivités locales autour des technologies de l'information et de la communication. Cette même année est créé le World Wide Web Consortium (W3C), organisme de normalisation pour les produits et services liés au Web. Le centre INRIA de Grenoble sera choisi en 1995 pour accueillir le pôle européen du W3C.
				</blockquote>
				";
		$scene10->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->scene_depart = $scene10;
		$sous_parcours_changement->addScene($scene10);
		
		
		//
		// Transition entre deux sous-parcours
		// Transition scene9->scene10
		//
		$transition9 = new Parcours\Entity\TransitionRecommandee();
		$transition9->narration = "Vers les usages de l'informatique";
		$transition9->semantique = $semantique_chronologie;
		$transition9->scene_origine = $scene9;
		$transition9->scene_destination = $scene10;
		
		$parcours->addTransition($transition9);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Onzième scène
		//
		$scene11 = new Parcours\Entity\SceneRecommandee();
		$scene11->titre = "Mutations dans l'industrie";
		$scene11->narration = "
				Les années 1980-1995 voient la pénétration de l'informatique dans un nombre croissant d'activités, ce qui a une double conséquence : l'émergence de nouveaux domaines d'application (comme la santé) et la transformation de nombreux métiers. Les sociétés de service se renforcent pour répondre à l'explosion de la demande. Si les plus grandes évoluent vers une fonction de conseil, de nombreuses \"start-up\" se créent sur des créneaux spécialisés.
				<br><br>
				La conception et la réalisation de circuits intégrés se concentrent en majorité dans quelques grands groupes, ce qui n'empêche pas des petites sociétés spécialisés de développer des circuits à la demande pour des usages spéciaux.
				<br><br>
				Le métier de constructeur d'ordinateur évolue fortement sur cette période. Dans les années 1980, c'est l'apparition des ordinateurs individuels, des stations de travail et des serveurs, ainsi que le recul progressif des \"mainframes\" traditionnels. À la fin des années 1980, le PC (ou plutôt ses clones, assemblés à bas coût) est le standard pour la grande majorité des ordinateurs personnels, tant dans les entreprises que dans le grand public.
				<br><br>
				Cette évolution est illustrée, à Grenoble, par l'activité des grands groupes, l'arrivée de nouveaux acteurs, la création de \"start-ups\", et la concentration dans le domaine des circuits intégrés.
				";
		$scene11->elements = new \Doctrine\Common\Collections\ArrayCollection();

		$sous_parcours_changement->addScene($scene11);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//Transition scene10->scene11
		//
		$transition10 = new Parcours\Entity\TransitionRecommandee();
		$transition10->narration = "Vers les mutations dans l'industrie";
		$transition10->semantique = $semantique_chronologie;
		$transition10->scene_origine = $scene10;
		$transition10->scene_destination = $scene11;
		
		$sous_parcours_changement->addTransition($transition10);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 11
		//
		$scene_sec11 = new Parcours\Entity\SceneSecondaire();
		$scene_sec11->titre = "Les \"start-ups\"";
		$scene_sec11->narration = "
					Les années 1980 voient de nombreuses créations de \"start-ups\" en informatique, qui se placent sur des marchés de niche en exploitant les percées technologiques. Leurs créateurs sont souvent des ingénieurs ayant acquis une première expérience, ou des scientifiques issus de laboratoires de recherche. Nombre de ces entreprises voient le jour à Grenoble, notamment sur la ZIRST. Parmi les principales :
					<br>
					<ul>
						<li>
					    Apsis (ingénierie informatique, systèmes temps réel fiables) / Aptor (réseaux locaux d'entreprise, dont le réseau industriel FACTOR), créée en 1980. Aujourd'hui, après son absorption par ITMI en 1991, filiale de CapGemini.
					    </li><br><li>
						ITMI (robotique, vision, intelligence artificielle), créée en 1982. Depuis 1997,  filiale de CapGemini.
					    </li><br><li>
						Silicomp, (réseaux, sécurité informatique, informatique embarquée), créée en 1983. Rachetée par Orange en 2006. Elle comptait alors 1200 personnes.
					    </li><br><li>
						Groupe Hardis (éditeur de logiciel pour la gestion, conseil, prestataire en infogérance, créée en 1984, 600 personnes aujourd'hui.
					    </li><br><li>
						Dolphin Integration, (conception de circuits intégrés à la demande, développement de composants virtuels, éditeur de progiciels dans le domaine de la conception de circuits), créée en 1984, 200 personnes aujourd'hui.
					    </li><br><li>
						Oros (matériel et logiciel pour le traitement du signal et spécialement  l'analyse et la mesure de bruit et vibrations), créée en 1985.
					    </li><br><li>
						Digigram (équipements et logiciel pour les services audio et vidéo sur réseaux), créée en 1985.
					    </li><br><li>
						Winsoft (internationalistion de logiciel), créée en 1985. Le groupe Winsoft rassemble aujourd'hui 5 sociétés.
					    </li><br><li>
						Getris Images (systèmes vidéographiques, infographie, affichage dynamique), créée en 1985. Rachetée en 2000 par la société israelienne Orad
					    </li><br><li>
						Teamlog (prestations d'ingénierie, infrastructures et conseil informatique), créée en 1991. A atteint 2000 personnes. Rachetée en 2008 par Groupe Open.
						</li>
					</ul>
					Beaucoup de ces entreprises sont très présentes à l'international, par le biais d'agences ou de filiales.
				";
		$scene_sec11->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec11);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene11->scene_sec11
		//
		$transition_sec15 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec15->narration = "Vers les start-ups";
		$transition_sec15->semantique = $semantique_chronologie;
		$transition_sec15->scene_origine = $scene11;
		$transition_sec15->scene_destination = $scene_sec11;
		
		$sous_parcours_changement->addTransition($transition_sec15);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 12
		//
		$scene_sec12 = new Parcours\Entity\SceneSecondaire();
		$scene_sec12->titre = "Les grands groupes";
		$scene_sec12->narration = "
					L'évolution des grands groupes industriels à Grenoble reflète les tendances générales de l'informatique dans la période 1980-1995 : montée en puissance des réseaux, croissance de la demande de services, pénétration de l'informatique dans de nouveaux domaines d'activité.
					<br>
					<ul>
						<li>
						Cap Gemini Sogeti poursuit sa croissance dans les années 1980. En 1982, le groupe réalise la moitié de son chiffre d'affaires à l'international. Il développe sa politique de rachat en France et à l'étranger (il acquiert notamment SESA en 1988). Après un passage difficile au début des années 1990, il se rétablit et change de structure, intensifiant ses activités de conseil, et devenant Cap Gemini en 1996. Son effectif dépasse alors 18 000 personnes
						</li><br><li>
						Au delà de sa fonction d'assemblage des micro-ordinateurs, l'unité Hewlett-Packard de Grenoble prend une place stratégique dans les activités de l'entreprise : en 1990, elle accueille la direction mondiale de la division ordinateurs de HP, et en 1991 le centre de compétences mondial pour les télécommunications. En 1995, HP ouvre à Grenoble un centre de recherche-développement sur les microprocesseurs.
						</li><br><li>
						L'activité du centre Bull d'Échirolles se partage maintenant entre deux grands domaines :
						le développement de logiciel pour les services aux entreprises, et la réalisation de serveurs Unix multiprocesseurs. Cette dernière activité est menée en collaboration avec IBM, dont le système AIX (créé en 1986) est choisi comme version d'Unix.
						</li><br><li>
						On note enfin sur cette période le début de la pénétration de l'informatique chez un acteur majeur de la construction de matériel électrique : Merlin Gerin. Cette société sera reprise en 1992 par Schneider Electric, qui a racheté Télémécanique en 1988. L'informatique prendra une part de plus en plus importante dans la conception et le fonctionnement de l'appareillage électrique et plus généralement dans la distribution et la gestion de l'énergie.
					</ul>
				";
		$scene_sec12->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec12);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene11->scene_sec12
		//
		$transition_sec16 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec16->narration = "Vers les grands groupes";
		$transition_sec16->semantique = $semantique_chronologie;
		$transition_sec16->scene_origine = $scene11;
		$transition_sec16->scene_destination = $scene_sec12;
		
		$sous_parcours_changement->addTransition($transition_sec16);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 13
		//
		$scene_sec13 = new Parcours\Entity\SceneSecondaire();
		$scene_sec13->titre = "Les nouveaux arrivants";
		$scene_sec13->narration = "
					Les années 1990 voient l'implantation à Grenoble de trois centres de recherche et de développement de groupes internationaux.
					<br><ul>
						<li>
						En 1990, Sun Microsystems, constructeur innovant d'ordinateurs et de systèmes logiciels, implante sur la ZIRST de Meylan son centre de développement sur les réseaux, Sun ICNC (International Center for Network Computing). Dix ans plus tard, Sun crée sur la ZIRST de Montbonnot une antenne de son centre de recherche SunLabs. Le centre de développement et le laboratoire poursuivront leur activité après le rachat de Sun par Oracle en 2010.
						</li><br><li>
						En 1990 également, l'OSF (Open Software Foundation) installe un centre de recherche à Grenoble. L'OSF est un consortium de sociétés d'informatique fondé en 1988, dont l'objectif est de définir une norme universelle pour le système Unix. Cet objectif ne sera pas atteint, mais l'OSF développera un environnement pour le calcul distribué, DCE. En 1996, l'OSF fusionnera avec un autre consortium, X-Open pour former l'Open Group, toujours actif dans la certification de logiciels. En 1999, les locaux et le personnel du centre OSF de Grenoble seront repris par la société Silicomp (réseaux, informatique embarquée), qui sera elle-même plus tard rachetée par Orange.
						</li><br><li>
						En 1993, la société Xerox ouvre à Meylan un centre de recherche, qui deviendra XRCE (Xerox Research Centre Europe). L'objectif de ce centre est de développer des méthodes et outils pour la gestion de données et de documents numériques. Ses travaux sont notamment fondés sur des techniques d'apprentissage et sur le traitement du langage naturel. L'activité du centre se partage entre la recherche appliquée et le transfert de technologie vers les produits et les services de Xerox.
						</li>
					</ul>
					Ces centres ont recruté des professionnels formés dans les établissements grenoblois et noué des collaborations avec la communauté de recherche grenobloise.
				";
		$scene_sec13->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec13);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene11->scene_sec13
		//
		$transition_sec17 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec17->narration = "Vers les nouveaux arrivants";
		$transition_sec17->semantique = $semantique_chronologie;
		$transition_sec17->scene_origine = $scene11;
		$transition_sec17->scene_destination = $scene_sec13;
		
		$sous_parcours_changement->addTransition($transition_sec17);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 14
		//
		$scene_sec14 = new Parcours\Entity\SceneSecondaire();
		$scene_sec14->titre = "La micro-électronique";
		$scene_sec14->narration = "
					En 1980, l'industrie française des circuits intégrés est dispersée entre plusieurs entreprises de taille sous-critique : EFCIS (filière industrielle du LETI), Sescosem (Thomson Semiconducteurs) à Aix-en-Provence et à Grenoble, où le CNET vient de lancer son propre centre de recherches, Matra-Harris à Nantes, Eurotechnique (Saint Gobain-National Semiconductors) à Rousset. La période qui s'ouvre est celle de la recomposition et de l’intégration.
					<br><br>
					En 1985, Thomson Semiconducteurs rachète Eurotechnique, et s'allie avec EFCIS. Mais la taille de cet ensemble reste insuffisante. En 1987, il fusionne avec le constructeur italien SGS Microelettronica, créant SGS Thomson. À partir de 1989, cette entreprise participe au programme européen Eurêka de soutien technologique JESSI (Joint European Submicron Silicon Initiative) et lance la construction d'une unité de production à Crolles (à l'est de Grenoble), qui sera inaugurée en 1993 (ci-contre, circuits sur gaufres fabriqués à Crolles).
					<br><br>
					SGS Thomson élargit sa dimension européenne avec le rachat du britannique Inmos (créateur du transputer) en 1989 et la signature d'un accord de partenariat avec Philips Semiconductors en 1991.
					<br><br>
					Du côté de la recherche amont, le CNET signe un accord avec le LETI en décembre 1990 pour coordonner les recherches dans le cadre d'un groupement d'intérêt économique, le GRESSI (Grenoble Submicronique Silicium). Les résultats de ces recherches vont alimenter SGS Thomson. Le CNET se retirera du domaine des composants à partir de 1997, pour se concentrer sur les logiciels et les services.
					<br><br>
					En 1994, SGS Thomson s'étend hors de l'Europe en rachetant des activités de la société canadienne Nortel Networks. Il sera dès lors un des grands acteurs mondiaux du domaine, devenant STMicroelectronics en 1998 et poursuivant sa croissance dans les années 2 000.
				";
		$scene_sec14->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec14);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene11->scene_sec13
		//
		$transition_sec18 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec18->narration = "Vers la micro-électronique";
		$transition_sec18->semantique = $semantique_chronologie;
		$transition_sec18->scene_origine = $scene11;
		$transition_sec18->scene_destination = $scene_sec14;
		
		$sous_parcours_changement->addTransition($transition_sec18);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Douzième scène
		//
		$scene12 = new Parcours\Entity\SceneRecommandee();
		$scene12->titre = "Un nouvel élan pour la recherche";
		$scene12->narration = "
				La période 1980-95 est initialement perturbée, mais va ensuite voir un nouvel élan pour la recherche, marqué par des événements significatifs :
				<ol>
				    <li>La création à Grenoble en 1992 d'une nouvelle unité de recherche de l'INRIA (Institut national de recherche en informatique et automatique).
					</li>    
					<li>L'installation de plusieurs laboratoires d'entreprises ou de consortiums internationaux (Sun Microsystems, Xerox, OSF), qui témoignent de l'attractivité du pôle grenoblois de recherche et de formation en informatique.
				    </li>
					<li>La création d'unités mixtes de recherche, outils de collaboration entre recherche publique et industrie.
					</li>
				</ol>
				Les restrictions sur l'achat de matériel, imposées dans le cadre du plan calcul, sont levées en 1981, ce qui permettra aux laboratoires de s'équiper en matériel conforme à l'état de l'art.
				<br><br>
				Il faut aussi noter l'instauration, en 1983, du programme européen ESPRIT (European Strategic Program on Research in Information Technology) qui apportera des financements significatifs à de nombreux  projets de recherche grenoblois et contribuera au développement de la coopération internationale.
				<br><br>
				Malgré les divers changements institutionnels, consommateurs de temps et d'énergie, cette période va enregistrer de belles avancées dans le domaine de la recherche et de sa valorisation.
				";
		$scene12->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene12);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//Transition scene11->scene12
		//
		$transition11 = new Parcours\Entity\TransitionRecommandee();
		$transition11->narration = "Vers un nouvel élan pour la recherche";
		$transition11->semantique = $semantique_chronologie;
		$transition11->scene_origine = $scene11;
		$transition11->scene_destination = $scene12;
		
		$sous_parcours_changement->addTransition($transition11);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 15
		//
		$scene_sec15 = new Parcours\Entity\SceneSecondaire();
		$scene_sec15->titre = "Avatars de l'IMAG";
		$scene_sec15->narration = "
					Au début des années 1980, l'IMAG traverse une crise de croissance. Son organisation légère et informelle, bien adaptée à sa taille initiale, ne fonctionne plus pour un ensemble comportant plus de 400 personnes. En 1983, sous la pression du CNRS dont il est laboratoire associé, l'IMAG se réorganise en six laboratoires thématiques.
					<ul>
						<li>
					    Artemis : modélisation, conception assistée par ordinateur (CAO) de circuits, graphique, recherche opérationnelle.
					    </li><li>
						GETA : traitement automatique des langues naturelles, traduction assistée par ordinateur.
					    </li><li>
						LGI (Laboratoire de génie informatique) : architecture de machines et de systèmes, réseaux, systèmes embarqués, communication homme-machine, génie logiciel, bases de données et recherche d'information, systèmes d'information.
					    </li><li>
						LIFIA (Laboratoire d'informatique fondamentale et d'intelligence artificielle) : intelligence artificielle, robotique et vision, spécification et preuves de programmes, aide à la création artistique.
					    </li><li>
						LSD (Laboratoire de structures discrètes et didactique) : graphes et combinatoire, complexité algorithmique ; didactique des mathématiques et de l'informatique.
					    </li><li>
						TIM3 : conception de circuits, architecture de machines, algorithmique parallèle et calcul formel, analyse numérique, modélisation stochastique, images, microscopie quantitative, informatique biomédicale.
						</li>
					</ul>
					Chacun de ces laboratoires est individuellement associé au CNRS. S'y ajoute une petite équipe indépendante rattachée à l'INPG, CSI (Conception de systèmes intégrés).
					<br><br>
					Imposé de l'extérieur, sans réflexion approfondie, ce découpage n'est pas toujours logique : ainsi la recherche opérationnelle est séparée des graphes, la conception de circuits, comme le traitement d'images, est à cheval sur trois laboratoires, TIM3 manque de cohérence thématique...
					<br><br>
					Le logo IMAG, conçu à cette époque, symbolise les six laboratoires (il subsistera tel quel quand ce nombre changera). Chacun des laboratoires en fera la base de son logo propre. Mais de fait, le sigle IMAG ne recouvre plus que les services communs : bibliothèque, support informatique, reprographie.
					<br><br>
					<blockquote>
					À partir de 1985, sous l'impulsion de Jean-Pierre Verjus, une action volontariste est entreprise pour redonner un sens et un contenu scientifique au nom \"IMAG\", dont l'image historique reste forte. Ainsi, les \"projets IMAG\" visent à identifier des actions thématiques à forte visibilité, qui bénéficient de moyens issus du budget de la communauté. Cette action aboutira, en 1988-89, à une nouvelle réorganisation.
					<br><br>
					<ul>
						<li>
					    D'une part, les contours des laboratoires sont redéfinis : deux nouveaux laboratoires se détachent de TIM3 : le LMC (Laboratoire de modélisation et de calcul, regroupant analyse numérique et statistiques) et TIMC (informatique médicale, application à la biologie). Restent dans TIM3 les activités de conception de circuits et d'architecture de machines. En 1994, TIM3 prendra le nom de TIMA, et intégrera une activité de service créée en 1981, CMP (Circuits multi-projets : réalisation à la demande de circuits intégrés prototypes).
					    </li><br><li>
						D'autre part et surtout, l'IMAG retrouve un contenu scientifique, sous la forme d'une fédération de recherche (organisation définie par le CNRS) regroupant la nouvelle configuration de laboratoires. Dotée de moyens incitatifs, cette structure fédérale peut définir et appliquer une politique de recherche commune et assurer une bonne visibilité et un point d'entrée unique pour l'ensemble de la communauté d'informatique et mathématiques appliquées.
						</li>
					</ul>
					La période 1990-92 sera marquée par la création de deux unités mixtes de recherche, Bull-IMAG et Verimag, et par l'implantation à Grenoble d'une nouvelle unité de recherche de l'INRIA. Ces événements influeront sur la réorganisation suivante de la fédération IMAG, qui aura lieu en 1995.
					</blockquote>
		";
		$scene_sec15->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec15);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene12->scene_sec15
		//
		$transition_sec17 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec17->narration = "Vers les avatars de l'IMAG";
		$transition_sec17->semantique = $semantique_chronologie;
		$transition_sec17->scene_origine = $scene12;
		$transition_sec17->scene_destination = $scene_sec15;
		
		$sous_parcours_changement->addTransition($transition_sec17);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 16
		//
		$scene_sec16 = new Parcours\Entity\SceneSecondaire();
		$scene_sec16->titre = "Arrivée de l'INRIA";
		$scene_sec16->narration = "
					L'INRIA (Institut national de recherche en informatique et automatique) avait souhaité s'implanter à Grenoble à la fin des années 1970, mais les contacts pris à cette époque avec l'IMAG n'avaient pas abouti.
					<br><br>
					Suite à la restructuration de l'IMAG, ce projet fut relancé au début des années 1990 et aboutit en 1992 à la création à Grenoble d'une nouvelle unité de recherche de l'INRIA. Cette unité, dirigée par Jean-Pierre Verjus, comptait initialement 4 projets de recherche, menés en commun avec des équipes de l'IMAG et hébergés dans des locaux de l'IMAG.
					<br><br>
					Dans le cadre d'une importante opération d'extension des locaux de l'INPG et de l'UJF dédiés à l'informatique, il fut initialement envisagé d'installer l'INRIA sur le campus universitaire. Néanmoins, pour accompagner la création à Montbonnot Saint-Martin, à l'est de Grenoble, d'une extension de la ZIRST de Meylan, il fut décidé d'y implanter le bâtiment de l'INRIA (en même temps qu'une antenne de l'ENSIMAG). Ce bâtiment fut livré en mars 1996. L'INRIA comptait alors 7 projets de recherche, la plupart communs avec l'IMAG. Dès cette époque, le centre INRIA incluait également un projet de recherche commun avec l'École normale supérieure de Lyon.
					<br><br>
					Ce nouveau centre de recherche de l'INRIA (qui prit plus tard le nom d'Inria Grenoble Rhône-Alpes) se développa rapidement à Montbonnot et à Lyon, sous les mandats  successifs de Jean-Pierre Verjus, Bernard Espiau et François Sillion. Ses locaux connurent plusieurs extensions. En 2012 (vingt ans après sa création), le centre comptait 35 équipes-projets, plus de 600 personnes, et avait contribué à la création de 23 entreprises.
					<br><br>
					Les grands thèmes de recherche d'Inria Grenoble Rhône-Alpes sont le calcul et la simulation, le logiciel (notamment embarqué), les réseaux et le calcul distribué, l'axe perception, cognition, interaction, et les applications aux sciences de la vie et de l'environnement.
		";
		$scene_sec16->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec16);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene_sec15->scene_sec16
		//
		$transition_sec18 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec18->narration = "Vers l'arrivée de l'INRIA";
		$transition_sec18->semantique = $semantique_chronologie;
		$transition_sec18->scene_origine = $scene_sec15;
		$transition_sec18->scene_destination = $scene_sec16;
		
		$sous_parcours_changement->addTransition($transition_sec18);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 17
		//
		$scene_sec17 = new Parcours\Entity\SceneSecondaire();
		$scene_sec17->titre = "Les unités mixtes";
		$scene_sec17->narration = "
					Dans les années 1990, l'IMAG expérimente une nouvelle forme de collaboration avec l'industrie : les unités mixtes de recherche, laboratoire communs associant des chercheurs de l'université ou du CNRS à des ingénieurs d'une entreprise, avec  l'objectif de créer et d'expérimenter des systèmes innovants, en vue d'un éventuel transfert.
					<br><br>
					En 1990 est créée la première unité mixte, Bull-IMAG. Le personnel Bull est celui du centre scientifique Bull, et les chercheurs viennent du Laboratoire de génie informatique de l'IMAG. Cette unité mixte, dirigée par  Roland Balter, mène des recherches en systèmes et bases données répartis. Elle développera notamment un environnement de programmation réparti, Guide, ainsi que des outils avancés de gestion de documents numériques. Elle contribuera à la diffusion des connaissances dans le domaine des systèmes répartis par l'organisation de plusieurs écoles nationales et internationales.
					<br><br>
					En 1993 est créée l'unité mixte Verimag, qui associe des chercheurs issus d'une équipe du Laboratoire de génie informatique de l'IMAG et des ingénieurs de la société Verilog, spécialisée dans l'ingénierie des systèmes en temps réel. Ses thèmes de recherche couvrent la spécification et la vérification de logiciel, les systèmes réactifs, les systèmes hybrides. Dirigée par Joseph Sifakis, cette unité mixte contribuera à des avancées importantes en modélisation et vérification des systèmes embarqués, qui donneront lieu à des outils industriels largement utilisés.
					<br><br>
					En 1995 est créé un laboratoire commun associant une équipe du laboratoire IMAG-LSR (Logiciel, systèmes, réseaux) et des ingénieurs de la société Dassault Systèmes (DS). L'objectif est de transférer vers le logiciel de CAO Catia de DS les résultats et le savoir-faire acquis sur Adèle, système de gestion de versions de logiciel développé à l'IMAG sous la direction de Jacky Estublier et dont Dassault Systèmes a acquis la licence. Ce laboratoire, qui fonctionnera jusqu'en 2001, n' a pas le statut d'unité mixte.
					<br><br>
					<blockquote>
					Au terme de leur mandat initial de quatre ans, le CNRS ne souhaitera pas renouveler l'expérience des deux unités mixtes, malgré les résultats encourageants obtenus. Verimag poursuivra son existence comme laboratoire autonome sous la tutelle du CNRS et des universités (INPG et UJF). Les projets lancés dans Bull-IMAG se poursuivront dans un consortium Bull-INRIA appelé Dyade, et aboutiront plus tard à la création de deux entreprises : Kelkoo (qui sera rachetée par Yahoo!) et Scalagent Technologies.
					</blockquote>
				";
		$scene_sec17->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec17);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene_sec16->scene_sec17
		//
		$transition_sec19 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec19->narration = "Vers les unités mixtes";
		$transition_sec19->semantique = $semantique_chronologie;
		$transition_sec19->scene_origine = $scene_sec16;
		$transition_sec19->scene_destination = $scene_sec17;
		
		$sous_parcours_changement->addTransition($transition_sec19);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//	Scène secondaire 18
		//
		$scene_sec18 = new Parcours\Entity\SceneSecondaire();
		$scene_sec18->titre = "Avancées de la recherche";
		$scene_sec18->narration = "
					Malgré les divers changements institutionnels, la recherche en informatique se développe pendant cette période et enregistre des avancées significatives. On peut noter, sans être exhaustifs :
					<ul>
						<li>
						Les progrès en modélisation et vérification des systèmes réactifs, qui conduiront à l'invention du model checking, technique de vérification des systèmes matériels et logiciels. Ce travail vaudra en 2007 le prix Turing à Joseph Sifakis.
					    </li><br><li>
						Les travaux sur le langage synchrone Lustre, menés par Paul Caspi et Nicolas Halbwachs, qui aboutiront au système de modélisation et de développement des systèmes réactifs SCADE, commercialisé à partir de 1993 par la société Esterel Technologies.
					    </li><br><li>
						La réalisation du système de gestion de versions et de configurations logicielles Adèle, par Jacky Estublier et son équipe. Adèle sera diffusé à plusieurs milliers d'exemplaires, et sa licence sera acquise par Dassault Systèmes.
					    </li><br><li>
						Le logiciel d'apprentissage de la géométrie Cabri Géomètre, qui sera largement diffusé, notamment sur les calculatrices Texas Instruments, puis commercialisé à partir de 2000 par la société Cabrilog créée par Jean-Marie Laborde et son équipe.
					    </li><br><li>
						Les avancées réalisées en imagerie médicale et chirurgie assistée par ordinateur, sous la direction de Philippe Cinquin et Jacques Demongeot. Ces techniques seront mises en œuvre dans les hôpitaux et seront valorisées grâce à la création de plusieurs entreprises.
						</li>
					</ul>
					Grâce aux nombreuses collaborations établies avec le monde économique et à la création d'entreprises, toutes ces recherches auront des retombées industrielles.
				";
		$scene_sec18->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene_sec18);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene_sec17->scene_sec18
		//
		$transition_sec20 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec20->narration = "Vers les avancées de la recherche";
		$transition_sec20->semantique = $semantique_chronologie;
		$transition_sec20->scene_origine = $scene_sec17;
		$transition_sec20->scene_destination = $scene_sec18;
		
		$sous_parcours_changement->addTransition($transition_sec20);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Treizième scène
		//
		$scene13 = new Parcours\Entity\SceneRecommandee();
		$scene13->titre = "La formation";
		$scene13->narration = "
				La formation en informatique et dans les domaines connexes continue à évoluer dans la période 1980-1995 pour répondre à une demande toujours croissante, ainsi qu'à l'évolution technique.
				<br><br>
				En 1981 est créé le Centre Interuniversitaire de microélectronique (CIME), à l'initiative conjointe de l'Institut National Polytechnique de Grenoble (INPG) et de l'université Joseph Fourier (UJF). Le CIME (photo ci-contre) a pour vocation de fournir les moyens nécessaires à l'enseignement et à la recherche dans le domaine de la microélectronique. Il s'agit de moyens lourds faisant appel à des techniques avancées (conception, caractérisation et test de circuits, salles blanches). À partir de 2002, le CIME sera le pôle principal d'un groupement coordonnant les activités de 12 centres de formation existant alors en France dans le même domaine (qui sera étendu aux nanotechnologies).
				<br><br>
				L'Institut de programmation de Grenoble, qui fonctionnait sous un régime spécifique, prend en 1984 le statut de Maîtrise de sciences et techniques, ce qui lui permet de délivrer un diplôme national.
				<br><br>
				En 1984 également sont créés à l'UJF deux Diplômes d'études supérieures spécialisées (DESS) en informatique. Il s'agit de formations professionnelles de niveau bac+5 recrutant leurs étudiants par sélection sur dossier, et faisant une place importante aux stages en entreprise. En 2002, avec la réforme des études supérieures, ces formations s'inséreront dans le cursus du Master.
				<ol>
				    <li>Le DESS de Génie informatique s'adresse à des étudiants ayant déjà une formation de base en informatique, du niveau de la Maîtrise. Il donne une formation approfondie centrée sur la technique (génie logiciel, systèmes et réseaux, bases de données, communication homme-machine, etc.).
				    </li>
					<li>Le DESS \"Double compétence en informatique\" (qui deviendra plus tard \"Compétence complémentaire\") s'adresse à des étudiants ayant acquis une formation du niveau de la Maîtrise dans un domaine autre que l'informatique, et désirant acquérir une formation supplémentaire dans cette discipline. En fait, en raison de la forte demande, la plupart des diplômés de cette formation effectueront une conversion totale vers l'informatique.
					</li>
				</ol>
				Des filières de formation incluant l'informatique sont par ailleurs créées dans d'autres environnements. Ainsi un DESS \"Double compétence en informatique et sciences sociales\" est  créé en 1984 à l'université Pierre Mendès France (université de sciences sociales). Une Maîtrise de sciences et techniques \"Informatique industrielle et instrumentation\" (3I) est créée en 1985 à l'UJF par des physiciens (elle deviendra plus tard une formation d'ingénieur dans le cadre du réseau Polytech).
				<br><br>
				Dans le cadre de l'INPG, l'ENSIMAG continue sa croissance (promotions de 130 élèves en 1995) et diversifie ses options.
				<br><br>
				<blockquote>
					À la fin de la période (1995), les établissements d'enseignement supérieur de Grenoble comptent au total plus de 1 000 étudiants en informatique et mathématiques appliquées, l'informatique étant largement dominante.
				</blockquote>
				";
		$scene13->elements = new \Doctrine\Common\Collections\ArrayCollection();
		
		$sous_parcours_changement->addScene($scene13);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		//Transition scene12->scene13
		//
		$transition12 = new Parcours\Entity\TransitionRecommandee();
		$transition12->narration = "Vers la formation";
		$transition12->semantique = $semantique_chronologie;
		$transition12->scene_origine = $scene12;
		$transition12->scene_destination = $scene13;
		
		$sous_parcours_changement->addTransition($transition12);
		$manager->flush();

		//
		// Troisième sous-parcours
		// Transition scene_sec15->scene13
		//
		$transition_sec21 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec21->narration = "Vers la formation";
		$transition_sec21->semantique = $semantique_chronologie;
		$transition_sec21->scene_origine = $scene_sec15;
		$transition_sec21->scene_destination = $scene13;
		
		$sous_parcours_changement->addTransition($transition_sec21);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene_sec16->scene13
		//
		$transition_sec22 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec22->narration = "Vers la formation";
		$transition_sec22->semantique = $semantique_chronologie;
		$transition_sec22->scene_origine = $scene_sec16;
		$transition_sec22->scene_destination = $scene13;
		
		$sous_parcours_changement->addTransition($transition_sec22);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene_sec17->scene13
		//
		$transition_sec23 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec23->narration = "Vers la formation";
		$transition_sec23->semantique = $semantique_chronologie;
		$transition_sec23->scene_origine = $scene_sec17;
		$transition_sec23->scene_destination = $scene13;
		
		$sous_parcours_changement->addTransition($transition_sec23);
		$manager->flush();
		
		//
		// Troisième sous-parcours
		// Transition scene_sec18->scene13
		//
		$transition_sec24 = new Parcours\Entity\TransitionSecondaire();
		$transition_sec24->narration = "Vers la formation";
		$transition_sec24->semantique = $semantique_chronologie;
		$transition_sec24->scene_origine = $scene_sec18;
		$transition_sec24->scene_destination = $scene13;
		
		$sous_parcours_changement->addTransition($transition_sec24);
		$manager->flush();
		
		
		
		
		
		
		
			/********************************
			 *	Parcour n°2
			 ********************************/


		/*
		 * Quelques artefacts et sémantiques pour remplir les scènes
		 */
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Institution'));
		$jean_kuntzmann = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$jean_kuntzmann->populate($manager, null);
		$jean_kuntzmann->titre = 'La machine de Schickard';
		$jean_kuntzmann->description = "Wilhelm Schickard (1592-1635) était un pasteur luthérien allemand, qui devint professeur d'hébreu, puis d’astronomie à l’université de Tübingen. En 1623 et 1624, il décrit, dans des lettres adressées à Kepler, une machine à calculer de son invention, capable de faire des additions et des soustractions sur des nombres jusqu’à 6 chiffres. La multiplication et la division étaient réalisées à l’aide de bâtons de Napier, mais l'opérateur devait gérer lui-même le stockage de résultats intermédiaires.
<br>
Schickard fit construire en 1624 un prototype de sa machine, mais celui-ci fut détruit dans un incendie avant d’avoir été terminé, et ne fut pas reconstruit.
		";
		$manager->persist($jean_kuntzmann);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$gamma_3 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$gamma_3->populate($manager, null);
		$gamma_3->titre = 'La Pascaline';
		$gamma_3->description = "
				La pascaline est une machine à calculer mécanique inventée en 1642 par Blaise Pascal (1623-1662). Cette machine, qui pouvait faire les additions et les soustractions, fut construite en une vingtaine d’exemplaires, dont neuf ont survécu jusqu’à nos jours (quatre d’entre eux sont exposés au Musée des Arts et Métiers, à Paris).
<br>
Blaise Pascal inventa sa machine pour aider son père, surintendant et percepteur de taxes, à faire ses calculs. La machine ne connut pas de succès commercial en raison de son prix élevé. Pascal avait l’intention de développer une machine plus simple et plus accessible, mais ce projet fut abandonné quand il cessa son activité scientifique en 1654 à la suite d’un accident.
<br>
La pascaline est considérée comme la première machine à calculer mécanique numérique. Wilhelm Schickard avait conçu en 1623 un calculateur fondé sur un principe différent, mais cette machine n’a jamais fonctionné. La pascaline inspira divers travaux ultérieurs, dont la machine de Leibniz (1671), qui pouvait faire des multiplications et des divisions, et qui est l’ancêtre des calculatrices construites jusqu’à la fin du 20ème siècle.
		";
		$manager->persist($gamma_3);
		
		$type_artefact_personne = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$rene_perret = new Collection\Entity\Artefact(null, $type_artefact_personne);
		$rene_perret->populate($manager, null);
		$rene_perret->titre = 'La machine de Leibniz';
		$rene_perret->description = "
				En 1672, lors d’un voyage à Paris, Leibniz découvre la pascaline, calculateur mécanique pouvant faire les additions et soustractions. Il conçoit alors l’idée d’une machine pouvant également réaliser les multiplications et divisions. On pense que deux machines seulement ont été construites à l’époque de Leibniz, l’une entre 1686 et 1694, l’autre entre 1690 et 1720. Cette dernière a survécu et se trouve à la Niedersächsische Landesbibliothek à Hanovre. Des répliques fonctionnelles en ont été réalisées (ci contre, copie conservée au Technische Sammlungen Museum à Dresde). La complexité du mécanisme était à la limite des capacités de réalisation mécanique de l’époque.
<br>
La machine de Leibniz, et en particulier le mécanisme du cylindre, est la source principale d’inspiration pour les calculatrices numériques ultérieures. On pense néanmoins que le principe du cylindre a pu être redécouvert indépendamment par certains inventeurs.
		";
		$manager->persist($rene_perret);
		
		$type_artefact_materiel = $manager->getRepository('Collection\Entity\TypeElement')->findOneBy(array("nom"=>'Matériel'));
		$MAT_01 = new Collection\Entity\Artefact(null, $type_artefact_materiel);
		$MAT_01->populate($manager, null);
		$MAT_01->titre = 'Arithmomètres et calculatrices';
		$MAT_01->description = "Au cours du 18ème siècle, plusieurs inventeurs (Poleni, Hahn, Stanhope et d’autres) développèrent des calculateurs mécaniques, en utilisant le cylindre de Leibniz ou des mécanismes équivalents. Mais ces expériences eurent peu de retombées. Il fallut attendre 1820 pour une avancée décisive, l’arithmomètre de Thomas de Colmar. On peut noter qu’à la même époque Charles Babbage travaillait sur sa machine à différences, qui, trop en avance sur son époque, ne put être réalisée.
<br>
Charles-Xavier Thomas, connu sous le nom de Thomas de Colmar, après un bref passage dans l’armée comme officier d’administration, créa et dirigea plusieurs compagnies d'assurances. Parallèlement, il développa plusieurs versions de l’arithmomètre et lança sa fabrication en série en 1851.
<br>
L’arithmomètre s'inspire de la machine de Leibniz, mais introduit diverses améliorations : utilisation de curseurs au lieu de roues pour l’inscription des opérandes, mécanisme correct et automatique pour le report de la retenue, inversion des parties fixe et mobile par rapport à la machine de Leibniz (le bloc des inscripteurs devenant fixe et celui des totalisateurs, plus léger, devenant mobile). Cette machine est fabriquée en série et commercialisée, jusqu’en 1914. L’exemplaire représenté ci-contre (source) date de 1887.";
		$manager->persist($MAT_01);
		
	}
}
