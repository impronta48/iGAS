<?php
App::uses('AppController', 'Controller');
/**
 * Righeordini Controller
 *
 * @property Rigaordine $Rigaordine
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RigheordiniController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Rigaordine->recursive = 0;
		$this->set('righeordini', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Rigaordine->exists($id)) {
			throw new NotFoundException(__('Invalid rigaordine'));
		}
		$options = array('conditions' => array('Rigaordine.' . $this->Rigaordine->primaryKey => $id));
		$this->set('rigaordine', $this->Rigaordine->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Rigaordine->create();
			if ($this->Rigaordine->save($this->request->data)) {
				$this->Session->setFlash(__('The rigaordine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rigaordine could not be saved. Please, try again.'));
			}
		}
		$ordini = $this->Rigaordine->Ordine->find('list');
		$this->set(compact('ordini'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Rigaordine->exists($id)) {
			throw new NotFoundException(__('Invalid rigaordine'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Rigaordine->save($this->request->data)) {
				$this->Session->setFlash(__('The rigaordine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rigaordine could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Rigaordine.' . $this->Rigaordine->primaryKey => $id));
			$this->request->data = $this->Rigaordine->find('first', $options);
		}
		$ordini = $this->Rigaordine->Ordine->find('list');
		$this->set(compact('ordini'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Rigaordine->id = $id;
		if (!$this->Rigaordine->exists()) {
			throw new NotFoundException(__('Invalid rigaordine'));
		}		
		if ($this->Rigaordine->delete()) {
			$this->Session->setFlash(__('The rigaordine has been deleted.'));
		} else {
			$this->Session->setFlash(__('The rigaordine could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
