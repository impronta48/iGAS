<?php
App::uses('AppController', 'Controller');
/**
 * LegendaCatSpesas Controller
 *
 * @property LegendaCatSpesa $LegendaCatSpesa
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LegendaCatSpesaController extends AppController {

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
		$this->LegendaCatSpesa->recursive = 0;
		$this->set('legendaCatSpesas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LegendaCatSpesa->exists($id)) {
			throw new NotFoundException(__('Invalid legenda cat spesa'));
		}
		$options = array('conditions' => array('LegendaCatSpesa.' . $this->LegendaCatSpesa->primaryKey => $id));
		$this->set('legendaCatSpesa', $this->LegendaCatSpesa->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LegendaCatSpesa->create();
			if ($this->LegendaCatSpesa->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda cat spesa has been saved.'));
				//return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda cat spesa could not be saved. Please, try again.'));
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
		if (!$this->LegendaCatSpesa->exists($id)) {
			throw new NotFoundException(__('Invalid legenda cat spesa'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LegendaCatSpesa->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda cat spesa has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda cat spesa could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('LegendaCatSpesa.' . $this->LegendaCatSpesa->primaryKey => $id));
			$this->request->data = $this->LegendaCatSpesa->find('first', $options);
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
		$this->LegendaCatSpesa->id = $id;
		if (!$this->LegendaCatSpesa->exists()) {
			throw new NotFoundException(__('Invalid legenda cat spesa'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->LegendaCatSpesa->delete()) {
			$this->Session->setFlash(__('The legenda cat spesa has been deleted.'));
		} else {
			$this->Session->setFlash(__('The legenda cat spesa could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
