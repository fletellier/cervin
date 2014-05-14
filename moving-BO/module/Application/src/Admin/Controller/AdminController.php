<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use SamUser\Entity\User;
use SamUser\Entity\Role;
use Zend\Mvc\Controller\Plugin\Url;
use Zend\Json\Json;
use Admin\Form\UserForm;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;

class AdminController extends AbstractActionController
{    

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    /**
     * Return a EntityManager
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

    ///////////////////////////////////////////////////////////////////////////
    public function indexAction()
    {
        return $this->redirect()->toRoute('page');
    }
    ///////////////////////////////////////////////////////////////////////////
    
    /**
     * Affiche le tableau de gestion des utilisateurs
     **/
    public function editusersAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');
		if ($this->getRequest()->isXmlHttpRequest()) {
            $params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('SamUser\Entity\User');
        
            $dataTable = new \Admin\Model\UserDataTable($params);
            $dataTable->setEntityManager($entityManager);
            
            $dataTable->setConfiguration(array(
                'username',
                'displayName',
                'email',
                'roleId'
            ));

            $aaData = array();

            foreach ($dataTable->getPaginator() as $user) {

	            if(!isset( $user->roles['0']) )
	            {
	                $role = 'null';
	                $roleId = null;
	            } else {
	                $role = $user->roles['0']->getRoleId();
	                $roleId = $user->roles['0']->getId();
	            }
	            
	            $info_date = '<a href="#"
	                            class="Info"
	                            data-toggle="popover"
	                			data-html="true"
	                            data-content="
	                			Dernière connexion : '.(($user->derniereConnexion) ? $user->derniereConnexion->format('Y-m-d à H:i') : 'N/A').'<br/>
	                            Date de création : '.(($user->created) ? $user->created->format('Y-m-d à H:i') : 'N/A').'">
	                                <i class="icon-time"></i>
	                            </a>';
	            
	            $btn_supprimer = "";
	            if ($user->id != $this->zfcUserAuthentication()->getIdentity()->getId()) {
	            	$btn_supprimer = '<a href="#"
		            			data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'"
		            			data-value="'.$user->username.'"
		            			class="btn btn-danger SupprimerUser"
		            			data-toggle="popover"
		            			data-content="L\'utilisateur sera supprimé de la base de données"
		            			data-title="Supprimer l\'utilisateur">
		            				<i class="icon-trash"></i>
		            			</a>';
	            }
	            
	            
	            // UTILISATEUR ACTIF
	            if( $user->state ) {

	                if($user->attenteRole === null )
	                {
	                    $attenteRole = '';
	                    $attenteRoleDataOriginalTitle = '';
	                } else {
	                	$attenteRole = '<span class="text-error">
	                    	<i class="icon-comment"></i></span>';
	 					$attenteRoleDataOriginalTitle = ' data-html="true" data-original-title="Demande le droit :<b>
	 						'.$user->attenteRole->getRoleId().'</b>  
	 						<a href=\'#\' class=\'refueRole btn btn-mini btn-danger\' 
	 						data-url=\''.$this->url()->fromRoute("admin/refueRole", array("id" => $user->id)).'\'>
	 						<i class=\'icon-remove\'></i> Refuser</a>"';
	                }
					
					$editable_role      = "";
		            $btn_reset_password = "";
		            $btn_desactiver      = "";
					
		            if ($user->id != $this->zfcUserAuthentication()->getIdentity()->getId()) {
		            	$editable_role = '<span
		                        id="role"
		                        class="status CursorPointer"
		                        data-type="select"
		                        data-pk="'. $user->id.'"
		                        '.$attenteRoleDataOriginalTitle.'
		                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'"
		                        data-value="'.$roleId.'">
		                            '.$role.' '.$attenteRole.'
		                    	</span>';
		            	$btn_desactiver = '<a href="#" 
		            			data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
		            			data-value="'.$user->username.'" 
		            			class="btn btn-danger DesactiverUser"
		            			data-toggle="popover"
		            			data-content="L\'utilisateur sera désactivé et ne pourra plus se loguer. Ses coordonnées seront conservées en base."
		            			data-title="Désactiver l\'utilisateur">
		            				<i class="icon-lock"></i>
		            			</a>';
		            	$btn_reset_password = '<a href="#" 
		            			data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
		            			data-value="'.$user->username.'" 
		            			class="btn btn-primary ResetPassword"
		            			data-toggle="popover"
		            			data-content="Un nouveau mot de passe sera généré et envoyé par mail"
		            			data-title="Réinitialiser le mot de passe de l\'utilisateur">
		            				<i class="icon-key"></i>
		            			</a>';
		            } else {
		            	$editable_role = ' <span id="role" > '.$role.' </span> ';
		            }
	
	                $aaData[] = array(
	                    '<span id="username" 
	                        class="text CursorPointer" 
	                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->username).'" data-placement="right" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->username).'
	                    </span>',
	                		
	                    '<span id="displayName" 
	                        class="text CursorPointer" 
	                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->displayName).'" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->displayName).'
	                    </span>',
	                		
	                    '<span id="email" 
	                        class="text CursorPointer" 
	                        data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->email).'" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->email).'
	                    </span>',
	                		
	                    '<span id="telephone" class="text CursorPointer" 
	                		data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->telephone).'" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->telephone).'</span>',
	                		
