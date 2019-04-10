<?php
App::uses('AppController', 'Controller');
/**
 * Ddt Controller
 *
 * @property Ddt $Ddt
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DdtController extends AppController {

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
		$this->Ddt->recursive = 0;
		$this->set('ddt', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ddt->exists($id)) {
			throw new NotFoundException(__('Invalid ddt'));
		}
		$options = array('conditions' => array('Ddt.' . $this->Ddt->primaryKey => $id));
		$this->set('ddt', $this->Ddt->find('first', $options));        
        $azienda =  $this->Ddt->Attivita->Persona->findById(Configure::read('iGas.idAzienda'));
        $this->set('azienda', $azienda);
	}

/**
 * add method
 *
 * @return void
 */
	public function add($attivita_id = null) {
        if (!$this->Ddt->Attivita->exists($attivita_id)) {
			throw new NotFoundException(__('Attività non valida'));
		}
        $this->set('attivita', $this->Ddt->Attivita->find('list'));
		$this->Ddt->Attivita->recursive = 2; //devo tirare su anche le righe ddt associate alle fasi attività
        $attivita_full = $this->Ddt->Attivita->findById($attivita_id);        
        $this->set('a', $attivita_full);
        
		if ($this->request->is('post')) {
			$this->Ddt->create();
			if ($this->Ddt->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The ddt has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ddt could not be saved. Please, try again.'));
			}
		}
        else{
            $this->set('vettori', $this->Ddt->Vettore->find('list'));
            $this->set('legenda_porto', $this->Ddt->LegendaPorto->find('list'));            
            $this->set('legenda_causale_trasporto', $this->Ddt->LegendaCausaleTrasporto->find('list'));
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
		if (!$this->Ddt->exists($id)) {
			throw new NotFoundException(__('Invalid ddt'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ddt->save($this->request->data)) {
				$this->Session->setFlash(__('The ddt has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ddt could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ddt.' . $this->Ddt->primaryKey => $id));
			$this->request->data = $this->Ddt->find('first', $options);
            $attivita_id = $this->request->data['Attivita']['id'];
            $attivita_full = $this->Ddt->Attivita->findById($attivita_id);        
            $this->set('a', $attivita_full);
            $this->set('attivita', $this->Ddt->Attivita->find('list'));
            $this->set('vettori', $this->Ddt->Vettore->find('list'));
            $this->set('legenda_porto', $this->Ddt->LegendaPorto->find('list'));            
            $this->set('legenda_causale_trasporto', $this->Ddt->LegendaCausaleTrasporto->find('list'));

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
		$this->Ddt->id = $id;
		if (!$this->Ddt->exists()) {
			throw new NotFoundException(__('Invalid ddt'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ddt->delete()) {
			$this->Session->setFlash(__('The ddt has been deleted.'));
		} else {
			$this->Session->setFlash(__('The ddt could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
    
    
    function stampa($id)
    {           
        $this->layout ='stampa';
        $this->response->type('pdf');
        $this->view($id);        
        $this->render('view');		
        $f = $this->Ddt->findById($id);
		
        $d = new DateTime($f['Ddt']['data_inizio_trasporto']);
        $anno = $d->format('Y');
        $progressivo = $f['Ddt']['id'];
		//8 caratteri del cliente
        $cli = str_replace(' ', '',substr($f['Ddt']['destinatario'], 0,8));
		//8 caratteri dell'attivita
		$att = str_replace(' ', '',substr($f['Attivita']['name'],0,8));
		
        $this->response->download("$anno-$progressivo-" . Configure::read('iGas.NomeAzienda')."DdT-$cli-$att.pdf"); 
    }
}
