<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Parcours\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Parcours\Entity\Parcours;
use Parcours\Entity\SousParcours;
use Parcours\Form\ParcoursForm;
use Parcours\Entity\TransitionRecommandee;
use Parcours\Entity\SceneRecommandee;
use Zend\Json\Json;

/**
 * Controleur des parcours
 *
 * Permet la création, lecture, modification et suppression d'un parcours
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class ParcoursController extends AbstractActionController
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Initialisation de l'Entity Manager
	 *
	 * @param Doctrine\ORM\EntityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Retourne l'Entity Manager
	 *
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if ($this->em === null) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->em;
	}

	/**
	 * Affiche la liste des parcours
	 * 
	 */
    public function indexAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
    	$params = null;

    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$params = $this->params()->fromPost();
    	}
    	
    	if(!isset($params["iSortCol_0"])){
    		$params["iSortCol_0"] = '0';
    	}

    	if(!isset($params["sSortDir_0"])){
    		$params["sSortDir_0"] = 'ASC';
    	}
    	
    	$entityManager = $this->getEntityManager()
    					      ->getRepository('Parcours\Entity\Parcours');
 
    	$dataTable = new \Parcours\Model\ParcoursDataTable($params);
    	$dataTable->setEntityManager($entityManager);

    	$dataTable->setConfiguration(array(
    		'titre',
    		'description',
    		'public'
    	));

    	$aaData = array();
    	
    	$paginator = null;
    	
    	if(isset($params["conditions"])){
    		$conditions = json_decode($params["conditions"], true);
    		$paginator = $dataTable->getPaginator($conditions);
    	} else {
    		$paginator = $dataTable->getPaginator();
    	}
    		
    	foreach ($paginator as $parcours) {
    		
			if ($parcours->public) {
				$etat = 'Public';
			} else {
				$etat = '<p class="muted"> Brouillon</p>';
			}
			
			$titre = '<a href="'
						.$this->url()->fromRoute('parcours/voir', array('id' => $parcours->id, 'return'=>'')).'">'
						.$escapeHtml($parcours->titre).'
					</a>';

			// Contributeur qui n'a pas les droits parcours
    		$aaData[] = array(
    				$titre,
    				$dataTable->truncate($parcours->description, 250, ' ...', false, true),
    				$etat
    		);
	    	
    	}
    	
    	$dataTable->setAaData($aaData);
    
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		return $this->getResponse()->setContent($dataTable->findAll());
    	} else {
    		return new ViewModel();
    	}
    }

  	public function ajouterAction()
  	{
	    $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
	    $escapeHtml        = $viewHelperManager->get('escapeHtml');
	    $form              = new ParcoursForm();
	    $Parcours          = new Parcours();
	    $request           = $this->getRequest();
	    $form->bind($Parcours);
	
	    if ($request->isPost()) {
	
	        $form->setInputFilter($Parcours->getInputFilter());
	        $form->setData($request->getPost());
	
	        if ($form->isValid()) {
	            $this->getEntityManager()->persist($Parcours);
	            $this->getEntityManager()->flush();
	            $this->flashMessenger()->addSuccessMessage(sprintf('Le Parcours ["%1$s"] a bien été créé.', $escapeHtml($Parcours->titre)));
	            return $this->redirect()->toRoute('parcours/voir', array ('id' => $Parcours->id));
	        }
	
	    }
	    return new ViewModel(array('form'=>$form));
	}

    public function supprimerAction() {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
    	if ($parcours === null || $id === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$this->flashMessenger()->addErrorMessage(sprintf('La suppression d\'un parcours n\'est pas encore implémentée.'));
    	return $this->getResponse()->setContent(Json::encode(true));
    }
    
    /**
     * Affiche la fiche d'un parcours
     * 
     * @return void|\Zend\View\Model\ViewModel
     */
    public function voirAction()
    {
        $id = (int) $this->params('id', null);
        if (null === $id) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        $Parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
        if ($Parcours === null) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        
        if (!$Parcours->public && !$this->isAllowed('Utilisateur')) {
        	$this->flashMessenger()->addErrorMessage(sprintf('Ce parcours n\'est pas accessible au public, vous devez vous connecter pour pouvoir le consulter.'));
        	return $this->redirect()->toRoute('zfcuser/login');
        }
        
        $SemantiqueTransitions = $this->getEntityManager()
       	 	->getRepository('Parcours\Entity\SemantiqueTransition')
        	->findBy(array(), array('semantique'=>'asc'));
        
        /* Génération du graphe du parcours au format dot */
        
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtmlAttr');
        
        
        $dot = 'digraph "' . $Parcours->titre . '" {' . "\n";
        $dot .= 'graph [bgcolor="#f3f3f3"]' . "\n";
        $dot .= 'Départ [shape="plaintext"];' . "\n";
        $dot .= 'Départ -> s' . $Parcours->sous_parcours_depart->scene_depart->id.'[style=dashed];' . "\n";
        foreach ( $Parcours->transitions as $transition) {
        	// Transitions inter-sous-parcours
        	$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;
        	$dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id;
        	if ($this->isAllowed('Parcours')) {
        		$dot .= '[edgetooltip="'.$escapeHtml($semantique).'",color="darkblue",penwidth="4",fontcolor="darkblue",URL="'.$this->url()->fromRoute('transition/voir', array('id' => $transition->id)).'"];' . "\n";
        	} else {
        		$dot .= '[edgetooltip="'.$escapeHtml($semantique).'",color="darkblue",penwidth="4",fontcolor="darkblue"];' . "\n";
        	}
        }
        foreach ($Parcours->sous_parcours as $sous_parcours) {
        	// Sous-parcours
        	$dot .= 'subgraph cluster_'.$sous_parcours->id.'{';
        	$dot .= 'color="darkgreen";';
        	$dot .= 'label = "'.$escapeHtml($sous_parcours->titre).'";';
        	//$dot .= 'tooltip = "'.$escapeHtml($sous_parcours->titre).'";';
        	$dot .= 'fontcolor="darkgreen";';
        	$dot .= 'fontsize="20";';
        	$dot .= 'style="dashed";' . "\n";
        	foreach ( $sous_parcours->transitions as $transition) {
        		// Transitions
        		$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;
        		$style = ($transition instanceOf \Parcours\Entity\TransitionRecommandee) ? 'color="blue", penwidth="4", fontcolor="blue"' : 'color="grey", fontcolor="grey", penwidth="4"' ;
        		if ($this->isAllowed('Parcours')) {
        			$dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id.'['.$style.',edgetooltip="'.$escapeHtml($semantique).'",URL="'.$this->url()->fromRoute('transition/voir', array('id' => $transition->id)).'"];' . "\n";
        		} else {
        			$dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id.'['.$style.',edgetooltip="'.$escapeHtml($semantique).'"];' . "\n";
        		}
        	}
        	foreach ( $sous_parcours->scenes as $scene) {
        		// Scenes
        		if ($scene instanceOf \Parcours\Entity\SceneRecommandee) {
        			$style = 'color="blue", style=bold, fontcolor="darkblue"';
        		} elseif ($scene->transitions_secondaires_entrantes == null 
        				|| $scene->transitions_secondaires_entrantes->count() == 0) {
        			$style = 'color="grey", fontcolor="darkred"';
        		} else {
        			$style = 'color="grey", fontcolor="grey"';
        		}
        		$dot .= 's'.$scene->id.'[id="s'.$scene->id.'", label="'.$escapeHtml($scene->titre).'", '.$style.', shape="box", URL="'.$this->url()->fromRoute('scene/voirScene', array('id' => $scene->id)).'"];' . "\n";
        	}
        	$dot .= '}' . "\n";
        }
        $dot .= '}';
        
        return new ViewModel(array(
        		'Parcours'=>$Parcours,
        		'SemantiqueTransitions'=>$SemantiqueTransitions, 
        		'dot'=>$dot));
    }

    public function modifierAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $id = (int) $this->params('id', null);
            $Parcours = $this->getEntityManager()
            ->getRepository('Parcours\Entity\Parcours')
            ->findOneBy(array('id'=>$id));
            
            if ($Parcours === null || $id === null) {
                $this->getResponse()->setStatusCode(404);
                return;
            }
            
            $request = $this->params()->fromPost();
            
            switch ($request['name']) {
                case 'titre':
                $Parcours->titre = $request['value'];
                $this->getEntityManager()->flush();
                break;

                case 'description':
                $Parcours->description = $request['value'];
                $this->getEntityManager()->flush();
                break;

                default:
                $this->getResponse()->setStatusCode(404);
                break;
            }
            
            return $this->getResponse()->setContent(Json::encode(true));

        } else {
            $this->getResponse()->setStatusCode(404);
        }
    }
    
    /**
     * Affichage du parcour avec halviz
     */
    public function voirParcourHalvizAction()
    {
      $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
      $escapeHtml = $viewHelperManager->get('escapeHtmlAttr');
      
      $id = (int) $this->params('id', null);
      $Parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
      if ($Parcours === null || $id === null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }
   	  $graph ='$graph';
      // création du dot
      $dot = 'Départ [shape="plaintext"];' . ' ';
      $dot .= 'Départ -> s' . $Parcours->sous_parcours_depart->scene_depart->id.'[style="dashed"];' . ' ';
      foreach ( $Parcours->transitions as $transition) {
      		// Transitions inter-sous-parcours
      		$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;
        	
            $graph .= "->edge(array('".$transition->scene_origine->id."', '".$transition->scene_destination->id."'), array('edgetooltip' => '".$escapeHtml($semantique)."'))";


            $dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id;
        	$dot .= '[ edgetooltip="'.$escapeHtml($semantique).'", color="darkblue", penwidth="3", fontcolor="darkblue"];' . ' ';
      }
      foreach ($Parcours->sous_parcours as $sous_parcours) {
      		// Sous-parcours

            $graph .= '->subgraph(\'cluster_'.$sous_parcours->id.'\')';
            $graph .= "->set('color', 'darkgreen')";
            $graph .= "->set('label', '".$escapeHtml($sous_parcours->titre)."')";
            $graph .= "->set('tooltip', '".$escapeHtml($sous_parcours->titre)."')";
            $graph .= "->set('fontcolor', 'darkgreen')";
            $graph .= "->set('fontsize', '20')";
            $graph .= "->set('style', 'dashed')";



	        $dot .= 'subgraph cluster_'.$sous_parcours->id.'{';
	        $dot .= 'color="darkgreen";';
	        $dot .= 'label = "'.$escapeHtml($sous_parcours->titre).'";';
	        $dot .= 'tooltip = "'.$escapeHtml($sous_parcours->titre).'";';
	        $dot .= 'fontcolor="darkgreen";';
	        $dot .= 'fontsize="20";';
	        $dot .= 'style="dashed";' . ' ';
	        foreach ( $sous_parcours->transitions as $transition) {
	        	// Transition


	        	$semantique = ($transition->semantique) ? $transition->semantique->semantique : 'Sémantique inconnue' ;

                $graph .= "->edge(array('".$transition->scene_origine->id."', '".$transition->scene_destination->id."'), array('edgetooltip' => '".$escapeHtml($semantique)."'))";


	        	$style = ($transition instanceOf \Parcours\Entity\TransitionRecommandee) ? 'color="blue", penwidth="3", fontcolor="blue"' : 'color="grey", fontcolor="grey", penwidth="2"' ;
                $dot .='s'.$transition->scene_origine->id.' -> '.'s'.$transition->scene_destination->id.'['.$style.', edgetooltip="'.$escapeHtml($semantique).'"];' . ' ';
	        }
	        foreach ( $sous_parcours->scenes as $scene) {
	        	// Scene
                $graph .= "->node(".$scene->id.", array('label' => '".$escapeHtml($scene->titre)."', 'shape' => 'box'))";

	        	$style = ($scene instanceOf \Parcours\Entity\SceneRecommandee) ? 'color="blue", style="bold", fontcolor="darkblue"' : 'color="grey", fontcolor="grey"' ;
	        	$dot .= 's'.$scene->id.'[label="'.$escapeHtml($scene->titre).'", '.$style.', shape="box", URL="'.$this->url()->fromRoute('scene/voirScene', array('id' => $scene->id)).'"];' . ' ';
	        }
	        $graph .= "->end()";
	        $dot .= '}' . ' ';
      }
      return new ViewModel(array('Parcours' => $Parcours,'dot'=>$dot, 'graph'=>$graph));
    }

    public function ajouterSousParcoursAction()
    {
        $idsp = (int) $this->params('idsp', null);
        $action = $this->params('type', null);
        if (null === $idsp or null === $action) {
            $this->getResponse()->setStatusCode(404);
            return; 
        }
        $sousparcours = $this->getEntityManager()
                ->getRepository('Parcours\Entity\SousParcours')
                ->findOneBy(array('id'=>$idsp));

        $newsp = new SousParcours();
        $newsp->titre = 'Nouveau sous-parcours';
        $newsp->description = 'Description à écrire';
        $newsp->transitions = new \Doctrine\Common\Collections\ArrayCollection();
        $newsp->scenes = new \Doctrine\Common\Collections\ArrayCollection();
        
        $newScene = new SceneRecommandee();
        $newScene->titre = 'Nouvelle scène';
        $newScene->narration = 'Narration à écrire';
        $newsp->addScene($newScene);
        $newsp->scene_depart = $newScene;
        
        $newTransitionRecommandee = new TransitionRecommandee();
        $newTransitionRecommandee->narration = 'Nouvelle Transition';
        $sousparcours->parcours->addSousParcours($newsp);
        $newsp->parcours->addTransition($newTransitionRecommandee);
        $this->getEntityManager()->persist($newTransitionRecommandee);
        $this->getEntityManager()->persist($newScene);
        $this->getEntityManager()->persist($newsp);
        $this->getEntityManager()->flush();
        switch ($action)
        {
            case 'ajAvant': // On ajoute un sous-parcours avant $sousparcours
                if($sousparcours->parcours->sous_parcours_depart === $sousparcours)
                {
                    $sousparcours->parcours->sous_parcours_depart = $newsp;
                    $newTransitionRecommandee->scene_origine = $newScene;
                    $newTransitionRecommandee->scene_destination = $sousparcours->scene_depart;
                    $newsp->sous_parcours_suivant = $sousparcours;
                }
                else
                {
                    $tr_before = $this->getEntityManager()
                            ->getRepository('Parcours\Entity\TransitionRecommandee')
                            ->findOneBy(array('scene_destination'=>$sousparcours->scene_depart));
                    $pass = $tr_before->scene_origine;
                    $tr_before->scene_origine = $newScene;
                    $this->getEntityManager()->flush();
                    $newTransitionRecommandee->scene_origine = $pass;
                    $sp_before = $pass->sous_parcours;
                    $sp_before->sous_parcours_suivant = $newsp;
                    $this->getEntityManager()->flush();
                    $newsp->sous_parcours_suivant = $sousparcours;
                    $newTransitionRecommandee->scene_destination = $newScene;
                }
            break;
            case 'ajApres': // On ajoute un sous-parcours après $sousparcours
                if($sousparcours->sous_parcours_suivant === null)
                // C'est le dernier sous-parcours
                // On cherche la dernière scène après laquelle 
                // on doit relier le nouveau sous-parcours
                {
                    foreach ($sousparcours->scenes as $scene)
                    {
                        if($scene instanceOf \Parcours\Entity\SceneRecommandee 
                        	&& $scene->transition_recommandee === null)
                        {
                            $last_scene = $scene;
                            break;
                        }
                    }
                    $newTransitionRecommandee->scene_origine = $last_scene;
                }
                else
                {
                    $tr_after = $this->getEntityManager()
                            ->getRepository('Parcours\Entity\TransitionRecommandee')
                            ->findOneBy(array('scene_destination'=>$sousparcours->sous_parcours_suivant->scene_depart));
                    $pass = $tr_after->scene_origine;
                    $tr_after->scene_origine= $newScene;
                    $newTransitionRecommandee->scene_origine = $pass;
                }
                $pass = $sousparcours->sous_parcours_suivant;
                $sousparcours->sous_parcours_suivant = $newsp;
                $this->getEntityManager()->flush();
                $newsp->sous_parcours_suivant = $pass;
                $newTransitionRecommandee->scene_destination = $newScene;
            break;
        }
        $this->getEntityManager()->flush();
        $this->flashMessenger()->addSuccessMessage(sprintf('Le sous-parcours a bien été ajouté'));
        return $this->redirect()->toRoute('parcours/voir', array('id' => $sousparcours->parcours->id));
    }
    
    public function supprimerSousParcoursAction()
    {
    	$id = (int) $this->params()->fromRoute('idsp', 0);
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$id));
    	if ($sous_parcours === null or $id === null) {
    		$this->flashMessenger()->addErrorMessage(sprintf('Erreur : le sous-parcours à supprimer n\'a pas été trouvé'));
    		return $this->getResponse()->setContent(Json::encode(true));
    	}
    	$parcours = $sous_parcours->parcours;
    	if ($parcours->sous_parcours->count() == 1) {
    		$this->flashMessenger()->addErrorMessage(sprintf('Ce sous-parcours ne peut pas être supprimé car c\'est le seul dans le parcours'));
    		return $this->getResponse()->setContent(Json::encode(true));
    	}
    	if ($sous_parcours->scenes->count() != 1) {
    		$this->flashMessenger()->addErrorMessage(sprintf('Un sous-parcours ne peut être supprimé que lorsqu\'il ne contient qu\'une seule scène.'));
    		return $this->getResponse()->setContent(Json::encode(true));
    	}
    	
    	$scene = $sous_parcours->scene_depart;
    	$tr_entrante = $scene->transition_recommandee_entrante;
    	$tr_sortante = $scene->transition_recommandee;
    	$em = $this->getEntityManager();
    	if ($tr_entrante === null) {
    		// C'est le premier sous-parcours du parcours
    		$parcours->sous_parcours_depart = $sous_parcours->sous_parcours_suivant;
    		$tr_sortante->scene_origine = null;
    		$tr_sortante->scene_destination = null;
    		$parcours->transitions->removeElement($tr_sortante);
    		$em->remove($tr_sortante);
    	} elseif ($tr_sortante === null) {
    		// C'est le dernier sous-parcours du parcours
    		$sous_parcours_before = $tr_entrante->scene_origine->sous_parcours;
    		$sous_parcours_before->sous_parcours_suivant = null;
    		$tr_entrante->scene_origine->transition_recommandee = null;
    		$tr_entrante->scene_origine = null;
    		$tr_entrante->scene_destination = null;
    		$parcours->transitions->removeElement($tr_entrante);
    		$em->remove($tr_entrante);
    	} else {
    		// Il est au milieu
    		$sous_parcours_before = $tr_entrante->scene_origine->sous_parcours;
    		$sous_parcours_after = $sous_parcours->sous_parcours_suivant ;
    		$sous_parcours->sous_parcours_suivant = null;
    		$sous_parcours_before->sous_parcours_suivant = $sous_parcours_after;
    		$tr_sortante->scene_origine = $tr_entrante->scene_origine;
    		$tr_entrante->scene_origine->transition_recommandee = $tr_sortante;
    		$tr_entrante->scene_origine = null;
    		$tr_entrante->scene_destination = null;
    		$parcours->transitions->removeElement($tr_entrante);
    		$em->remove($tr_entrante);
    	}
    	$scene->transition_recommandee_entrante = null;
    	$scene->transition_recommandee = null;
    	$scene->sous_parcours = null;
    	$sous_parcours->scenes = null;
    	$sous_parcours->scene_depart = null;
    	$parcours->sous_parcours->removeElement($sous_parcours);
    	try {
    		$em->flush();
    		$em->remove($sous_parcours);
	    	$em->remove($scene);
	    	$em->flush();
    	} catch (\Exception $e) {
    		$this->flashMessenger()->addErrorMessage(sprintf('Erreur lors de la suppression du sous-parcours'));
    		return $this->getResponse()->setContent(Json::encode(true));
    	}
    	$this->flashMessenger()->addSuccessMessage(sprintf('Le sous-parcours a bien été supprimé'));
    	return $this->getResponse()->setContent(Json::encode(true));
    }
    
    public function editSousParcoursAction()
    {
    	$id = (int) $this->params()->fromRoute('idsp', 0);
    	$sous_parcours = $this->getEntityManager()->getRepository('Parcours\Entity\SousParcours')->findOneBy(array('id'=>$id));
    	if (!$id or $sous_parcours === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$request = $this->params()->fromPost();
    	$sous_parcours->titre = $request['value'];
    	$this->getEntityManager()->flush();
    	return $this->getResponse()->setContent(Json::encode(true));
    }
    
    public function changerVisibiliteAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtmlAttr');
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
    	if (!$id or $parcours === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$parcours->public = !$parcours->public;
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('La visibilité du parcours <em>'. $escapeHtml($parcours->titre) .'</em> a bien été changée'));
    	$return = $this->params()->fromRoute('return', 0);
    	if ($return == 'voir') {
    		return $this->redirect()->toRoute('parcours/voir', array('id' => $id));
    	} else {
    		return $this->redirect()->toRoute('parcours');
    	}
    }
    
    public function exportAction() {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtmlAttr');
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
    	if (!$id or $parcours === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$result = array();
    	$result['elements'] = array();
    	$result['transitions'] = array();
    	$result['sous_parcours'] = array();
    	
    	foreach ( $parcours->transitions as $transition) {
    		// Transitions inter-sous-parcours
    		$result['transitions'][$transition->id] = array(
    				'scene_origine'		=> $transition->scene_origine->id,
    				'scene_destination'	=> $transition->scene_destination->id,
    				'semantique'		=> htmlentities($escapeHtml($transition->semantique->semantique)),
    				'narration'			=> htmlentities($escapeHtml($transition->narration))
    		);
    	}
    	foreach ($parcours->sous_parcours as $sous_parcours) {
    		// Sous-parcours
    		$suivant_id = $sous_parcours->sous_parcours_suivant ? $sous_parcours->sous_parcours_suivant->id : null;
    		$result['sous_parcours'][$sous_parcours->id] = array(
    			'scene_depart' 				=> $sous_parcours->scene_depart->id,
    			'sous_parcours_suivant' 	=> $suivant_id,
    			'titre' 					=> $sous_parcours->titre,
    			'scenes_recommandees'		=> array(),
    			'transitions_recommandees'	=> array(),
    			'scenes_secondaires'		=> array(),
    			'transitions_secondaires'	=> array()
    		);
    		foreach ( $sous_parcours->transitions as $transition) {
    			// Transitions
    			if ($transition InstanceOf \Parcours\Entity\TransitionRecommandee) {
    				$result['sous_parcours'][$sous_parcours->id]['transitions_recommandees'][$transition->id] = array(
    					'scene_origine'		=> $transition->scene_origine->id,
    					'scene_destination'	=> $transition->scene_destination->id,
    					'semantique'		=> htmlentities($escapeHtml($transition->semantique->semantique)),
    					'narration'			=> htmlentities($escapeHtml($transition->narration))
    				); 
    			} else {
    				$result['sous_parcours'][$sous_parcours->id]['transitions_secondaires'][$transition->id] = array(
    					'scene_origine'		=> $transition->scene_origine->id,
    					'scene_destination'	=> $transition->scene_destination->id,
    					'semantique'		=> htmlentities($escapeHtml($transition->semantique->semantique)),
    					'narration'			=> htmlentities($escapeHtml($transition->narration))
    				);
    			}

    		}
    		foreach ($sous_parcours->scenes as $scene) {
    			// Scenes
    			if ($scene InstanceOf \Parcours\Entity\SceneRecommandee) {
    				$result['sous_parcours'][$sous_parcours->id]['scenes_recommandees'][$scene->id] = array(
    						'titre'			=>  htmlentities($escapeHtml($scene->titre)),
    						'narration'		=>  htmlentities($escapeHtml($scene->narration)),
    						'elements'		=> array()
    				);
    			} else {
    				$result['sous_parcours'][$sous_parcours->id]['scenes_secondaires'][$scene->id] = array(
    						'titre'			=> htmlentities($escapeHtml( $scene->titre)),
    						'narration'		=> htmlentities($escapeHtml($scene->narration)),
    						'elements'		=> array()
    				);
    			}
    			foreach ($scene->elements as $element) {
    				// Elements
    				if ($scene InstanceOf \Parcours\Entity\SceneRecommandee) {
    					array_push($result['sous_parcours'][$sous_parcours->id]['scenes_recommandees'][$scene->id]['elements'], $element->id);
    				} else {
    					array_push($result['sous_parcours'][$sous_parcours->id]['scenes_secondaires'][$scene->id]['elements'], $element->id);
    				}
    				$result['elements'][$element->id] = array(
    					'titre'			=> htmlentities($escapeHtml($element->titre)),
    					'description'	=> htmlentities($escapeHtml($element->description)),
    					'type'			=> ($element InstanceOf \Collection\Entity\Artefact) ? 'artefact' : 'media',
    					'type_element'	=> htmlentities($escapeHtml($element->type_element->nom)),
    					'datas'			=> array()
    				);
    				foreach ($element->datas as $data) {
    					$result['elements'][$element->id]['datas'][$data->id] = array(
    						'label'		=> htmlentities($escapeHtml($data->champ->label)),
    						'format'	=> htmlentities($escapeHtml($data->champ->format))    						
    					);
    					switch ($data->champ->format) {
    						case 'select':
								$result['elements'][$element->id]['datas'][$data->id]['option'] 
									= ($data->option) ? htmlentities($escapeHtml($data->option->text)) : null;
        						break;
        					case 'texte':
        						$result['elements'][$element->id]['datas'][$data->id]['texte'] 
        							= ($data->texte) ? htmlentities($escapeHtml($data->texte)) : null;
								break;
							case 'textarea':
								$result['elements'][$element->id]['datas'][$data->id]['textarea']
									= ($data->textarea) ? htmlentities($escapeHtml($data->textarea)) : null;
								break;
							break;
							case 'date':
								switch ($data->format) {
									case 2:
										$result['elements'][$element->id]['datas'][$data->id]['date']
											= ($data->date) ? $data->date->format('Y') : null;
										$result['elements'][$element->id]['datas'][$data->id]['format'] = '2';
										break;
									case 1:
										$result['elements'][$element->id]['datas'][$data->id]['date']
											= ($data->date) ? $data->date->format('Y-m') : null;
										$result['elements'][$element->id]['datas'][$data->id]['format'] = '1';
										break;
									default:
										$result['elements'][$element->id]['datas'][$data->id]['date']
											= ($data->date) ? $data->date->format('Y-d-m') : null;
										$result['elements'][$element->id]['datas'][$data->id]['format'] = '0';
										break;
    							}
								break;
							case 'nombre':
								$result['elements'][$element->id]['datas'][$data->id]['nombre']
									= ($data->nombre) ? $data->nombre : null;
								break;
							break;
							case 'fichier':
								$result['elements'][$element->id]['datas'][$data->id]['fichier']
									= ($data->fichier) ? htmlentities($escapeHtml($data->fichier)) : null;
								$result['elements'][$element->id]['datas'][$data->id]['format_fichier']
									= ($data->format_fichier) ? htmlentities($escapeHtml($data->format_fichier)) : null;
								break;
							case 'url':
								$result['elements'][$element->id]['datas'][$data->id]['url']
									= ($data->url) ? htmlentities($escapeHtml($data->url)) : null;
								break;
							break;
							case 'geoposition':
								$result['elements'][$element->id]['datas'][$data->id]['latitude']
									= ($data->latitude) ? $data->latitude : null;
								$result['elements'][$element->id]['datas'][$data->id]['longitude']
									= ($data->longitude) ? $data->longitude : null;
								$result['elements'][$element->id]['datas'][$data->id]['adresse']
									= ($data->adresse) ? htmlentities($escapeHtml($data->adresse)) : null;
								break;
    					}
    				}
    			}
    		}
    	}
    	$view = new ViewModel(array('result'=>$result));
    	$view->setTerminal(true);
    	return $view;
    }
    
}
