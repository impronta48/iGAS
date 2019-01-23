<?php
App::uses('AppController', 'Controller');
/**
 * Faseattivita Controller
 *
 * @property Faseattivita $Faseattivita
 * @property PaginatorComponent $Paginator
 */
class FaseattivitaController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $helpers = array('Cache');
	public $cacheAction = "1 day";
	
/**
 * index method
 *
 * @return void
 */
	public function index($attivita_id = NULL) {
        
		$this->Faseattivita->recursive = 1; // MarcoT. devo tirare su i ddt associati a questo prodotto per calcolare i residui
        $conditions=array();
        if (!is_null($attivita_id))
        {
            $this->set('title_for_layout', "Fasi Attività [$attivita_id]");
            $conditions = array('attivita_id'=>$attivita_id);
        }
        else
        {
            $attivita = $this->Faseattivita->Attivita->getlist();
            $this->set(compact('attivita'));
            $this->set('title_for_layout', "Fasi Attività - Tutte");
        }
        //Faccio una lista di attività positive
        $conditions['entrata'] = 1;
      	$faseattivitapositiva = $this->Faseattivita->find('all', array('conditions' => $conditions));      	

		//Faccio una lista di attività negative
      	$conditions['entrata'] = 0;
      	$faseattivitanegativa = $this->Faseattivita->find('all', array('conditions' => $conditions));

        $legendaStatoAttivita = $this->Faseattivita->LegendaStatoAttivita->find('list',array('cache' => 'legendastatoattivita', 'cacheConfig' => 'short'));
        $legendaCodiceiva = $this->Faseattivita->LegendaCodiciIva->find('list',array('cache' => 'legendacodiceiva', 'cacheConfig' => 'short'));
        $this->set(compact('legendaStatoAttivita','legendaCodiceiva','faseattivitapositiva','faseattivitanegativa'));		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Faseattivita->create();
			if ($this->Faseattivita->save($this->request->data)) {
                $this->Session->setFlash('Fase salvata con successo');
                $id = $this->request->data['Faseattivita']['attivita_id'];                
				return $this->redirect(array('action' => 'index', $id));
			} else {
				$this->Session->setFlash(__('Impossibile salvare la fase. Riprova!'));
			}
		}
		$attivita = $this->Faseattivita->Attivita->getlist();
		$legendaStatoAttivita = $this->Faseattivita->LegendaStatoAttivita->find('list',array('cache' => 'legendastatoattivita', 'cacheConfig' => 'short'));
		$legendaCodiceIva = $this->Faseattivita->LegendaCodiciIva->find('list',array('cache' => 'legendacodiceiva', 'cacheConfig' => 'short'));
		$this->set(compact('attivita', 'legendaStatoAttivita', 'legendaCodiceIva'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Faseattivita->exists($id)) {
			throw new NotFoundException(__('Invalid faseattivita'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Faseattivita->save($this->request->data)) {
				$this->Session->setFlash(__('The faseattivita has been saved'));
                $id = $this->request->data['Faseattivita']['attivita_id'];                
				return $this->redirect(array('action' => 'index', $id));
			} else {
				$this->Session->setFlash(__('The faseattivita could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Faseattivita.' . $this->Faseattivita->primaryKey => $id));
			$this->request->data = $this->Faseattivita->find('first', $options);
		}
		$attivita = $this->Faseattivita->Attivita->getlist();
		$legendaStatoAttivita = $this->Faseattivita->LegendaStatoAttivita->find('list',array('cache' => 'legendastatoattivita', 'cacheConfig' => 'short'));
        $legendaCodiceiva = $this->Faseattivita->LegendaCodiciIva->find('list',array('cache' => 'legendacodiceiva', 'cacheConfig' => 'short'));
		$this->set(compact('attivita', 'legendaStatoAttivita', 'legendaCodiceiva'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $aid = null) {
		$this->Faseattivita->id = $id;
		if (!$this->Faseattivita->exists()) {
			throw new NotFoundException(__('Invalid faseattivita'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Faseattivita->delete()) {
			$this->Session->setFlash(__('Faseattivita deleted'));			   
				return $this->redirect(array('action' => 'index', $aid));

		}
		$this->Session->setFlash(__('Faseattivita was not deleted'));		
		return $this->redirect(array('action' => 'index', $aid));

	}

	function suggest()
	{
        $data = array();
        if (isset($this->request->query['q']))
        {
            $this->Faseattivita->recursive = 0;
            $data= $this->Faseattivita->find('all', array(
                    'conditions' => array(
                    'Faseattivita.Descrizione LIKE' => '%'.$this->request->query['q'].'%',
                    ),
                    'limit' => 50,
                    'fields' => array('id', 'Descrizione'),
                ));
        }
		$res = array();

		foreach ($data as $d)
		{
			$a = new StdClass();
			$a->value = $d['Faseattivita']['id'];
			$a->name = $d['Faseattivita']['Descrizione'];
			$res[] = $a;
		}
		$this->layout = 'js';
		$this->autoLayout = false;
        $this->autoRender = false;

		echo json_encode($res);
		exit();
	}
	
	//returns a list of items filtered for one activity_id and ready for a dropdown
	public function getlist($attivita_id = null)
	{		
		$this->layout = 'ajax';
		$this->request->onlyAllow('ajax');
		$faseattivita = Cache::read('faseattivita_'. $attivita_id, 'long');
		if (!$faseattivita) {
			$faseattivita = $this->Faseattivita->getSimple($attivita_id);		
			Cache::write('faseattivita_'. $attivita_id, $faseattivita, 'long');
		}
		$this->set(compact('faseattivita'));		
	}
}
