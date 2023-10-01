<?php
App::uses('AppController', 'Controller');

class AreeController extends AppController {

	var $name = 'Aree';

	function index() {               
		$this->Area->recursive = 0;
		$this->set('aree', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid area'));
			$this->redirect(['action' => 'index']);
		}
		$this->set('area', $this->Area->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Area->create();
			if ($this->Area->save($this->request->data)) {
				$this->Session->setFlash(__('The area has been saved'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The area could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid area'));
			$this->redirect(['action' => 'index']);
		}
		if (!empty($this->request->data)) {
			if ($this->Area->save($this->request->data)) {
				$this->Session->setFlash(__('The area has been saved'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The area could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Area->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for area'));
			$this->redirect(['action'=>'index']);
		}
		if ($this->Area->delete($id)) {
			$this->Session->setFlash(__('Area deleted'));
			$this->redirect(['action'=>'index']);
		}
		$this->Session->setFlash(__('Area was not deleted'));
		$this->redirect(['action' => 'index']);
	}
}
?>