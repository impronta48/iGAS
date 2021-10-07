<?php
App::uses('AppController', 'Controller');
/**
 * LegendaTipoAttivitaCalendario Controller
 *
 * @property LegendaTipoAttivitaCalendario $LegendaTipoAttivitaCalendario
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LegendaTipoAttivitaCalendarioController extends AppController {

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
		$this->LegendaTipoAttivitaCalendario->recursive = 0;
		$this->set('LegendaTipoAttivitaCalendarios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LegendaTipoAttivitaCalendario->exists($id)) {
			throw new NotFoundException(__('Invalid legenda tipo attività calendario'));
		}
		$options = array('conditions' => array('LegendaTipoAttivitaCalendario.' . $this->LegendaTipoAttivitaCalendario->primaryKey => $id));
		$this->set('LegendaTipoAttivitaCalendario', $this->LegendaTipoAttivitaCalendario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LegendaTipoAttivitaCalendario->create();
			if ($this->LegendaTipoAttivitaCalendario->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda tipo attività calendario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda tipo attività calendario could not be saved. Please, try again.'));
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
		if (!$this->LegendaTipoAttivitaCalendario->exists($id)) {
			throw new NotFoundException(__('Invalid legenda tipo attività calendario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LegendaTipoAttivitaCalendario->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda tipo attività calendario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The legenda tipo attività calendario could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('LegendaTipoAttivitaCalendario.' . $this->LegendaTipoAttivitaCalendario->primaryKey => $id));
			$this->request->data = $this->LegendaTipoAttivitaCalendario->find('first', $options);
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
		if(!$id){
            $this->Session->setFlash(__('Invalid legenda attività calendario'));
            $this->redirect(array('action' => 'index'));
        }
        if($this->LegendaTipoAttivitaCalendario->delete($id)){
            $this->Session->setFlash(__('The legenda attività calendario has been deleted.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('The legenda attività calendario could not be deleted. Please, try again.'));
        $this->redirect(array('action' => 'index'));
		/*
		$this->LegendaTipoAttivitaCalendario->id = $id;
		if (!$this->LegendaTipoAttivitaCalendario->exists()) {
			throw new NotFoundException(__('Invalid legenda attività calendario'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->LegendaTipoAttivitaCalendario->delete()) {
			$this->Session->setFlash(__('The legenda attività calendario has been deleted.'));
		} else {
			$this->Session->setFlash(__('The legenda attività calendario could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
		*/
	}
}
