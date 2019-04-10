<?php
class RighefattureController extends AppController {

	var $name = 'Righefatture';

	function index() {
		$this->Rigafattura->recursive = 0;
		$this->set('righefatture', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid rigafattura'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('rigafattura', $this->Rigafattura->read(null, $id));
	}

	function add($fattura_id = null) {
        if (empty($fattura_id) && (empty($this->request->data)))
        {
            $this->Session->setFlash(__('Devi associare la riga ad una fattura'));
            $this->redirect(array('controller' => 'attivita', 'action' => 'index'));
        }
		if (!empty($this->request->data)) {
			$this->Rigafattura->create();
            
			if ($this->Rigafattura->save($this->request->data)) {
                $fid = $this->request->data['Rigafattura']['fattura_id'];
				$this->Session->setFlash(__('The rigafattura has been saved'));
				$this->redirect(array('controller'=>'fattureemesse', 'action'=>'edit', $fid ));
			} else {
				$this->Session->setFlash(__('The rigafattura could not be saved. Please, try again.'));
			}
		}
        $codiciiva = $this->Rigafattura->LegendaCodiciIva->find('list',array('cache' => 'LegendaCodiciIva', 'cacheConfig' => 'short'));
        $this->set('fattura_id', $fattura_id);
        $this->set(compact('codiciiva'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid rigafattura'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Rigafattura->save($this->request->data)) {
                $fid = $this->request->data['Rigafattura']['fattura_id'];
				$this->Session->setFlash(__('The rigafattura has been saved'));
				$this->redirect(array('controller'=>'fattureemesse', 'action'=>'edit', $fid ));
			} else {
				$this->Session->setFlash(__('The rigafattura could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
            $codiciiva = $this->Rigafattura->LegendaCodiciIva->find('list',array('cache' => 'LegendaCodiciIva', 'cacheConfig' => 'short'));
            $this->set(compact('codiciiva'));
			$this->request->data = $this->Rigafattura->read(null, $id);
		}
	}

	function delete($id = null) {
		if( $this->request->is('ajax') ) {

			$this->RequestHandler->setContent('json', 'application/json');

			if (!$id) {
				$res['status'] = 0;
				$res['message'] = __('Invalid id for rigafattura');
			}
			else {
				if( $this->Rigafattura->delete($id) ) {
					$res['status'] = 1;
					$res['message'] = __('Rigafattura deleted');
				}
				else {
					$res['status'] = 0;
					$res['message'] = __('Rigafattura was not deleted');
				}
			}

			$this->set('res', $res);
			$this->set('_serialize', 'res');

		}
		else {

			if (!$id) {
				$this->Session->setFlash(__('Invalid id for rigafattura'));
				$this->redirect(array('action'=>'index'));
			}
		    $fatt = $this->Rigafattura->findById($id);
		    $fid = $fatt['Rigafattura']['fattura_id'];
			if ($this->Rigafattura->delete($id)) {
				$this->Session->setFlash(__('Rigafattura deleted'));
				$this->redirect(array('controller'=>'fattureemesse', 'action'=>'edit', $fid ));
			}
			$this->Session->setFlash(__('Rigafattura was not deleted'));
			$this->redirect(array('action' => 'index'));

		}
	}
}
