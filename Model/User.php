<?php 
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel{
	var $name = 'User';
	var $belongsTo = array('Persona');

	//Hash della pwd prima di salvare
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] =  AuthComponent::password($this->data[$this->alias]['password']);                
		}
		//Se sto cambiando a pwd allora è valorizzata nuova_pwd!
		if (isset($this->data[$this->alias]['nuova_password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['nuova_password']);
		}       
	}
}
