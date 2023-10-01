<?php 
App::uses('AuthComponent', 'Controller/Component', 'BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email'); // per inviare l'email di pwd dimenticata

class UsersController extends AppController
{
	var $name = 'Users';
	var $components = ['RequestHandler','Auth'];
	var $uses = ['User'];
    
	// Aggiunto per poter fare il logout di utenti non administrators
	function beforeFilter() {
		 parent::beforeFilter(); 
		 $this->Auth->allowedActions = ['logout','password_dimenticata']; 
		 //$this->Auth->allow();		 
	}

	function index() {
        $this->set('users', $this->User->find('all'));
        $this->set('role', array_flip(Configure::read('Role')));
    }
	
	function login() {
		$this->layout='nomenu';
		if ($this->request->is('post')) {                             
	        if ($this->Auth->login()) {
				// did they select the remember me checkbox?
				if ($this->request->data['User']['remember_me'] == 1)
				{
					// remove "remember me checkbox"
					unset($this->request->data['User']['remember_me']);

					// hash the user's password
					$this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);

					// write the cookie
					// https://stackoverflow.com/questions/12447487/cakephp-remember-me-with-auth
					$this->Cookie->write('remember_me_cookie', $this->request->data['User'], true, '2 weeks');
				}
				//debug(Configure::read('Role.impiegato'));
				//die();
				if (Auth::hasRole(Configure::read('Role.impiegato')))
				{	        			
					//return $this->redirect(array('controller'=>'pages', 'action'=>'home'));
					return $this->redirect(['controller'=>'attivita', 'action'=>'index']);
				}
				else
				{
					return $this->redirect($this->Auth->redirectUrl());	
				}

			} else {
				$this->Session->setFlash(__('Username or password is incorrect.'));
			}
	            
	    }			    	
	}
		
	function logout() 
	{
		// clear the cookie (if it exists) when logging out
		$this->Cookie->delete('remember_me_cookie');
		
		$this->redirect($this->Auth->logout());
	}
	
	function add() {
		if (!empty($this->request->data)) {
			debug($this->request->data);
			$this->User->create();
			$this->request->data['User']['persona_id'] = ($this->request->data['User']['persona_id'] == 0) ? null : $this->request->data['User']['persona_id'];
			if ($this->User->save($this->request->data)) {                                              
				$this->Session->setFlash('User salvato con successo.');
				$this->redirect(['action' => 'index']);
			}
		} else {
			$this->set('groups', array_flip(Configure::read('Role')));
			$this->set('persone', [null]+$this->User->Persona->find('list'));
		}
	}
		

    //Modifica uno user (in particolare il gruppo e la banca di appartenenza)
    function edit($uid = null){
		if(!empty($this->request->data)){
			$this->request->data['User']['persona_id'] = ($this->request->data['User']['persona_id'] == 0) ? null : $this->request->data['User']['persona_id'];               
			if($this->User->save($this->request->data)) {                                
				$this->Session->setFlash('Utente modificato con successo.'/*,'index'*/);
				//return;
			} else {
				$this->Session->setFlash('Problemi nella modifica dell\'utente');
			}
		}
		if(empty($uid)){
			$this->Session->setFlash('E\' necessario selezionare un utente a cui cambiare le impostazioni'/*,'index'*/);
			$this->redirect(['action' => 'index']);
		} else {
			$u = $this->User->findById($uid);
			if (!empty($u) and is_numeric($uid)) {
				$this->set('groups', array_flip(Configure::read('Role')));
				$this->set('persone', ['Nessun contatto associato']+$this->User->Persona->find('list'));
				$this->request->data = $u;
			} else {
				$this->Session->setFlash('ID utente non valido');
				$this->redirect(['action' => 'index']);
			}
		}
	}

    function delete($id=null)
    {
        $this->User->delete($id);
        $this->Session->setFlash(html_entity_decode("L'utente &egrave; stato cancellato. Esiste ancora come socio, ma non pu&ograve; pi&ugrave; accedere all'applicazione"));
        $this->redirect(['action'=>'index']);
    }


	function cambiapwd($id = null) {	
		if($id and is_numeric($id)){
			$u = $this->User->findById($id);
			$this->set('givenUserId', $id);
			if($u){
				$this->set('givenUserName', $u['User']['username']);
			}
		} else {
			$this->Session->setFlash('Id non valido');
			$this->redirect(['action'=>'cambiapwd', $this->Session->read('Auth.User.id')]); // Forzo il redirect a se stesso per non proseguire nel caricamento pagina e non usare die
		}
		// Solo gli utenti nel gruppo admin sono in grado di modificare le password altrui.
		// Gli utenti che non sono admin possono modificare solo la loro password.
		if(($this->Session->read('Auth.User.id') == $id) or ($this->Session->read('Auth.User.group_id') == 1)){
			if (!empty($this->request->data)) {	
				if(($this->Session->read('Auth.User.group_id') == 1) and ($this->Session->read('Auth.User.id') != $id)){
					// Se sei nel gruppo admin e se stai cercando di modificare password altrui non hai bisogno
					// di sapere la vecchia password. Anche nel caso in cui un admin voglia modificare le pass di altri admin
					$oldPassVerify = true;
				} else {
					// In tutto gli altri casi bisogna sapere la vecchia password.
					// Anche nel caso in cui un admin voglia cambiare la propria password.
					/*
					debug($u['User']['password'] == $this->Auth->password($this->request->data['Users']['vecchia_password']));
					debug($u['User']['password']);
					debug($this->Auth->password($this->request->data['Users']['vecchia_password']));
					die();
					*/
					$oldPassVerify = ($u['User']['password'] == $this->Auth->password($this->request->data['Users']['vecchia_password']));
				}	
				if(($oldPassVerify) and (!empty($this->request->data['Users']['nuova_password'])) and ($this->request->data['Users']['nuova_password'] == $this->request->data['Users']['conferma_password'])){
					$this->request->data['User']['password'] = $this->request->data['Users']['nuova_password'];
				} else {
					$this->Session->setFlash('Le password non combaciano');
					$this->redirect(['action'=>'cambiapwd', $id]); // Forzo il redirect a se stesso per non proseguire nel caricamento pagina e non usare die
				}
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash('Password salvata con successo.');
				}
			}
			if (empty($u)){
				$this->Session->setFlash('E\' necessario selezionare un utente a cui cambiare la password');
				$this->redirect(['action'=>'cambiapwd', $this->Session->read('Auth.User.id')]); // Forzo il redirect a se stesso per non proseguire nel caricamento pagina e non usare die
			} else {
				$this->request->data = $u;
			}
		} else {
			$this->Session->setFlash('Non sei autorizzato a svolgere questa azione');
			$this->redirect(['action'=>'cambiapwd', $this->Session->read('Auth.User.id')]); // Forzo il redirect a se stesso per non proseguire nel caricamento pagina e non usare die
		}
	}

	public function checkResetPass($uid, $token){
		Configure::write('debug', 0);
		$existing_user = $this->User->findById($uid);
		// debug(unserialize(openssl_decrypt($token, 'AES-128-ECB', $existing_user['User']['reset_pass_key']))); // DEBUG
		$tokenArray = @unserialize(openssl_decrypt($token, 'AES-128-ECB', $existing_user['User']['reset_pass_key']));
		if($tokenArray){ // Se non si riesce a decriptare il token vuol dire che qualcuno stà tentando di fare qualcosa
			if($tokenArray['username'] != $existing_user['User']['username']){ // Questo controllo è praticamente inutile
				$this->Session->setFlash('Dati errati', 'flash_error');
				return false;
			}else if(time() - $tokenArray['requestdate'] > 86400){ // Dopo un giorno il link non è più valido
				$this->Session->setFlash('Link reset password scaduto, inviare un altra richiesta di reset', 'flash_error');
				return false;
			}
			$tokenArray['uid'] = $uid;
			return $tokenArray;
		} else {
			$this->Session->setFlash('Impossibile elaborare la richiesta.', 'flash_error');
			return false;
		}
	}

	public function password_dimenticata($setNew = null) {
		Configure::write('debug', 0);
		$this->set('title_for_layout', 'Reset Password');
		if(isset($this->params['url']['eh']) and isset($this->params['url']['no'])){die();}
		$this->layout = 'notlogged';
		$setPassMode = false;
		$this->set('resetPass', $setPassMode);
		$this->set('finalSuccess', false); 
		$this->set('sendSuccess', null); 
		if($setNew and $setNew == 'setnew') { // Controllo se le pass immesse coincidono ed altre cose, poi resetto la password dell'utente
			$this->set('sendSuccess', true); 
			$existing_user = @$this->User->findById($this->request->data['User']['id']);
			if(!empty($this->request->data)) {
				// debug($this->request->data); // DEBUG
				$token = [];
				$token['username'] = $this->request->data['Conferma']['username'];
				$token['securestring'] = $this->request->data['Conferma']['securestring'];
				$token['requestdate'] = (int) $this->request->data['Conferma']['requestdate']; // Questo cast NON è inutile !!!
				$urlToken = urlencode(openssl_encrypt(serialize($token), 'AES-128-ECB', $existing_user['User']['reset_pass_key']));
				// debug(serialize($token)); //DEBUG
				// debug($existing_user['User']['reset_pass_key']); // DEBUG
				// debug(urlencode($this->request->data['Conferma']['requesterToken'])); // DEBUG
				if($existing_user['User']['reset_pass_key'] == NULL or urlencode($this->request->data['Conferma']['requesterToken']) != $urlToken){
					$this->Session->setFlash('Impossibile elaborare la richiesta.', 'flash_error');
					// Se siamo entrati in questo blocco, qualcuno con un token personale funzionante, vuole tentare di modificare le password degli altri
					// Allora lo redirigo in una pagina sbagliata che non porta a niente
					$this->redirect(['controller' => 'users', 'action' => 'password_dimenticata', '?' => 'eh=no&no=badthing']);
					return; // Useless
				}
				if(($this->request->data['User']['password'] === $this->request->data['Conferma']['password']) and (strlen($this->request->data['User']['password']) >= 5)){
					// debug('Le pass coincidono'); // DEBUG
					$this->User->save(['id' => $this->request->data['User']['id'], 'password' => $this->request->data['User']['password'], 'reset_pass_key' => NULL]);
					$this->Session->setFlash('Password modificata con successo.');
					$this->set('finalSuccess', true); 
				} else {
					$this->Session->setFlash('Le password inserite non combaciano', 'flash_error');
					$this->redirect(['controller' => 'users', 'action' => 'password_dimenticata', '?' => 'uid='.$this->request->data['User']['id'].'&token='.$urlToken]);
				}
			}
			return;
		}
		if(isset($this->params['url']['uid']) and isset($this->params['url']['token'])){
			$setPassMode = $this->checkResetPass($this->params['url']['uid'], $this->params['url']['token']);
			if($setPassMode == false){
				$this->set('sendSuccess', true);
				return;
			}
		}
		$this->set('resetPass', $setPassMode);
		if(!empty($this->request->data) and $setPassMode == false) {
			$existing_user = $this->User->findByUsername($this->request->data['User']['username']);
			if(empty($existing_user)) {
				$this->Session->setFlash('Utente non trovato!', 'flash_error');
				return;
			} else if(empty($existing_user['Persona']['EMail'])) {
				$this->Session->setFlash('L\'utente selezionato non ha una mail associata, impossibile inviare la mail di recupero password', 'flash_error');
				return;
			}
			// debug($existing_user); // DEBUG
			$token = [];
			$token['username'] = $existing_user['User']['username'];
			$token['securestring'] = bin2hex(random_bytes(32));
			$token['requestdate'] = time();
			$secureKey = uniqid('');
			$urlToken = urlencode(openssl_encrypt(serialize($token), 'AES-128-ECB', $secureKey));
			// debug($urlToken); //DEBUG
			// debug(openssl_decrypt(urldecode($urlToken), 'AES-128-ECB', $secureKey)); // DEBUG
			if($this->User->save(['id' => $existing_user['User']['id'], 'reset_pass_key' => $secureKey])) {
				$Email = new CakeEmail();
				$Email->from(['info@impronta48.it' => 'iGAS - iMpronta']);
				$Email->to($existing_user['Persona']['EMail']);
				$Email->subject('iGAS - Password dimenticata');
				$Email->emailFormat('html');
				$Email->template('password_dimenticata', 'default');
				$Email->viewVars([
					'urlToken' => $urlToken,
					'userId' => $existing_user['User']['id'],
					'user' => $existing_user['User']['username']
				]);
				$Email->send();
				$this->Session->setFlash('Le istruzioni per il recupero password sono state inviate all\'indirizzo email dell\'utente inserito');
				$this->set('sendSuccess', true);
			} else {
				$this->Session->setFlash('Si è verificato un errore.', 'flash_error');
				$this->set('sendSuccess', false);
				return;
			}
		} else {
			$this->set('sendSuccess', false);
		}
	}

}
