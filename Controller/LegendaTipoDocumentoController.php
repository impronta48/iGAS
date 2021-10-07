<?php
App::uses('AppController', 'Controller');
/**
 * LegendaTipoDocumentos Controller
 *
 * @property LegendaTipoDocumento $LegendaTipoDocumento
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LegendaTipoDocumentoController extends AppController {

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
		$this->LegendaTipoDocumento->recursive = 0;
		$this->set('legendaTipoDocumentos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LegendaTipoDocumento->exists($id)) {
			throw new NotFoundException(__('Invalid legenda tipo documento'));
		}
		$options = array('conditions' => array('LegendaTipoDocumento.' . $this->LegendaTipoDocumento->primaryKey => $id));
		$this->set('legendaTipoDocumento', $this->LegendaTipoDocumento->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LegendaTipoDocumento->create();
			if ($this->LegendaTipoDocumento->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda tipo documento has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda tipo documento could not be saved. Please, try again.'));
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
		if (!$this->LegendaTipoDocumento->exists($id)) {
			throw new NotFoundException(__('Invalid legenda tipo documento'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LegendaTipoDocumento->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda tipo documento has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda tipo documento could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('LegendaTipoDocumento.' . $this->LegendaTipoDocumento->primaryKey => $id));
			$this->request->data = $this->LegendaTipoDocumento->find('first', $options);
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
		$this->LegendaTipoDocumento->id = $id;
		if (!$this->LegendaTipoDocumento->exists()) {
			throw new NotFoundException(__('Invalid legenda tipo documento'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->LegendaTipoDocumento->delete()) {
			$this->Session->setFlash(__('The legenda tipo documento has been deleted.'));
		} else {
			$this->Session->setFlash(__('The legenda tipo documento could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
