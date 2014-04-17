<?php

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Pages implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		/* ************** *
		 * PAGE D'ACCUEIL *
		 * ************** */

		$page_accueil = new Application\Entity\Page(
			'Accueil',
			"
				<blockquote><i>
				ACONIT, association pour un conservatoire de l'informatique et de la télématique, a été fondée à  Grenoble en 1985 pour créer les structures permettant l'étude et l'illustration de l'évolution de l'informatique, en faisant revivre son histoire passée et en suivant ses développements futurs. La mission d'ACONIT se décline selon 3 modes&nbsp;:
				</i>
				<br>
				<ul>
					<li><i>Conserver et inventorier le patrimoine scientifique. Conserver les savoir-faire et créer des supports de mémoire.</i></li>
					<li><i>Participer et impulser une réflexion sur les aspects théoriques et conceptuels de la science et des techniques informatiques dans leurs développements et leurs implications scientifiques, industrielles et sociétales.</i></li>
					<li><i>Diffuser cette histoire de l'informatique et ces réflexions pour offrir à un large public un accès vivant à la culture scientifique. <br></i></li>
				</ul>
				</blockquote>
				<a target=\"_blank\" rel=\"nofollow\" href=\"http://www.aconit.org\">www.aconit.org</a>
				<br><br>
				L'association Aconit dispose déjà  d'une collection de plusde 2000 machines et de plusieurs milliers de documents et logiciels. 
				
				<h1>Le projet Cervin</h1>
				Le numérique fait partie de notre vie quotidienne et prend une place centrale dans la société moderne. On constate néanmoins que la connaissance qu'en a le grand public reste superficielle. Ce constat vaut spécialement pour les jeunes générations qui, si elles sont familières avec l'usage des outils, ont souvent de l'informatique une image partielle et biaisée. La baisse du nombre d'étudiants s'orientant vers des carrières scientifiques est une menace pour notre compétitivité.
				
				<br><br>Une large diffusion de la culture scientifique et technique liée au numérique paraît donc une tâche prioritaire. La société industrielle a enseigné les bases des sciences de la matière à ses citoyens. Pour donner à chacun(e) toutes ses chances d'y trouver sa place et de réussir, la société de l'information française du XXIe siècle doit permettre l'accès de tous à la culture, aux sciences et aux techniques du numérique. 
				
				<br><br>Pour relever ce défi, CERVIN (Centre de ressources virtuelles pour l'innovation numérique) a été lancé par l'association ACONIT, le CCSTI de Grenoble (La Casemate) et l'INRIA, avec le soutien des collectivités locales (Communauté d'Agglomération Grenoble-Alpes-Métropole,Ville de Grenoble, Conseil Général de l'Isère), celui du Ministère de l'Enseignement Supérieur et de la Recherche, ainsi que la contribution d'acteurs économiques et des relations partenariales avec le milieu académique. Le projet est porté par F. LETELLIER. JP. VERJUS (Chevalier dans l'Ordre de la Légion d'Honneur, ancien DGA de l'INRIA) en préside le conseil scientifique. S.KRAKOWIAK, professeur émérite d'informatique, anime la communauté éditoriale de CERVIN.
				
				<br><br>CERVIN est un projet de médiation scientifique dans le domaine du numérique. Il favorise la connaissance et la compréhension de la société de l'information à travers son histoire, son actualité et sa prospective, ses sciences, techniques et cultures. Il s'adresse au plus grand nombre, hommes et femmes de toutes générations et de tous profils en s'adaptant à leurs intérêts et usages. Il propose une approche partenariale avec des acteurs de terrain et une implication du public dans des actions de co-construction de contenus. L'utilisation des technologies les plus en pointe du trans-media et des collections numériques promettent aux publics visés une expérience attractive, parfois ludique, parfois pédagogique, et toujours étayée par une collection de référence, validée par la communauté scientifique et accessible dans son intégralité.
				
				<br><br>L'activité de CERVIN s'organise selon quatre modalités :
				<br><br>
				<ul>
					<li>Une communauté éditoriale constituant un large corpus documentaire et une collection numérique de qualité</li>
					<li>Un ou plusieurs laboratoires d'étude, de restauration, de présentation de matériels et logiciels anciens ou récents, de partage d'expériences</li>
					<li>Une chaîne informatique d'acquisition, gestion et diffusion de ressources numériques permettant la constitution et la gestion d'une ou plusieurs oeuvres collectives</li>
					<li>Une démarche pro-active de diffusion des contenus vers de nombreux canaux et, au delà , de nombreux publics, dans un but de médiation scientifique, de diffusion de la culture scientifique et technique, d'éducation et de formation.</li>
				</ul>
				<div>La première étape de CERVIN a été nommée MOVING et consiste à développer une preuve de concept opérationnelle.</div>
				
				<h1>Le back-office de Cervin</h1>
				
				Cette application propose un prototype pour la partie back-office de cette première phase Moving (nom de code Moving-BO). Le back-office se situe au niveau du système de gestion de ressources. Il s'agit d'une application web permettant aux membres de la communauté éditoriale de Cervin de : 
				
				<br><br>
				<ol>
					<li>Alimenter et gérer une collection numérique organisée contenant toutes sortes de ressources illustrant la culture informatique sous différentes formes.</li>
					<li>Organiserles éléments de la collection en <i>parcours</i>, c'est-à-dire en récits porteurs de sens composés de séries d'éléments de la collection numérique.</li>
					<li>Enfin, les données gérés par le back-office (collection numérique et parcours) devront être accessible facilement via une API pour pouvoir les présenter à travers différents canaux au public. Cette partie présentation ne fait pas partie du périmètre du projet Moving-BO.</li>
				</ol><br>
			"
		);
		$manager->persist($page_accueil);
		
		/* *************** *
		 * PAGE DE CONTACT *
		 * *************** */

		$page_contact = new Application\Entity\Page(
			'Contact',
			"
				Pour toutes vos remarques (bugs, suggestions, ...), le projet Cervin utilise la forge Tuleap. Vous pouvez créer un ticket ici : 
				<a href=\"https://tuleap.cervin.org/plugins/tracker/?tracker=27&func=new-artifact\" title=\"Link: https://tuleap.cervin.org/\">Tuleap</a>
			"
		);
		$manager->persist($page_contact);
		$manager->flush();
		
		
		/* **************************** *
		 * PAGE DE CONDITIONS GENERALES *
		 * **************************** */

		$page_conditions = new Application\Entity\Page(
			'Conditions générales',

			"<p><i>Le projet de Centre de Ressources Virtuelles sur l’Innovation Numérique vise la création d’oeuvres collectives. Pour son bon fonctionnement il est nécessaire que les personnes y contribuant soient identifiées personnellement et soient joignables par les responsables du projet. La présente demande d’enregistrement permet aux personnes physiques souhaitant participer aux travaux de se faire connaître, d’obtenir une validation de leur statut de contributeur / contributrice et de bénéficier des infrastructures de travail collaboratif utilisés dans la création de ces oeuvres.</i></p>
			<br>
			Pour les questions relatives à la présente demande d’enregistrement et à son suivi, le représentant de CERVIN (désigné ci-après simplement « CERVIN ») est indiqué ci-dessous.
			<br><br>
			<blockquote>
				François LETELLIER<br>
				Porteur de projet CERVIN<br>
				c/o association ACONIT<br>
				12 rue Joseph REY<br>
				38000 GRENOBLE<br>
				email : fl@flet.fr<br>
			</blockquote>
			<ol>
			<li>
				Le Centre de Ressources Virtuelles sur l’Innovation Numérique a pour ambition de contribuer à l’acculturation du plus grand nombre à l’informatique et aux disciplines associées. Dans ce but, ce projet donne lieu à la création d’une oeuvre (ci après « l’OEUVRE ») décrite ci-après. Il s’agit d’une ou plusieurs oeuvre(s) collective(s) multimédia évolutive(s) constituée(s) d’éléments de genres différents, en particulier et sans caractère limitatif logiciels, textuels, sonores, images fixes et animées, fichiers de données, assemblés pour former un ensemble interactif. Cette/ces oeuvre(s) présente(nt) un caractère original et est/sont le résultat d’une activité indépendante de création par l’auteur et promoteur de(s) oeuvre(s).
			</li>
			<br>
			<li>
				Le CONTRIBUTEUR ayant pris connaissance de la nature et de l’objet de l’OEUVRE, exprime le souhait d’y contribuer en : mettant des contributions à disposition de CERVIN ; acceptant l’inclusion de ses contributions dans l’OEUVRE ; et en renonçant expressément à revendiquer tout droit de propriété intellectuelle sur lesdites contributions. 
			</li>
			<br>
			<li>
				Le CONTRIBUTEUR participe de son plein gré à la création de l’OEUVRE. Il reconnaît le caractère original de celle-ci et déclare ne pas en revendiquer la qualité de promoteur. Il est entendu que la soumission d’une contribution par le CONTRIBUTEUR n’emportera pas automatiquement son inclusion dans l’OEUVRE mais sera soumise à un processus d’évaluation pouvant conduire à l’acceptation, en tout ou partie, en version originale ou modifiée, ou encore au rejet de ladite contribution.
			</li>
			<br>
			<li>
				Par « contributions », il faut ici entendre : l’ensemble des développements logiciels, créations graphiques, sonores, audiovisuelles, multimédia, textuelles, fichiers et tous autres éléments protégés par un droit de propriété intellectuelle, conçus et/ou réalisés par le CONTRIBUTEUR ou sur lesquels le CONTRIBUTEUR détient légitimement les droits de propriété intellectuelle, étant convenu que ceux-ci sont conçus et/ou réalisés et/ou transmis dans le cadre de la création de l’OEUVRE. Ils sont constitués de toutes contributions mises à disposition par le CONTRIBUTEUR au jour de la signature des présentes, et de toutes les contributions ultérieurement mis à disposition par le CONTRIBUTEUR conformément au présent document. Il est entendu entre les PARTIES que les contributions des différents auteurs ont vocation à être fusionnées et/ou modifiées ce qui aboutit à l’impossibilité d’attribuer à chacun des contributeurs un droit distinct sur l’OEUVRE. 			
			</li>
			<br>
			<li>
				Par « mise à disposition », il faut ici entendre : toute transmission ou mise à disposition, directe ou indirecte, d'une contribution par le CONTRIBUTEUR à destination de CERVIN. Sont notamment des mises à disposition : toute transmission d'une contribution via l'un des outils utilisés par CERVIN (forge, email, mailing list, forum, blog, wiki, etc.) ; toute transmission d'une contribution à CERVIN, à l'un de ses employés ou à toute personne agissant dans le cadre de la constitution de l’OEUVRE ; ou encore toute publication d'une contribution en faisant expressément référence à son inclusion dans l’OEUVRE. Par chaque nouvelle mise à disposition de contributions dont il est à l'origine, le CONTRIBUTEUR confirme son acceptation des dispositions du présent document. 			
			</li>
			<br>
			<li>
				Le CONTRIBUTEUR cède à CERVIN et renonce au profit de CERVIN, à titre exclusif et gratuit, à tous les droits patrimoniaux d’auteur sur les contributions qui ont fait l’objet d’une mise à disposition.
			</li>
			<br>
				<ol>
				<li>
					Ces droits sont notamment le droit d'utiliser, le droit de reproduire, le droit de mettre en circulation, distribuer et communiquer au public, le droit de vendre ou de faire vendre, le droit de location et de prêt ainsi que le droit de représenter et de communiquer au public, par tout procédé, et notamment par télédiffusion par réseaux ou autres systèmes de télécommunication, au sein de toutes bases de données, le droit d’exploiter par tous moyens connus ou inconnus, le droit de transformer, d’arranger et d’adapter pour toutes les exploitations visées au présent paragraphe, ainsi que tous droits secondaires et dérivés, en toutes langues et en toutes versions, en totalité ou par extraits, sur tous supports, notamment papier, numériques, ou tout autre support connu ou inconnu à ce jour, en tous formats et par tous procédés connus ou inconnus à ce jour. Les droits concernés comprennent également le droit de reproduction permanent ou provisoire (y compris chargement, affichage, exécution, stockage), le droit de traduction et localisation, d’arrangement, de modification, de mise sur le marché à titre onéreux ou gratuit, y compris la location, par tous procédés, de correction, de tous développements informatiques intégrés ou connexes aux contributions ou non. 				
				</li>
				<br>
				<li>
					Cette cession est réalisée pour le monde entier et pour toute la durée de la protection légale d’après les législations tant françaises qu’étrangères et les conventions internationales actuelles ou futures y compris les prolongations qui pourraient être apportées à cette durée.
				</li>
				<br>
				<li>
					Eu égard au caractère collectif de l’OEUVRE, le CONTRIBUTEUR s’interdit aussi expressément de revendiquer à titre personnel ou pour le compte d’un tiers tout droit moral sur l’OEUVRE ou ses contributions à celles-ci.
				</li>
				<br>
				<li>
					Les contributions mises à disposition par le CONTRIBUTEUR feront ainsi intégralement partie du patrimoine immatériel de CERVIN, ce qui l’autorise : à défendre les droits afférents à l’OEUVRE, à assurer l'évolution de l’OEUVRE et à en maîtriser la diffusion.
				</li>
				<br>
				<li>
					Le CONTRIBUTEUR autorise son enregistrement dans les outils internet (sites, forums, wikis, mailing-lists, listes de diffusion) utilisés pour l’information et les travail collaboratif sur l’OEUVRE. Le CONTRIBUTEUR autorise expressément la mention de son nom (et prénom) et de sa qualité de contributeur à l’OEUVRE.
				</li>
				<br>
				<li>
					Le CONTRIBUTEUR se réserve le droit d’exploiter ses contributions personnelles et originales, isolément et indépendamment de l’OEUVRE, à condition que cette exploitation ne nuise pas à la carrière de l’oeuvre collective prise dans son ensemble.
				</li>
				</ol>
				<br>
			<li>
				Le CONTRIBUTEUR garantit être légalement fondé à décider du sort de ses contributions et du régime de propriété intellectuelle y afférant, et de ce fait, détenir les droits et pouvoirs nécessaires à les mettre à disposition pour leur intégration dans l’oeuvre et, plus généralement, à honorer les termes du présent document.
			</li>
				<br>
				<ol>
				<li>
					Lorsque les contributions sont réalisées dans le cadre d'une relation salariale, d’une action pour le compte d’un tiers, d’une commande ou d’une autre relation de subordination, le CONTRIBUTEUR s'engage à obtenir auprès du détenteur des droits de propriété intellectuelle sur ses contributions l'accord de signer le présent document et se porte-fort du respect des dispositions qui y figurent par ledit détenteur des droits. Il s’engage à fournir sur simple demande tous les justificatifs permettant d’établir l’acceptation des termes du présent document par ledit détenteur des droits. 				
				</li>
				<br>
				<li>
					Le CONTRIBUTEUR garantit qu’il n’a manqué et ne manquera à aucune obligation au titre d’une quelconque convention qui serait de nature à remettre en cause les droits cédés au titre du présent document. Le CONTRIBUTEUR garantit exactes et sincères toutes les informations fournies dans le présent document et s’engage à informer CERVIN sans délai en cas de modification de celles-ci. 				
				</li>
				<br>
				<li>
					Le CONTRIBUTEUR garantit la pleine et entière propriété de CERVIN de tous les droits sur ses contributions et la jouissance de ces droits contre tous troubles, revendications ou évictions quelconques, qu'elles viennent du CONTRIBUTEUR ou de tiers. Le CONTRIBUTEUR garantit CERVIN contre tout recours ou action que pourraient former toutes personnes physiques ou morales qui estimeraient avoir des droits quelconques à faire valoir sur tout ou partie de ses contributions ou sur leur exploitation. Il garantit en outre qu’aucun litige ou procès n’est en cours ou sur le point d’être intenté, susceptible de mettre en cause les droits de CERVIN sur ses contributions. 				
				</li>
				<br>
				</ol>
			<li>
				La validation de la présente demande d’enregistrement est constitutive d’un contrat à exécution successive et à durée indéterminée, soumis, pour sa formation, son interprétation et son exécution au droit français. Il encadre toute mise à disposition des contributions pour inclusion dans l’OEUVRE jusqu'à dénonciation expresse par l’un des co-contractants. Toute dénonciation par l’une des parties doit être expressément notifiée à l’autre partie par courrier recommandé avec accusé de réception. En cas de terminaison de ce contrat quelle qu’en soit la raison, les cessions de droits sur les contributions d'ores et déjà mises à disposition ne sont pas remises en cause. 			
			</li>
				<br>
				<ol>
				<li>
					Si une ou plusieurs stipulations du présent document sont tenues pour non valides ou déclarées telles en application d’une loi, d’un règlement ou à la suite d’une décision définitive d’une juridiction compétente, les autres stipulations garderont toute leur force et leur portée.
				</li>
				<br>
				<li>
					Tout différend pouvant naître à l’occasion de l’interprétation et/ou de l’exécution des dispositions du présent document sera soumis à une conciliation préalable à tout recours devant les tribunaux. En cas d'échec des tentatives de conciliation, les tribunaux de Grenoble seront les seuls compétents pour traiter du litige.
				</li>
				</ol>
			</ol>"
		);
		$manager->persist($page_conditions);
		$manager->flush();
		
		
	}
}