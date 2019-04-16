<?php
App::uses('AppController', 'Controller');
/**
 * Fatturericevute Controller
 *
 * @property Fatturericevute $Fatturericevute
 * @property PaginatorComponent $Paginator
 */
class FatturericevuteController extends AppController {
	
	public $components = array('Paginator', 'UploadFiles', 'GoogleDrive', 'GoogleMail');
    public $uses = array('Fatturaricevuta', 'Primanota');
	
/**
 * index method
 *
 * @return void
 */
	function index()
    {
        $conditions=array();
        
        if ($this->request->query('attivita'))
        {
            $conditions = array('Fatturaricevuta.attivita_id'=>$this->request->query('attivita'));
        }          
        if ($this->request->query('persona'))
        {
            $conditions['fornitore_id'] = $this->request->query('persona');
        }
        if ($this->request->query('provenienzasoldi'))
        {
            $conditions['provenienza'] = $this->request->query('provenienzasoldi');
        }   
        if ($this->request->query('legendacatspesa'))
        {
            $conditions['legenda_cat_spesa_id'] = $this->request->query('legendacatspesa');
        }   
        if ($this->request->query('legendatipodocumento'))
        {
            $conditions['legenda_tipo_documento_id'] = $this->request->query('legendatipodocumento');
        }   

        $anno = date('Y');  
        if ($this->request->query('annoF'))
        {			
                $anno = $this->request->query('annoF');
        }     		
        if (is_numeric($anno))
        {
            $conditions['YEAR(dataFattura)'] = $anno;
        }
        $anno = date('Y');  
        if ($this->request->query('anno'))
        {			
                $anno = $this->request->query('anno');
        }     		
        if (is_numeric($anno))
        {
            $conditions['YEAR(scadPagamento)'] = $anno;
        }
				
        if (!empty($this->request->query('pagato')))
        {
                //Nota il test è al contrario perchè devo prendere anche i NULL
                $p = 1;
                if ($this->request->query('pagato') == -1)
                {
                    $p = 0;
                }
                $conditions['pagato'] = $p;
        }     
		
        $this->set('title_for_layout', 'Documenti Ricevuti - '. $anno); 
        $r = $this->Fatturaricevuta->find('all', array('conditions'=>$conditions, 'order'=>array('protocollo_ricezione'=>'desc') ));
        $this->set('fatturericevute', $r);
        $this->set('provenienzesoldi', $this->Fatturaricevuta->Provenienzasoldi->find('list'));
        $this->set('persone', $this->Fatturaricevuta->Fornitore->find('list'));
        $this->set('attivita', $this->Fatturaricevuta->Attivita->find('list'));
        $this->set('legendatipodocumento', $this->Fatturaricevuta->LegendaTipoDocumento->find('list'));
        $this->set('legendacatspesa', $this->Fatturaricevuta->LegendaCatSpesa->find('list'));
    }


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Fatturaricevuta->create();
			//Se non c'è il DisplayName tolgo tutti i campi del fornitore
            if (empty($this->request->data['Fornitore']['DisplayName']))
            {
                unset($this->request->data['Fornitore']);
            }
            else  //Tolgo l'id fornitore
            {
                unset($this->request->data['Fatturaricevuta']['fornitore_id']);
            }
            //debug($this->request->data);
			if ($this->Fatturaricevuta->SaveAll($this->request->data)) {
				$this->Session->setFlash('La Fattura Ricevuta è stata salvata con successo');
                //Prendo l'id legato al salvataggio
                $id = $this->Fatturaricevuta->getLastInsertID();
				// Qua gestisco l'upload del documento
				$uploaded_file=$this->request->data['Fatturaricevuta']['uploadFile'];
				$uploadError=$this->UploadFiles->upload($id,$uploaded_file,$this->request->controller);
				if(strlen($uploadError)>0){
					$this->Flash->error(__($uploadError));
				}
                //Se la chiamata prevedeva anche il salvataggio della prima nota, invoco anche quella
                if (isset($this->request->data['submit-pn']))
                {
                    $this->add2primanota($id);
                }
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Errore: Impossibile salvare la fattura ricevuta'));
			}
		}
		$attivita = $this->Fatturaricevuta->Attivita->find('list');
		$fornitori = $this->Fatturaricevuta->Fornitore->find('list');
        $legenda_tipo_documento = $this->Fatturaricevuta->LegendaTipoDocumento->find('list');
		
        //Aggiungo il valore "nessuna fase associata", default
		$notset = array('0'=> '-- Non definito --');    
		$fase =$this->Fatturaricevuta->Faseattivita->find('all');
        $fa = Hash::combine($fase, 
                            '{n}.Faseattivita.id', 
                            '{n}.Faseattivita.Descrizione',                            
                            '{n}.Attivita.name'
                           );
        $fa = Hash::merge($notset, $fa);
        $this->set('faseattivita', $fa);        
		
		$faseattivita= $this->Fatturaricevuta->Faseattivita->find('list');
        
		$provenienza = $this->Fatturaricevuta->Provenienzasoldi->find('list');
		$legenda_cat_spesa = $this->Fatturaricevuta->LegendaCatSpesa->find('list');
		$this->set(compact('attivita', 'fornitori', 'provenienza','legenda_cat_spesa','legenda_tipo_documento'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Fatturaricevuta->exists($id)) {
			throw new NotFoundException(__('Fattura ricevuta non valida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {                          
            
            //Salvo la fattura e i campi collegati
			if ($this->Fatturaricevuta->Save($this->request->data)) {
				// Qua gestisco l'upload del documento
				$uploaded_file=$this->request->data['Fatturaricevuta']['uploadFile'];
				$uploadError=$this->UploadFiles->upload($id,$uploaded_file,$this->request->controller);
				if(strlen($uploadError)>0){
					$this->Flash->error(__($uploadError));
				}
				$this->Session->setFlash('La fattura ricevuta è stata salvata');
                //Se la chiamata prevedeva anche il salvataggio della prima nota, invoco anche quella
                if (isset($this->request->data['submit-pn']))
                {
                    $this->add2primanota($id);
                }

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Non è stato possibile salvare la fattura riceuvta. Errore'));
			}
		} else {
			$options = array('conditions' => array('Fatturaricevuta.' . $this->Fatturaricevuta->primaryKey => $id));
			$this->request->data = $this->Fatturaricevuta->find('first', $options);
		}
        $attivita = $this->Fatturaricevuta->Attivita->find('list');
		$fornitori = $this->Fatturaricevuta->Fornitore->find('list');
		$legenda_tipo_documento = $this->Fatturaricevuta->LegendaTipoDocumento->find('list');
        
        //Aggiungo il valore "nessuna fase associata", default
		$notset = array('0'=> '-- Non definito --');    
		$fase =$this->Fatturaricevuta->Faseattivita->find('all');
        $fa = Hash::combine($fase, 
                            '{n}.Faseattivita.id', 
                            '{n}.Faseattivita.Descrizione',                            
                            '{n}.Attivita.name'
                           );
        $fa = Hash::merge($notset, $fa);
        $this->set('faseattivita', $fa); 
        
		$provenienza = $this->Fatturaricevuta->Provenienzasoldi->find('list');
		$legenda_cat_spesa = $this->Fatturaricevuta->LegendaCatSpesa->find('list');
		$this->set(compact('id','attivita', 'fornitori', 'faseattivita','provenienza','legenda_cat_spesa','legenda_tipo_documento'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Fatturaricevuta->id = $id;
		if (!$this->Fatturaricevuta->exists()) {
			throw new NotFoundException(__('Fattura Ricevuta non valida'));
		}
		if ($this->Fatturaricevuta->delete()) {
            $fileExt=$this->UploadFiles->checkIfFileExists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'.');
            if(!empty($fileExt)){
                unlink(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'.'.$fileExt);
            }
			$this->Session->setFlash(__('Cancellata la fattura ricevuta'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Fatturericevute was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
	
	public function deleteDoc($id = null) {
        $fileExt=$this->UploadFiles->checkIfFileExists(WWW_ROOT.'files/'.$this->request->controller.'/'.$id.'.');
		unlink(WWW_ROOT.'files/'.$this->request->controller.'/'.$id.'.'.$fileExt);
		$this->Session->setFlash(__('Documento cancellato'));
		$this->redirect($this->referer());
	}
    
    public function add2primanota($id) {
        $importo = 0;

        if (!isset($id))
        {
            throw new NotFoundException(__('Fattura Ricevuta non specificata'));
        }
        
        //Cerco la fattura riceuvta
        $this->Fatturaricevuta->id = $id;
        if (!$this->Fatturaricevuta->exists()) {
			throw new NotFoundException(__('Fattura Ricevuta non valida'));
		}

        //Se c'è carico tutti i valori
        $fr = $this->Fatturaricevuta->read();

        if(isset($this->request->data['importo'])) {
            $importo = $this->request->data['importo'];
        } else {
            $importo = $fr['Fatturaricevuta']['importo'];
        }
        
        
        //Creo un record vuoto di prima nota
        $pn = $this->Primanota->create();
        
        //Faccio corrispondere i campi di primanota con quelli della fattura
        $pn['Primanota']['attivita_id']  = $fr['Fatturaricevuta']['attivita_id'];
        $pn['Primanota']['descr']  = $fr['Fatturaricevuta']['motivazione'] . ' [Fattura Ricevuta: ' . 
                                            $fr['Fatturaricevuta']['progressivo'] . '/' .
                                            $fr['Fatturaricevuta']['annoFatturazione'] . ']';
        $pn['Primanota']['fatturaricevuta_id']  = $fr['Fatturaricevuta']['id'];
        $pn['Primanota']['data']  = date('Y-m-d');
        //Attenzione dev'essere negativo, perchè per la prima nota è un'uscita
        $pn['Primanota']['importo']  = -$importo;
        $pn['Primanota']['faseattivita_id']  = $fr['Fatturaricevuta']['faseattivita_id'];
        $pn['Primanota']['legenda_cat_spesa_id']  = $fr['Fatturaricevuta']['legenda_cat_spesa_id'];
        $pn['Primanota']['num_documento']  = $fr['Fatturaricevuta']['progressivo'];
        $pn['Primanota']['data_documento']  = $fr['Fatturaricevuta']['dataFattura'];
        $pn['Primanota']['provenienzasoldi_id']  = $fr['Fatturaricevuta']['provenienza'];          
        
        //Per semplicità di query riporto questi dati ridondanti
        $pn['Primanota']['persona_id']  = $fr['Fatturaricevuta']['fornitore_id'];                       
        $pn['Primanota']['persona_descr']  = $fr['Fornitore']['DisplayName'];        
        $pn['Primanota']['imponibile']  = $fr['Fatturaricevuta']['imponibile'];
        $pn['Primanota']['iva']  = $fr['Fatturaricevuta']['iva'];
                
        //Salvo
        if($this->Primanota->save($pn))
        {            
            $this->Session->setFlash(__('Registrata la fattura in prima nota'));
            
            //Devo cambiare anche lo statto della fattura ricevuta e mettere pagato
            if($fr['Fatturaricevuta']['importo'] -1 <= $fr['Fatturaricevuta']['soddisfatta'] + $importo) {

                $fr['Fatturaricevuta']['pagato'] = 1;
                $fr['Fatturaricevuta']['soddisfatta'] = $fr['Fatturaricevuta']['importo'];

                if ($this->Fatturaricevuta->save($fr)) {
                $this->Session->setFlash(__('Aggiornato lo stato della fattura ricevuta'));
                }
            } else {

                $fr['Fatturaricevuta']['soddisfatta'] = $fr['Fatturaricevuta']['soddisfatta'] + $importo;

                if ($this->Fatturaricevuta->save($fr)) {
                $this->Session->setFlash(__('Aggiornato lo stato della fattura ricevuta'));
                }
            }
            
            //TODO: inviare alla primanota giusta per eventuali modifiche
			return $this->redirect(array('controller'=>'primanota', 'action' => 'index'));
        }
        else
        {
            throw new NotFoundException(__('Impossibile generare la corrispondente prima nota'));
        }
    }
}
