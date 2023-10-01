<?php
App::uses('AppController', 'Controller');
/**
 * LegendaUnitaMisura Controller
 *
 * @property LegendaUnitaMisura $LegendaUnitaMisura
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LegendaUnitaMisuraController extends AppController {

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
		$this->LegendaUnitaMisura->recursive = 0;
		$this->set('legendaUnitaMisuras', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LegendaUnitaMisura->exists($id)) {
			throw new NotFoundException(__('Invalid legenda unita misura'));
		}
		$options = ['conditions' => ['LegendaUnitaMisura.' . $this->LegendaUnitaMisura->primaryKey => $id]];
		$this->set('legendaUnitaMisura', $this->LegendaUnitaMisura->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LegendaUnitaMisura->create();
			if ($this->LegendaUnitaMisura->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda unita misura has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The legenda unita misura could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
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
		if (!$this->LegendaUnitaMisura->exists($id)) {
			throw new NotFoundException(__('Invalid legenda unita misura'));
		}
		if ($this->request->is(['post', 'put'])) {
			if ($this->LegendaUnitaMisura->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda unita misura has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The legenda unita misura could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
			}
		} else {
			$options = ['conditions' => ['LegendaUnitaMisura.' . $this->LegendaUnitaMisura->primaryKey => $id]];
			$this->request->data = $this->LegendaUnitaMisura->find('first', $options);
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
		$this->LegendaUnitaMisura->id = $id;
		if (!$this->LegendaUnitaMisura->exists()) {
			throw new NotFoundException(__('Invalid legenda unita misura'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LegendaUnitaMisura->delete()) {
			$this->Session->setFlash(__('The legenda unita misura has been deleted.'), 'default', ['class' => 'alert alert-success']);
		} else {
			$this->Session->setFlash(__('The legenda unita misura could not be deleted. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
		}
		return $this->redirect(['action' => 'index']);
	}
}
