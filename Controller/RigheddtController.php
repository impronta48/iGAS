<?php
App::uses('AppController', 'Controller');
/**
 * Righeddt Controller
 *
 * @property Rigaddt $Rigaddt
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RigheddtController extends AppController {

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
		$this->Rigaddt->recursive = 0;
		$this->set('righeddt', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Rigaddt->exists($id)) {
			throw new NotFoundException(__('Invalid rigaddt'));
		}
		$options = array('conditions' => array('Rigaddt.' . $this->Rigaddt->primaryKey => $id));
		$this->set('rigaddt', $this->Rigaddt->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Rigaddt->create();
			if ($this->Rigaddt->save($this->request->data)) {
				$this->Session->setFlash(__('The rigaddt has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rigaddt could not be saved. Please, try again.'));
			}
		}
		$ddt = $this->Rigaddt->Ddt->find('list');
		$this->set(compact('ddt'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Rigaddt->exists($id)) {
			throw new NotFoundException(__('Invalid rigaddt'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Rigaddt->save($this->request->data)) {
				$this->Session->setFlash(__('The rigaddt has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rigaddt could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Rigaddt.' . $this->Rigaddt->primaryKey => $id));
			$this->request->data = $this->Rigaddt->find('first', $options);
		}
		$ddt = $this->Rigaddt->Ddt->find('list');
		$this->set(compact('ddt'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Rigaddt->id = $id;
		if (!$this->Rigaddt->exists()) {
			throw new NotFoundException(__('Invalid rigaddt'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Rigaddt->delete()) {
			$this->Session->setFlash(__('The rigaddt has been deleted.'));
		} else {
			$this->Session->setFlash(__('The rigaddt could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
