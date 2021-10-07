<?php class GroupsController extends AppController
{
	var $name = 'Groups';

	function beforeFilter() 
	{
		 parent::beforeFilter(); 
		 //$this->Auth->allowedActions = array('logout', 'modify_password','ricreaacl', 'add'); 
		 $this->Auth->allow();
		 
	}

	function index() {
        $this->set('groups', $this->Group->find('all'));
    }
	
	function add() {
      if (!empty($this->request->data)) {
      if ($this->Group->save($this->request->data)) {
		$this->Session->setFlash('Your group has been saved.');
		$this->redirect(array('action' => 'index'));
	 }
	}
   }
   
   #This is only temporary and will be removed once we get a few users and groups into our database
	/*function beforeFilter() {
		parent::beforeFilter(); 
		$this->Auth->allowedActions = array('*');
	}*/
}
?>