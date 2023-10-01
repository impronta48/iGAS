<?php
App::uses('AppController', 'Controller');
/**
 * Impiegati Controller
 *
 * @property Impiegato $Impiegato
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ImpiegatiController extends AppController {

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
	public function index($persona_id =null) {
		$this->Impiegato->recursive = 0;
        $conditions = [];
        
        //Se mi hai passato un id di una persona, faccio vedere
        //tutte le righe di tariffa di quella persona
        if (!empty($persona_id))
        {
            $conditions['Impiegato.persona_id'] = $persona_id;
            $this->set('persona_id', $persona_id);
        }
        
        $this->Paginator->settings = ['conditions' => $conditions, 'order'=>'dataValidita DESC'];
		$this->set('impiegati',  $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Impiegato->exists($id)) {
			throw new NotFoundException(__('Invalid impiegato'));
		}
		$options = ['conditions' => ['Impiegato.' . $this->Impiegato->primaryKey => $id]];
		$this->set('impiegato', $this->Impiegato->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($persona_id = null) {
		if ($this->request->is('post')) {
			$this->Impiegato->create();
			$user = $this->Session->read('Auth.User');			
			$this->request->data['Impiegato']['modificatoDa'] = $user['id'];
			if ($this->Impiegato->save($this->request->data)) {
				$this->Session->setFlash(__('The impiegato has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The impiegato could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
			}
		}
		$persona_id = $this->set(compact('persona_id'));
		$persone = $this->Impiegato->Persona->find('list');
		$legendaUnitaMisura = $this->Impiegato->LegendaUnitaMisura->find('list');
		$legendaTipiImpiegati = $this->Impiegato->LegendaTipoImpiegato->find('list');
		$this->set(compact('persone','legendaTipiImpiegati','legendaUnitaMisura'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Impiegato->exists($id)) {
			throw new NotFoundException(__('Invalid impiegato'));
		}
		if ($this->request->is(['post', 'put'])) {
			$user = $this->Session->read('Auth.User');			
			$this->request->data['Impiegato']['modificatoDa'] = $user['id'];
			
			if ($this->Impiegato->save($this->request->data)) {
				$this->Session->setFlash(__('The impiegato has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The impiegato could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
			}
		} else {
			$options = ['conditions' => ['Impiegato.' . $this->Impiegato->primaryKey => $id]];
			$this->request->data = $this->Impiegato->find('first', $options);
		}
        
    $persone = $this->Impiegato->Persona->find('list');
		$legendaUnitaMisura = $this->Impiegato->LegendaUnitaMisura->find('list');
		$legendaTipiImpiegati = $this->Impiegato->LegendaTipoImpiegato->find('list');
		$this->set(compact('persone','legendaTipiImpiegati','legendaUnitaMisura'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Impiegato->id = $id;
		if (!$this->Impiegato->exists()) {
			throw new NotFoundException(__('Invalid impiegato'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Impiegato->delete()) {
			$this->Session->setFlash(__('The impiegato has been deleted.'), 'default', ['class' => 'alert alert-success']);
		} else {
			$this->Session->setFlash(__('The impiegato could not be deleted. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
		}
		return $this->redirect(['action' => 'index']);
	}

	/**
	 * creates a variation of the current record reffering to a impiegato
	 * finds current record
	 * proposes a new record with the same values and a new validity
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function variation($id=null)
	{
		$this->Impiegato->id = $id;
		if (!$this->Impiegato->exists()) {
			throw new NotFoundException(__('Invalid impiegato'));
		}

		if ($this->request->is('post')) {
			$this->Impiegato->create();
			$user = $this->Session->read('Auth.User');
			$this->request->data['Impiegato']['modificatoDa'] = $user['id'];
			if ($this->Impiegato->save($this->request->data)) {
				$this->Session->setFlash(__('The impiegato has been saved.'), 'default', ['class' => 'alert alert-success']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The impiegato could not be saved. Please, try again.'), 'default', ['class' => 'alert alert-danger']);
			}
		}

		$options = ['conditions' => ['Impiegato.id'  => $id]];
		$this->request->data = $this->Impiegato->find('first', $options);
		//Imposto da data di valità ad oggi
		$this->request->data['Impiegato']['dataValidita']= date('Y-m-d');
		//Tolgo la chiave primaria in modo che generi un nuovo record
		unset($this->request->data['Impiegato']['id']);		
		$persone = $this->Impiegato->Persona->find('list');
		$legendaUnitaMisura = $this->Impiegato->LegendaUnitaMisura->find('list');
		$legendaTipiImpiegati = $this->Impiegato->LegendaTipoImpiegato->find('list');
		$this->set(compact('persone', 'legendaTipiImpiegati', 'legendaUnitaMisura'));

		$this->render('edit');		
	}
}
