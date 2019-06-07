<?php 
App::uses('AuthComponent', 'Controller/Component', 'BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email'); // per inviare l'email di pwd dimenticata

class UsersController extends AppController
{
	var $name = 'Users';
	var $components = array('RequestHandler','Auth');
	var $uses = array('User');
    
	// Aggiunto per poter fare il logout di utenti non administrators
	function beforeFilter() 
	{
		 parent::beforeFilter(); 
		 $this->Auth->allowedActions = array('logout','password_dimenticata'); 
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
					$this->Cookie->write('remember_me_cookie', $this->request->data['User'], true, '2 weeks');
				}
				//debug(Configure::read('Role.impiegato'));
				//die();
				if (Auth::hasRole(Configure::read('Role.impiegato')))
				{	        			
							//return $this->redirect(array('controller'=>'pages', 'action'=>'home'));
							return $this->redirect(array('controller'=>'attivita', 'action'=>'index'));
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
				$this->redirect(array('action' => 'index'));
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
			$this->redirect(array('action' => 'index'));
		} else {
			$u = $this->User->findById($uid);
			if (!empty($u) and is_numeric($uid)) {
				$this->set('groups', array_flip(Configure::read('Role')));
				$this->set('persone', ['Nessun contatto associato']+$this->User->Persona->find('list'));
				$this->request->data = $u;
			} else {
				$this->Session->setFlash('ID utente non valido');
				$this->redirect(array('action' => 'index'));
			}
		}
	}

    function delete($id=null)
    {
        $this->User->delete($id);
        $this->Session->setFlash(html_entity_decode("L'utente &egrave; stato cancellato. Esiste ancora come socio, ma non pu&ograve; pi&ugrave; accedere all'applicazione"));
        $this->redirect(array('action'=>'index'));
    }


	function cambiapwd($id=null)
	{	
		if (!empty($this->request->data)) {			
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Password salvata con successo.','index');
			}
		}
		else
		{
			$u = $this->User->findById($id);
		}
		
		if (empty($u) || empty($id))
	{
				$this->Session->setFlash('E\' necessario selezionare un utente a cui cambiare la password');
		$this->redirect(array('action' => 'index'));
	}
	
			$this->request->data = $u;
		}

		public function password_dimenticata() {
		if( !empty($this->request->data) ) {
			$existing_user = $this->User->findByUsername($this->request->data['User']['email']);
			if(empty($existing_user)) {
				$this->Session->setFlash('Utente non trovato!', 'flash_error');
				return;
			}
			// aggiorna la password
			$passwordHasher = new BlowfishPasswordHasher(/*array('hashType' => 'sha256')*/);
			$plainPass = 'massimo,1';
			$existing_user['User']['password'] = $passwordHasher->hash($plainPass);
			if( $this->User->save($existing_user) ) {
				// invia la password via mail
				if(INVIA_MAIL) {
					$Email = new CakeEmail();
					$Email->from(array('info@impronta48.it' => 'iGAS - iMpronta'));
					$Email->to( $this->request->data['User']['email'] );
					$Email->subject('ANBIMA - Password dimenticata');
					$Email->emailFormat('html');
					$Email->template('password_dimenticata', 'default');
					$Email->viewVars(array(
						'plainPassword' => $plainPass,
						'user' => $existing_user['User']
					));
					$Email->send();
				}
				$this->Session->setFlash('Le istruzioni per il recupero password sono state inviate all\'indirizzo email inserito', 'flash_ok_custom');
				$this->redirect( array('action' => 'login') );
			}
			else {
				$this->Session->setFlash('Si è verificato un errore.', 'flash_error_custom');
				return;
			}
		}
	}

}
