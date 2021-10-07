<?php
App::uses('AppController', 'Controller');

class ProgettiController extends AppController {

	var $name = 'Progetti';

	function index() {
		$this->Progetto->recursive = 0;
		$this->set('progetti', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid progetto'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('progetto', $this->Progetto->read(null, $id));
	}
	
	function edit($id = null) {
        if (!$id && !empty($this->request->data)) {
            $this->Progetto->create();
        }

		if (!empty($this->request->data)) {
			if ($this->Progetto->save($this->request->data)) {
				$this->Session->setFlash(__('The progetto has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The progetto could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
            $aree = $this->Progetto->Area->find('list',array('cache' => 'area', 'cacheConfig' => 'short'));
            $this->set(compact('aree'));
			$this->request->data = $this->Progetto->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for progetto'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Progetto->delete($id)) {
			$this->Session->setFlash(__('Progetto deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Progetto was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
    
    function autocomplete()
	{   
        $data = array();
        if (isset($this->request->query['term']))
        {
            $data= $this->Progetto->find('all', array(
                    'conditions' => array(
                    'progetto.name LIKE' => '%'.$this->request->query['term'].'%'
                    ),
                    'limit' => 50,
                    'fields' => array('id', 'name'),
                ));
        }
        
		$res = array();
		
		foreach ($data as $d)
		{
			$a = new StdClass();
			$a->id = $d['Progetto']['id'];
			//$a->label = $d['Libro']['titolo'];
			$a->value = $d['Progetto']['name'];
			$res[] = $a;
		}
		$this->layout = 'ajax';
		$this->autoLayout = false;
        $this->autoRender = false; 
		
		$this->header('Content-Type: application/json');
		echo json_encode($res); 
		exit();
	}
}
?>