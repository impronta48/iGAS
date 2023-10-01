<?php
App::uses('AppController', 'Controller');
/**
 * LegendaMezzis Controller
 *
 * @property LegendaMezzi $LegendaMezzi
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LegendaMezziController extends AppController {

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
		$this->LegendaMezzi->recursive = 0;
		$this->set('legendaMezzis', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LegendaMezzi->exists($id)) {
			throw new NotFoundException(__('Invalid legenda mezzi'));
		}
		$options = ['conditions' => ['LegendaMezzi.' . $this->LegendaMezzi->primaryKey => $id]];
		$this->set('legendaMezzi', $this->LegendaMezzi->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LegendaMezzi->create();
			if ($this->LegendaMezzi->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda mezzi has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The legenda mezzi could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
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
		if (!$this->LegendaMezzi->exists($id)) {
			throw new NotFoundException(__('Invalid legenda mezzi'));
		}
		if ($this->request->is(['post', 'put'])) {
			if ($this->LegendaMezzi->save($this->request->data)) {
				$this->Session->setFlash(__('The legenda mezzi has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The legenda mezzi could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
			}
		} else {
			$options = ['conditions' => ['LegendaMezzi.' . $this->LegendaMezzi->primaryKey => $id]];
			$this->request->data = $this->LegendaMezzi->find('first', $options);
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
		$this->LegendaMezzi->id = $id;
		if (!$this->LegendaMezzi->exists()) {
			throw new NotFoundException(__('Invalid legenda mezzi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LegendaMezzi->delete()) {
			$this->Session->setFlash(__('The legenda mezzi has been deleted.'), 'default', ['class' => 'alert alert-success']);
		} else {
			$this->Session->setFlash(__('The legenda mezzi could not be deleted. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
		}
		return $this->redirect(['action' => 'index']);
	}
}
