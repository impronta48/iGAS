<?php
App::uses('AppController', 'Controller');
/**
 * Provenienzesoldi Controller
 *
 * @property Provenienzasoldi $Provenienzasoldi
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProvenienzesoldiController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = ['Paginator', 'Session'];

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Provenienzasoldi->recursive = 0;
		$this->set('provenienzesoldi', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Provenienzasoldi->exists($id)) {
			throw new NotFoundException(__('Invalid provenienzasoldi'));
		}
		$options = ['conditions' => ['Provenienzasoldi.' . $this->Provenienzasoldi->primaryKey => $id]];
		$this->set('provenienzasoldi', $this->Provenienzasoldi->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Provenienzasoldi->create();
			if ($this->Provenienzasoldi->save($this->request->data)) {
				$this->Session->setFlash(__('The provenienzasoldi has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The provenienzasoldi could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Provenienzasoldi->exists($id)) {
			throw new NotFoundException(__('Invalid provenienzasoldi'));
		}
		if ($this->request->is(['post', 'put'])) {
			if ($this->Provenienzasoldi->save($this->request->data)) {
				$this->Session->setFlash(__('The provenienzasoldi has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The provenienzasoldi could not be saved. Please, try again.'));
			}
		} else {
			$options = ['conditions' => ['Provenienzasoldi.' . $this->Provenienzasoldi->primaryKey => $id]];
			$this->request->data = $this->Provenienzasoldi->find('first', $options);
		}				
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Provenienzasoldi->id = $id;
		if (!$this->Provenienzasoldi->exists()) {
			throw new NotFoundException(__('Invalid provenienzasoldi'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Provenienzasoldi->delete()) {
			$this->Session->setFlash(__('The provenienzasoldi has been deleted.'));
		} else {
			$this->Session->setFlash(__('The provenienzasoldi could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}
