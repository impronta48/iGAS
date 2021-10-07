<?php
App::uses('AppController', 'Controller');
/**
 * LegendaTipoImpiegatos Controller
 *
 * @property LegendaTipoImpiegato $LegendaTipoImpiegato
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LegendaTipiImpiegatiController extends AppController {

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
		$this->LegendaTipoImpiegato->recursive = 0;
		$this->set('legendaTipoImpiegatos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LegendaTipoImpiegato->exists($id)) {
			throw new NotFoundException(__('Invalid legenda tipo impiegato'));
		}
		$options = array('conditions' => array('LegendaTipoImpiegato.' . $this->LegendaTipoImpiegato->primaryKey => $id));
		$this->set('legendaTipoImpiegato', $this->LegendaTipoImpiegato->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LegendaTipoImpiegato->create();
			if ($this->LegendaTipoImpiegato->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda tipo impiegato has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda tipo impiegato could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
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
		if (!$this->LegendaTipoImpiegato->exists($id)) {
			throw new NotFoundException(__('Invalid legenda tipo impiegato'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LegendaTipoImpiegato->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda tipo impiegato has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda tipo impiegato could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('LegendaTipoImpiegato.' . $this->LegendaTipoImpiegato->primaryKey => $id));
			$this->request->data = $this->LegendaTipoImpiegato->find('first', $options);
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
		$this->LegendaTipoImpiegato->id = $id;
		if (!$this->LegendaTipoImpiegato->exists()) {
			throw new NotFoundException(__('Invalid legenda tipo impiegato'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LegendaTipoImpiegato->delete()) {
			$this->Session->setFlash(__('The legenda tipo impiegato has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The legenda tipo impiegato could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
