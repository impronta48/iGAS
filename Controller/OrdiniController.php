<?php
App::uses('AppController', 'Controller');
/**
 * Ordini Controller
 *
 * @property Ordine $Ordine
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class OrdiniController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public $helpers = array('Html', 'Form','Text');

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $conditions = array();
        if (!empty($this->request->named['persona']))
        {
            $conditions['fornitore_id'] = $this->request->named['persona'];
        }
        
		$this->Ordine->recursive = 1; // MarcoT. devo tirare su anche le righe ordine per lo stato
        $this->Paginator->settings = array('conditions'=>$conditions);
		$this->set('ordini', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ordine->exists($id)) {
			throw new NotFoundException(__('Invalid ordine'));
		}
		$options = array('conditions' => array('Ordine.' . $this->Ordine->primaryKey => $id));
		$this->set('ordine', $this->Ordine->find('first', $options));
        $azienda =  $this->Ordine->Fornitore->findById(Configure::read('iGas.idAzienda'));
        $this->set('azienda', $azienda);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $attivita_id = $this->params['url']['attivita_id'];
        $fasi = $this->params['url']['fasi'];
        
		if ($this->request->is('post')) {
			$this->Ordine->create();
			if ($this->Ordine->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The ordine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ordine could not be saved. Please, try again.'));
			}
		}
        else
        {
            $attivita = $this->Ordine->Attivita->find('list');
            $fornitori = $this->Ordine->Fornitore->find('list');
            $this->set(compact('attivita', 'fornitori'));
        }
        
        if (!empty($attivita_id))
        {
            $attivita_full = $this->Ordine->Attivita->findById($attivita_id);        
            $this->set('a', $attivita_full);
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
		if (!$this->Ordine->exists($id)) {
			throw new NotFoundException(__('Invalid ordine'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ordine->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The ordine has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ordine could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ordine.' . $this->Ordine->primaryKey => $id));
			$this->request->data = $this->Ordine->find('first', $options);
		}
		$attivita = $this->Ordine->Attivita->find('list');
		$fornitori = $this->Ordine->Fornitore->find('list');
		$this->set(compact('attivita', 'fornitori'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ordine->id = $id;
		if (!$this->Ordine->exists()) {
			throw new NotFoundException(__('Invalid ordine'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ordine->delete()) {
			$this->Session->setFlash(__('The ordine has been deleted.'));
		} else {
			$this->Session->setFlash(__('The ordine could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
    
    function stampa($id)
    {           
        $this->layout ='stampa';
        $this->response->type('pdf');
        $this->view($id);        
        $this->render('view');		
        $f = $this->Ordine->findById($id);
		
        $d = new DateTime('now');
        $anno = $d->format('Y');
        $progressivo = $f['Ordine']['id'];
		//8 caratteri del cliente
        $cli = str_replace(' ', '',substr($f['Fornitore']['DisplayName'], 0,8));
		//8 caratteri dell'attivita
		$att = str_replace(' ', '',substr($f['Attivita']['name'],0,8));
		
        $this->response->download("$anno-$progressivo-" . Configure::read('iGas.NomeAzienda')."Ordine-$cli-$att.pdf"); 
    }
}