	                    '<span id="adresse" class="text CursorPointer" 
	                		data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->adresse).'" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->adresse).'</span><br/>
	                	 <span id="code_postal" class="text CursorPointer" 
	                		data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->code_postal).'" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->code_postal).'</span>&nbsp;
	                	 <span id="ville" class="text CursorPointer" 
	                		data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->ville).'" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->ville).' </span><br/>
	                	 <span id="pays" class="text CursorPointer" 
	                		data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'" 
	                        data-value="'.$escapeHtml($user->pays).'" data-type="text" data-pk="1"
	                		>'.$escapeHtml($user->pays).' </span>',
	                		
	                    $editable_role,
	                		
	                	'<div class="pull-left">'.$btn_desactiver.$btn_supprimer.$btn_reset_password.'</div>		
	                	<div class="pull-right">'.$info_date.'</div>',
	                	
	                );
	                
	            // UTILISATEUR DESACTIVE
            	} else {
            		$btn_reactiver = '<a href="#"
		            			data-url="'.$this->url()->fromRoute("admin/changeUserAjax", array("id" => $user->id)).'"
		            			data-value="'.$user->username.'"
		            			class="btn btn-danger ReactiverUser"
		            			data-toggle="popover"
		            			data-content="L\'utilisateur sera réactivé"
		            			data-title="Réactiver l\'utilisateur">
		            				<i class="icon-unlock"></i>
		            			</a>';
            		$aaData[] = array(
            				'<p class="muted">'.$escapeHtml($user->username).'</p>',
            				'<p class="muted">'.$escapeHtml($user->displayName).'</p>',
            				'<p class="muted">'.$escapeHtml($user->email).'</p>',
            				'<p class="muted">'.$escapeHtml($user->telephone).'</p>',
            				'<p class="muted">'.
            					$escapeHtml($user->adresse).'<br/>'.
            					$escapeHtml($user->code_postal).' '.$escapeHtml($user->ville).'<br/>'.
            					$escapeHtml($user->pays).
            				'</p>',
							'<p class="muted">'.$escapeHtml($role).'</p>',
            				'<div class="pull-left">'.$btn_reactiver.$btn_supprimer.'</div>
	                		<div class="pull-right">'.$info_date.'</div>',
            		);
            	}
            }
            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
        } else {
            return new ViewModel(array(
                'roles' => $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findAll()
            ));

        }
    }
    
    /**
     * Permets de modifier les informations des utilisateurs via Ajax
     **/
    public function changeUserAjaxAction()
    {
        if ($this->getRequest()->isXmlHttpRequest())
        {
            $postData = $this->params()->fromPost();

            $id = (int) $this->params()->fromRoute('id', 0);
            
            if (!$id) {
                //return $this->redirect()->toRoute('');
                return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Pas d'id spécifié en paramètre")));
            }
            
			$user = null;
			
            try {
                $user = $this->getEntityManager()->find('SamUser\Entity\User', $id);
            }
            catch (\Exception $ex) {
                //return $this->redirect()->toRoute('');
                return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Impossible de trouver l'utilisateur")));
            }

            if ($postData['name'] == 'username')
            {

            	try {
            		$user->setUsername($postData['value']);
               		$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le login a été mis à jour")));

            }
            elseif ($postData['name'] == 'displayName')
            {

            	try {
            		$user->setDisplayName($postData['value']);
            		$this->getEntityManager()->persist($user);
            		$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le nom d'utilisateur a été mis à jour")));

            }
            elseif ($postData['name'] == 'email')
            {
            	$validator = new \Zend\Validator\EmailAddress();
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "L'email est invalide")));
            	}
            		
            	try {
            		$user->setEmail($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'email a été mis à jour")));

            } 
            elseif ($postData['name'] == 'telephone')
            {
            	$validator = new \Zend\Validator\Regex('#^0[1-68]([-. ]?\d{2}){4}$#');
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le numéro de téléphone est invalide")));
            	}
            		
            	try {
            		$user->setTelephone($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le numéro de téléphone a été mis à jour")));

            } 
            elseif ($postData['name'] == 'adresse')
            {
            	$validator = new \Zend\Validator\StringLength(array( 'min' => 5, 'max' => 255 ));
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "L'adresse est invalide")));
            	}
            		
            	try {
            		$user->setAdresse($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'adresse a été mis à jour")));

            } 
            elseif ($postData['name'] == 'code_postal')
            {
            	//$validator = new \Zend\Validator\PostCode('fr_FR');
            	$validator = new \Zend\Validator\Regex('#^(([0-8][0-9])|(9[0-5]))[0-9]{3}$#');
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le code postal est invalide")));
            	}
            		
            	try {
            		$user->setCodePostal($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le code postal a été mis à jour")));

            }
            elseif ($postData['name'] == 'ville')
            {
            	$validator = new \Zend\Validator\StringLength(array( 'min' => 1, 'max' => 255 ));
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le nom de la ville est invalide")));
            	}
            		
            	try {
            		$user->setVille($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le nom de la ville a été mis à jour")));

            }
            elseif ($postData['name'] == 'pays')
            {
            	$validator = new \Zend\Validator\StringLength(array( 'min' => 1, 'max' => 255 ));
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le nom du pays est invalide")));
            	}
            		
            	try {
            		$user->setPays($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le nom du pays a été mis à jour")));

            }
            elseif ($postData['name'] == 'password')
            {
            	try {
            		$bcrypt = new Bcrypt;
	            	$bcrypt->setCost(14);
	            	
	            	//On génère un mot de passe aléatoire
	            	$password = $this->getEntityManager()->getRepository('SamUser\Entity\User')->generateRandomPassword();
	            	
	            	//On hash le mot de passe avec bcrypt puis on l'enregistre
	            	$user->setPassword( $bcrypt->create( $password ) );
	
	            	//On persiste les données en base de donnée
	                $this->getEntityManager()->persist($user);
	                $this->getEntityManager()->flush();
	                
	                //var_dump($password);
	                //var_dump($user->getPassword());
	
	                //On envoie un mail contenant le nouveau mot de passe
	                $message = new Message();
	                $message->addTo( $user->getEmail() )
			                ->addFrom('no-reply@cervin.org')
			                ->setSubject('Mot de passe réinitialisé')
			                ->setBody("Bonjour,\r\n\r\n Votre mot de passe a été réinitialisé. \r\n Votre nouveau mot de passe est ".$password." . \r\n\r\n Bonne journée! ")
			                ->setEncoding("UTF-8");
	                
	                $transport = new SendmailTransport();
	                $transport->send($message);
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le mot de passe a été réinitialisé")));

            } 
            elseif ($postData['name'] == 'role')
            {

                try {
                    $role = $this->getEntityManager()->find('SamUser\Entity\Role', $postData['value']);
                }
                catch (\Exception $ex) {
                    //return $this->redirect()->toRoute('');
                	return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Impossible de trouver le role")));
                }
                
                if($user->attenteRole != null ){
                    $user->setAttenteRole(null);
                }
                
                $user->removeRoles($user->getRoles());
                $user->addRole($role);

                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();


                //$entityManager = $this->getEntityManager()->getRepository('SamUser\Entity\Role');
                //$this->getRequest()->getPost('value');
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le role a été mis à jour")));

            }
            elseif ($postData['name'] == 'desactiver')
            {
            	try {
            		//$this->getEntityManager()->remove($user);
                    $role = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findOneBy(array('roleId'=>'Visiteur'));
                    
                    $user->removeRoles($user->getRoles());
                    $user->addRole($role);
                    $user->setState(0);

                    $this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		//return $this->redirect()->toRoute('page');
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'utilisateur a été désactivé")));

            }
            elseif ($postData['name'] == 'reactiver')
            {
            	try {
            		$role = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findOneBy(array('roleId'=>'Utilisateur'));
            		$user->removeRoles($user->getRoles());
            		$user->addRole($role);
            		$user->setState(1);
            
            		$this->getEntityManager()->persist($user);
            		$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		//return $this->redirect()->toRoute('page');
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
            
            	return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'utilisateur a été désactivé")));
            
            }
            elseif ($postData['name'] == 'supprimer')
            {
            	try {
            		$this->getEntityManager()->remove($user);
            		$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
            	return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'utilisateur a été supprimé")));
            
            }
           
        } else {
            $this->getResponse()->setStatusCode(404);
			return;
        }
    }
    
    
    /**
     * Permet à l'utilisateur de modifier ses propres données en AJAX
     **/
    public function changeProfileInfosAjaxAction()
    {
        if ($this->getRequest()->isXmlHttpRequest())
        {
        
            $postData = $this->params()->fromPost();

            $id = (int) $this->zfcUserAuthentication()->getIdentity()->getId();
            
            if (!$id) {
                //return $this->redirect()->toRoute('');
                return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Pas d'id spécifié en paramètre")));
            }
            
			$user = $this->zfcUserAuthentication()->getIdentity();
			
            if ($postData['name'] == 'username')
            {

            	try {
            		$user->setUsername($postData['value']);
               		$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le login a été mis à jour")));

            }
            elseif ($postData['name'] == 'displayName')
            {

            	try {
            		$user->setDisplayName($postData['value']);
            		$this->getEntityManager()->persist($user);
            		$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}

                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le nom d'utilisateur a été mis à jour")));

            }
            elseif ($postData['name'] == 'email')
            {
            	$validator = new \Zend\Validator\EmailAddress();
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "L'email est invalide")));
            	}
            		
            	try {
            		$user->setEmail($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'email a été mis à jour")));

            } 
            elseif ($postData['name'] == 'telephone')
            {
            	$validator = new \Zend\Validator\Regex('#^0[1-68]([-. ]?\d{2}){4}$#');
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le numéro de téléphone est invalide")));
            	}
            		
            	try {
            		$user->setTelephone($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le numéro de téléphone a été mis à jour")));

            } 
            elseif ($postData['name'] == 'adresse')
            {
            	$validator = new \Zend\Validator\StringLength(array( 'min' => 5, 'max' => 255 ));
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "L'adresse est invalide")));
            	}
            		
            	try {
            		$user->setAdresse($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'adresse a été mis à jour")));

            } 
            elseif ($postData['name'] == 'code_postal')
            {
            	//$validator = new \Zend\Validator\PostCode('fr_FR');
            	$validator = new \Zend\Validator\Regex('#^(([0-8][0-9])|(9[0-5]))[0-9]{3}$#');
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le code postal est invalide")));
            	}
            		
            	try {
            		$user->setCodePostal($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le code postal a été mis à jour")));

            }
            elseif ($postData['name'] == 'ville')
            {
            	$validator = new \Zend\Validator\StringLength(array( 'min' => 1, 'max' => 255 ));
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le nom de la ville est invalide")));
            	}
            		
            	try {
            		$user->setVille($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le nom de la ville a été mis à jour")));

            }
            elseif ($postData['name'] == 'pays')
            {
            	$validator = new \Zend\Validator\StringLength(array( 'min' => 1, 'max' => 255 ));
            	
            	if (!$validator->isValid($postData['value'])) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Le nom du pays est invalide")));
            	}
            		
            	try {
            		$user->setPays($postData['value']);
                	$this->getEntityManager()->persist($user);
                	$this->getEntityManager()->flush();
            	}
            	catch (\Exception $ex) {
            		return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            	}
                
                return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "Le nom du pays a été mis à jour")));

            }
           
        } else {
            $this->getResponse()->setStatusCode(404);
			return;
        }
    }
    
    /**
     * Droit : Utilisateur
     * Set AttenteRole avec la valeur du role demandee
     **/
    public function demandeRoleAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        try {
            $role = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findOneBy(array('id'=>$id));
            $user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$this->zfcUserAuthentication()->getIdentity()->getId()));
        
        }
        catch (\Exception $ex) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if($role === null and $user === null){
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->flashMessenger()->addSuccessMessage(sprintf('La demande de droits "%1$s" a bien été prise en compte.', $role->getRoleId()));

        $user->setAttenteRole($role);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $this->redirect()->toRoute('zfcuser');


    }
    
    /**
     * Permet a l'admin de supprimer la demande de role 
     **/
    public function refueRoleAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $user = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('id'=>$id));
        if($user === null){
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if($user->attenteRole != null ){

            $user->setAttenteRole(null);
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return $this->getResponse()->setContent(Json::encode(true));
        }
         return $this->getResponse()->setContent(Json::encode(false));

    }

    /**
     * Permet a l'admin de voir un journal des modifications apportées au backoffice
     **/
    public function showLogsAction()
    {
        $viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
        $escapeHtml = $viewHelperManager->get('escapeHtml');

        if ($this->getRequest()->isXmlHttpRequest()) {
            $params = $this->params()->fromQuery();
    
            $entityManager = $this->getEntityManager()
                ->getRepository('Gedmo\Loggable\Entity\LogEntry');
        
            $dataTable = new \Admin\Model\LogsDataTable($params);
            $dataTable->setEntityManager($entityManager);
            
            $dataTable->setConfiguration(array(
                'loggedAt',
                'action',
                'objectClass',
                'objectId',
                'version',
                'username'
            ));

            $aaData = array();
            
            $paginator = null;
            
            if(isset($params["conditions"])){
                $conditions = json_decode($params["conditions"], true);
                $paginator = $dataTable->getPaginator($conditions);
            } else {
                $paginator = $dataTable->getPaginator();
            }
                
            foreach ($dataTable->getPaginator() as $log) {

            	$datasModified = "";
            	$revertButton  = "";

            	if ($log->getAction() != 'remove') {

	                $revertButton = '<a href="#" 
	                    data-url="'.$this->url()->fromRoute("admin/revert-object").'"
	                    data-version="'.$escapeHtml($log->getVersion()).'"
	                    data-object="'.$escapeHtml($log->getObjectClass()).'"
	                    data-id="'.$escapeHtml($log->getObjectId()).'"
	                    class="btn btn-danger revertObject popoverTop"
	                    data-toggle="popover"
	                    data-content="Revenir à cette version">
	                        <i class="icon-undo"></i>
	                </a>';
	
	                $popoverDatasModified = null;
					
	                if ($log->getData()) {

		                foreach($log->getData() as $name => $data){
		                    if(is_array($data) || is_object($data)){ $data = json_encode($data); }

                            if(strlen($data) > 30){ $data = $this->truncate( $data, 30, ' ...', true, true ); }

		                    $popoverDatasModified .= $escapeHtml(ucfirst($name))." : '".$escapeHtml($data)."'<br/>";
		                }
	                
	                	//$popoverDatasModified = str_replace("\"", "'", $popoverDatasModified);
	                }

	                $datasModified = '<a href="#"
	                                class="InfoObject popoverLeft"
	                                data-toggle="popover"
	                                data-html="true"
	                                data-content="'.$popoverDatasModified.'"
	                                data-title="Donnée(s) modifiée(s)"
                                    data-data="'.$escapeHtml(json_encode($log->getData())).'"
                                    >
	                                    <i class="icon-copy"></i>
	                                </a>';
                }

                $action = '<div class="pull-left">'.$revertButton.'</div><div class="pull-right">'.$datasModified.'</div>';

                $aaData[] = array(
                        $escapeHtml($log->getLoggedAt()->format('Y-m-d H:i:s')),
                        $escapeHtml($log->getAction()),
                        $escapeHtml($log->getObjectClass()),
                        $escapeHtml($log->getObjectId()),
                        $escapeHtml($log->getVersion()),
                        $escapeHtml($log->getUsername()),
                        $action
                );
            }

            $dataTable->setAaData($aaData);
            
            return $this->getResponse()->setContent($dataTable->findAll());
        } else {

            $em                = $this->getEntityManager();

            $queryActions      = $em->createQuery('SELECT DISTINCT l.action FROM Gedmo\Loggable\Entity\LogEntry l');
            $selectActions     = $queryActions->getResult();

            $queryObjectClass  = $em->createQuery('SELECT DISTINCT l.objectClass FROM Gedmo\Loggable\Entity\LogEntry l');
            $selectObjectClass = $queryObjectClass->getResult();

            $queryUsers        = $em->createQuery('SELECT DISTINCT l.username FROM Gedmo\Loggable\Entity\LogEntry l');
            $selectUsers       = $queryUsers->getResult();

            return new ViewModel( array( "selectObjectClass" => $selectObjectClass, "selectUsers" => $selectUsers, "selectActions" => $selectActions ) );
        }
    }

    public function RevertObjectAjaxAction(){
        if ($this->getRequest()->isXmlHttpRequest()){

            $postData      = $this->params()->fromPost();

            $objectId      = $postData['objectId'];
            $objectClass   = $postData['objectClass'];
            $objectVersion = $postData['version'];

            $em            = $this->getEntityManager();

            $query = $em->createQueryBuilder()
                        ->select('MAX(l.version)')
                        ->from('Gedmo\Loggable\Entity\LogEntry', 'l')
                        ->where('l.objectId = :objectId')
                        ->andWhere('l.objectClass = :objectClass') 
                        ->setParameters(array( 'objectId' => $objectId, 'objectClass' => $objectClass ));

            $lastVersionNumber = $query->getQuery()->getSingleResult();

            if( $lastVersionNumber[1] == $objectVersion || $lastVersionNumber[1] < $objectVersion ){ 
                return $this->getResponse()->setContent(
                    Json::encode(array( "status" => 'error', "message" => "L'object est déjà à la dernière version"))
                ); 
            }

            try {
                $repo    = $em  ->getRepository('Gedmo\Loggable\Entity\LogEntry'); 
                $object  = $em  ->find($objectClass, $objectId);
                $logs    = $repo->getLogEntries($object);

                $repo->revert($object, $objectVersion);
                $em  ->persist($object);
                $em  ->flush();
            }
            catch (\Exception $ex) {
                return $this->getResponse()->setContent(Json::encode(array( "status" => "error", "message" => "Une erreur est survenue")));
            }
                
            return $this->getResponse()->setContent(Json::encode(array( "status" => true, "message" => "L'object est revenu à une version précédente")));

        } else {
            $this->getResponse()->setStatusCode(404);
            return;
        }
    }
    
    public function AjouterUtilisateurAction(){
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml        = $viewHelperManager->get('escapeHtml');
    	$form              = new UserForm();
    	$user              = new \SamUser\Entity\User();
    	$request           = $this->getRequest();
    	$form->bind($user);
    	
    	if ($request->isPost()) {
    	
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			
    			$username  = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('username'=>$user->getUsername()));
    			//$email     = $this->getEntityManager()->getRepository('SamUser\Entity\User')->findOneBy(array('email'=>$user->getEmail()));

    			if($username !== null || $email !== null ){
    				
    				if($username  !== null){ $this->flashMessenger()->addErrorMessage("Le nom d'utilisateur est déjà utilisé"); }
    				//if($email     !== null){ $this->flashMessenger()->addErrorMessage("L'email est déjà utilisé"); }

    				return $this->redirect()->toRoute('admin/ajouter-utilisateur');
    			}

    			try {
    				$bcrypt = new Bcrypt;
    				$bcrypt->setCost(14);
    				
    				//On génère un mot de passe aléatoire
    				$password = $this->getEntityManager()->getRepository('SamUser\Entity\User')->generateRandomPassword();
    			
    				//On hash le mot de passe avec bcrypt puis on l'enregistre
    				$user->setPassword( $bcrypt->create( $password ) );
    			 
                    //On ajoute la date de création de l'utilisateur
                    //$user->setCreated( new \DateTime('NOW') );

                    //On "active" l'utilisateur
                    $user->setState(1);
        			
                    //On récupère le role 'Utilisateur'
    				$role = $this->getEntityManager()->getRepository('SamUser\Entity\Role')->findOneBy(array('roleId'=>'Utilisateur'));
    				
    				//Et on l'ajoute à l'utilisateur
    				$user->addRole($role);
    			 } catch (\Exception $ex) {
                    $this->flashMessenger()->addErrorMessage("Une erreur est survenue durant la création de l'utilisateur");
                    //$this->flashMessenger()->addErrorMessage($escapeHtml($ex->getMessage()));
                    return $this->redirect()->toRoute('admin/ajouter-utilisateur');
                }

                try {
    				//On persiste les données en base de donnée
    				$this->getEntityManager()->persist($user);
    				$this->getEntityManager()->flush();
    				
                } catch (\Exception $ex) {
                    $this->flashMessenger()->addErrorMessage("Une erreur est survenue durant l'insertion en base de donnée");
                    //$this->flashMessenger()->addErrorMessage($escapeHtml($ex->getMessage()));
                    return $this->redirect()->toRoute('admin/ajouter-utilisateur');
                }

                try {
    				//On envoie un mail contenant le nouveau mot de passe
    				$message = new Message();
    				$message->addTo( $user->getEmail() )
    				->addFrom('no-reply@cervin.org')
    				->setSubject('Compte CERVIN créé')
    				->setBody("Bonjour ".$user->getDisplayName().", \r\n\r\n 
Votre compte sur le site http://moving-bo.cervin.org/ a été créé. \r\n
Vos identifiants de connexion sont les suivants : \r\n\r\n 
Login : ".$user->getUsername()." \r\n
Mot de passe : ".$password." \r\n\r\n 
Bonne journée! ")
    				->setEncoding("UTF-8");
    				 
    				$transport = new SendmailTransport();
    				$transport->send($message);
                } catch (\Exception $ex) {
                    $this->flashMessenger()->addErrorMessage("Une erreur est survenue durant l'envoi du mail");
                    //$this->flashMessenger()->addErrorMessage($escapeHtml($ex->getMessage()));
                    return $this->redirect()->toRoute('admin/ajouter-utilisateur');
                }
    			
    			$this->flashMessenger()->addSuccessMessage(sprintf('L\'utilisateur %1$s a bien été créé.', $escapeHtml($user->getDisplayName())));
    			return $this->redirect()->toRoute('admin/gestion-users');
    		}
    	
    	}
    	return new ViewModel(array('form'=>$form));
    }


    /**
     * Truncates text.
     *
     * Cuts a string to the length of $length and replaces the last characters
     * with the ending if the text is longer than length.
     * Crédit : http://www.ycerdan.fr/php/tronquer-un-texte-en-conservant-les-tags-html-en-php/
     *
     * @param string  $text String to truncate.
     * @param integer $length Length of returned string, including ellipsis.
     * @param mixed $ending If string, will be used as Ending and appended to the trimmed string. Can also be an associative array that can contain the last three params of this method.
     * @param boolean $exact If false, $text will not be cut mid-word
     * @param boolean $considerHtml If true, HTML tags would be handled correctly
     * @return string Trimmed string.
     */
    private function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
        if (is_array($ending)) {
            extract($ending);
        }
        if ($considerHtml) {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            $totalLength = mb_strlen($ending);
            $openTags = array();
            $truncate = '';
            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];
    
                $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }
    
                    $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
    
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - strlen($ending));
            }
        }
        
        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($considerHtml) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if (!empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if (!in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
    
        $truncate .= $ending;
    
        if ($considerHtml) {
            foreach ($openTags as $tag) {
                $truncate .= '</'.$tag.'>';
            }
        }
    
        return $truncate;
    }

}
