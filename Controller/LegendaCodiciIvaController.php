<?php
App::uses('AppController', 'Controller');
/**
 * LegendaCodiciIvas Controller
 *
 * @property LegendaCodiciIva $LegendaCodiciIva
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class LegendaCodiciIvaController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = ['Paginator', 'Flash', 'Session'];

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->LegendaCodiciIva->recursive = 0;
		$this->set('legendaCodiciIvas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LegendaCodiciIva->exists($id)) {
			throw new NotFoundException(__('Invalid legenda codici iva'));
		}
		$options = ['conditions' => ['LegendaCodiciIva.' . $this->LegendaCodiciIva->primaryKey => $id]];
		$this->set('legendaCodiciIva', $this->LegendaCodiciIva->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LegendaCodiciIva->create();
			if ($this->LegendaCodiciIva->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda codici iva has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The legenda codici iva could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
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
		if (!$this->LegendaCodiciIva->exists($id)) {
			throw new NotFoundException(__('Invalid legenda codici iva'));
		}
		if ($this->request->is(['post', 'put'])) {
			if ($this->LegendaCodiciIva->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda codici iva has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The legenda codici iva could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
			}
		} else {
			$options = ['conditions' => ['LegendaCodiciIva.' . $this->LegendaCodiciIva->primaryKey => $id]];
			$this->request->data = $this->LegendaCodiciIva->find('first', $options);
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
		$this->LegendaCodiciIva->id = $id;
		if (!$this->LegendaCodiciIva->exists()) {
			throw new NotFoundException(__('Invalid legenda codici iva'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LegendaCodiciIva->delete()) {
			$this->Session->setFlash(__('The legenda codici iva has been deleted.'), 'default', ['class' => 'alert alert-success']);
		} else {
			$this->Session->setFlash(__('The legenda codici iva could not be deleted. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
		}
		return $this->redirect(['action' => 'index']);
	}
}
