<?php
class AttivitaController extends AppController {

	public $name = 'Attivita';
    public $helpers = array('Number','Html');
    public $components = array('Paginator','Cookie','UploadFiles');
 
	function index() {
		$this->Attivita->recursive = 0;        
        $this->Cookie->name = 'igas_attivita_' . Configure::read('iGas.NomeAzienda');

        $conditions = array();	                

        $q = $this->request->query('q');
        $anno = $this->request->query('anno');
        $tipo = $this->request->query('tipo');
        //Se non ci sono parametri prendo dal cookie, se ce n'è anche solo uno uso quello
        if (empty($q) && empty($anno) && empty($tipo))
        {
            $cookieprep = $this->Cookie->read('Attivita.filtro');                        
            if (isset($cookieprep['q']))
            {
                $q = $cookieprep['q'];
            }
            if (isset($cookieprep['anno']))
            {
                $anno = $cookieprep['anno'];
            }
            if (isset($cookieprep['tipo']))
            {
                $tipo = $cookieprep['tipo'];
            }
        }

        if (!empty($q)) {
            $conditions[]= array('OR'=>array('Persona.nome LIKE'=> "%$q%", 'Persona.cognome LIKE'=>"%$q%", 'Persona.DisplayName LIKE'=>"%$q%",'Attivita.name LIKE'=>"%$q%"));            
            $cookieprep['q'] = $q;
        }             
        
        if (empty($anno)) {         //Se non specifichi l'anno filtro sull'anno corrente
             $anno = date('Y');              
        } 
        else
        {
            $cookieprep['anno']=$anno;
        }

        if ($anno>0)
        {
            //Prendo tutte le attività che contengono l'anno corrente
            $conditions = array(
                    'YEAR(DataPresentazione) <=' => $anno,
                    'OR' => array(
                        'YEAR(DataFinePrevista) >=' => $anno,
                        'YEAR(DataFinePrevista)' => null
                    )
            );                        
        }
        if($anno==-1)
        {
            //Prendo tutte le attività che hanno anno di inizio o fine anomali
            $conditions[]= array('OR'=> array(   
                                        'YEAR(DataPresentazione)' => 0, 
                                        'YEAR(DataPresentazione)' => null, 
                                        'YEAR(DataFinePrevista)'=>0,
                                        'YEAR(DataFinePrevista)'=>null
            ));            
        }

        //filtra per tipo di commessa        
        if (!empty($tipo)) {
            if ($tipo == 'offerte'){
                $conditions['DataPresentazione !=']=NULL;
                $conditions['DataApprovazione'] = null;
            } elseif ($tipo == 'aperte') {
                $conditions[] = array('chiusa'=>0);
            } elseif ($tipo == 'chiuse') {
                $conditions[] = array('chiusa'=>1);
            }            
            $cookieprep['tipo']=$tipo;
        }
        
        //Salvo un cookie con il filtro impostato
        $this->Cookie->write('Attivita.filtro',$cookieprep , false, '365 days');
        //Lo passo alla view per poter impostare i default del filtro
        $this->set('cookieprep',$cookieprep);

        //debug($conditions);
        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 0,
            'maxLimit' => -1,
            'contain' => array('Area.name', 'Progetto.name','Persona.displayName','Progetto.id','Persona.id','Area.id'),
        );
        
        //Conto quante attività ci sono in tutto
        //Mi serve per avvisare il client che ci sono attività nascoste
        $totale = $this->Attivita->find('count');
        $this->set('totale',$totale);

        //Leggo la cache solo se non sono in debug
        $attivita = null;
		if (Configure::read('debug')==0)
        {
            $attivita = Cache::read('attivita', 'short');
        }
		if (!$attivita) {            
			$attivita = $this->Paginator->paginate('Attivita');
			Cache::write('attivita', $attivita, 'short');
        }
        
        foreach ($attivita as $a)
        {
            $i = $a['Attivita']['id'];
            $statoAttivita[$i] = $this->getStatoAttivita($a['Attivita']);
        }

        $this->set(compact('attivita','statoAttivita'));
	}

    //restituisce lo stato di un'attività: offerta, commessa, chiusa, anomala
    //lo deduce a partire dalle date
    private function getStatoAttivita($a)
    {
        if ($a['chiusa'])
        {
            return 'chiusa';
        }
        if ($a['DataPresentazione'] && $a['DataApprovazione'] && !$a['chiusa'] ){
            return 'commessa';
        }
        if ($a['DataPresentazione'] && !$a['DataApprovazione'] && !$a['chiusa'] ){
            return 'offerta';
        }
        return 'commessa';
    }

    
    //In caso di date anomale di inizio o fine della commessa le corregge
    //es: attività che non hanno data di presentazione, data di fine prevista, etc
    public function correggiDateInizioFine()
    {
        $this->Attivita->recursive=-1;
        if (!empty($this->request->data)) {       

            //debug($this->request->data); 
             if ($this->Attivita->saveMany($this->request->data['Attivita']))
             {
                 $this->Session->setFlash(__('Salvataggio OK'));                 
             }
             else
             {
                $this->Session->setFlash(__('Errore durante il salvataggio'));
             }  
        }

        $conditions= Array('OR'=> array( 'YEAR(DataPresentazione)' => 0, 
                                        'YEAR(DataPresentazione)' => null, 
                                        'YEAR(DataFinePrevista)'=>0,
                                        'YEAR(DataFinePrevista)'=>null
        ));         

        $this->data = $this->Attivita->find('all', array('conditions'=>$conditions, 'order'=>'id DESC'));        

        //Suggeritore: cerca la prima data di un'attività e l'ultima (tra fatture, prima nota, ore)
        $query = "select u.id, min(u.prima) as prima, max(u.ultima) as ultima from (
                    SELECT ore.eAttivita as id, MIN(ore.data) prima, MAX(ore.data) as ultima FROM ore group by ore.eAttivita
                    UNION
                    SELECT fattureemesse.attivita_id as id, MIN(fattureemesse.data) prima, MAX(fattureemesse.data) as ultima  FROM fattureemesse group by fattureemesse.attivita_id
                    UNION
                    SELECT primanota.attivita_id as id, MIN(primanota.data) prima, MAX(primanota.data) as ultima  FROM primanota group by primanota.attivita_id
                ) as u
                group by u.id
                order by u.id;
        ";
        $primadata= $this->Attivita->query($query);
        //debug($primadata);
        $prima = Hash::combine($primadata, '{n}.u.id', '{n}.0.prima');
        $ultima = Hash::combine($primadata, '{n}.u.id', '{n}.0.ultima');
        //debug($prima);
        //debug($ultima);
        $this->set('primadata', $prima);
        $this->set('ultimadata', $ultima);
    }

    //Chiude tutte le attività che hanno la data di fine impostata, ma sono ancora aperte
    public function chiudi_aperte()
    {
        $this->Attivita->recursive=-1;
        if (!empty($this->request->data)) {       

            //debug($this->request->data); 
             if ($this->Attivita->saveMany($this->request->data['Attivita']))
             {
                 $this->Session->setFlash(__('Salvataggio OK'));                 
             }
             else
             {
                $this->Session->setFlash(__('Errore durante il salvataggio'));
             }  
        }

        $conditions= Array('AND'=> array( 'DataFine IS NOT NULL' , 
                                            'chiusa'=>0
        ));         

        $this->data = $this->Attivita->find('all', array('conditions'=>$conditions, 'order'=>'id DESC'));        
    }

	function edit($id = null) {        
        if (!$id && !empty($this->request->data)) {
              $this->set('title_for_layout', 'Nuova Attività');
              $this->Attivita->create();              
        }
		if (!empty($this->request->data)) {            
                //Se non c'è il DisplayName tolgo tutti i campi del fornitore
                if (empty($this->request->data['Persona']['DisplayName2']))
                {
                    unset($this->request->data['Persona']);
                }
                else  //Tolgo l'id cliente
                {
                    unset($this->request->data['Attivita']['persona_id']);
                    $this->request->data['Persona']['DisplayName'] = $this->request->data['Persona']['DisplayName2'];
                    unset($this->request->data['Persona']['DisplayName2']);
                }                                      

                //Faccio save all per salvare anche i dettagli della persona
                if ($this->Attivita->saveAll($this->request->data)) {
					$this->Session->setFlash('Attività salvata con successo, si può procedere.');
					if(!$id){
						//Prendo l'id legato al salvataggio
						$id = $this->Attivita->getLastInsertID();
					}
					// Qua gestisco l'upload del documento
					$uploaded_file=$this->request->data['Attivita']['uploadFile'];
					$uploadError=$this->UploadFiles->upload($id,$uploaded_file,$this->request->controller,'_preventivo');
					if(strlen($uploadError)>0){
						$this->Flash->error(__($uploadError));
					}
					//Rimango sulla stessa pagina in edit
					$this->redirect(array('action' => 'edit', $this->Attivita->id ));
				} else {
                    $this->Session->setFlash(__('The attivita could not be saved. Please, try again.'));
				}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Attivita->read(null, $id);
                        $this->set('title_for_layout', $this->request->data['Attivita']['name'] . ' [' .$id . '] | Modifica Attività' );
		}
		
		$progetti = $this->Attivita->Progetto->find('list',array('cache' => 'progetto', 'cacheConfig' => 'short'));
		$persone = $this->Attivita->Persona->find('list',array('cache' => 'persona', 'cacheConfig' => 'short'));
		$aree = $this->Attivita->Area->find('list',array('cache' => 'area', 'cacheConfig' => 'short'));
                $oreUsate = $this->Attivita->oreUsate($id); 
		$this->set(compact('progetti','persone','aree','oreUsate'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for attivita'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Attivita->delete($id)) {
            $fileExt=$this->UploadFiles->checkIfFileExists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'_preventivo.');
            if(!empty($fileExt)){
                unlink(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'_preventivo.'.$fileExt);
            }
			$this->Session->setFlash(__('Attivita deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Attivita was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function deleteDoc($id = null) {
        $fileExt=$this->UploadFiles->checkIfFileExists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'_preventivo.');
		unlink(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'_preventivo.'.$fileExt);
		$this->Session->setFlash(__('Documento cancellato'));
		$this->redirect($this->referer());
	}

    function suggest()
	{
        $data = array();
        if (isset($this->request->query['q']))
        {
            $this->Attivita->recursive = 0;
            $data= $this->Attivita->find('all', array(
                    'conditions' => array(
                    'Attivita.name LIKE' => '%'.$this->request->query['q'].'%',
                    ),
                    'limit' => 50,
                    'fields' => array('id', 'name'),
                ));
        }
		$res = array();

		foreach ($data as $d)
		{
			$a = new StdClass();
			$a->value = $d['Attivita']['id'];
			$a->name = $d['Attivita']['name'];
			$res[] = $a;
		}
		$this->layout = 'js';
		$this->autoLayout = false;
        $this->autoRender = false;

		echo json_encode($res);
		exit();
	}

    //Prendo la lista delle attività in json
    function getlist($recent=null){
		$res = array();
        $data = $this->Attivita->getlist($recent);

		foreach ($data as $key=>$val)
		{
			$a = new StdClass();
			$a->value = $key;
			$a->name = $val;
			$res[] = $a;
		}
		$this->layout = 'js';
		$this->autoLayout = false;
        $this->autoRender = false;

		echo json_encode($res);
		exit();
    }

    //Mostra tutte le fatture di un'attività
    function fatture($id)
    {
        $this->set('fatture', $this->Attivita->Fatturaemessa->findAllByAttivitaId($id));
        $this->set('aid', $id);
    }

    //Massimoi 3/9/13 - Restituisce il primo elemento numerico di un'array
    function _getFirstNumber($ary)
    {
        foreach ($ary as $s)
        {
            if (is_numeric($s))
            {
                return $s;
            }
        }

    }

    //Massimoi 3/9/13 - Sposta tutte le ore di un'attività verso un'altra
    //Utile nel caso di importazione che ha generato un'attività fasulla
    function merge($source=null)
    {
        $this->Attivita->recursive = -1;     
        $this->set('title_for_layout', "Merge | Attività");
        $this->set('attivita', $this->Attivita->find('list',array('cache' => 'attivita', 'cacheConfig' => 'short')));
        
        if (isset($source))
        {                 
            $this->set('source', $source);
        }
        
        if (!empty($this->data)) {
            //$source = $this->_getFirstNumber(explode(',', $this->request->data['as_values_attivita-source']));
            //$dest = $this->_getFirstNumber(explode(',', $this->request->data['as_values_attivita-dest']));           
            
            $source= $this->data['Attivita']['source'];
            $dest= $this->data['Attivita']['dest'];
            
        //TODO: Controlla che l'attività $source e $dest esistano davvero

        //I Passi:
        //1.Sposto tutte le ore che hanno attivita $source in $dest
        //2.Sposto tutte le notespese che hanno attivita $source in $dest
        //3.Sposto tutte le fattureemesse che hanno attivita $source in $dest
        //4.Aggiungo il nome di $source agli alias di $dest
        //5.Elimino $source
        $ad = $this->Attivita->findById($dest);
        $as = $this->Attivita->findById($source);        
        
        $this->Attivita->Ora->UpdateAll(array('Ora.eAttivita'=>$dest), array('Ora.eAttivita'=>$source));
        $m = "Spostate tutte le ore dall'attività $source all'attivita $dest";
        $this->log($m, 'debug');
        $message =$m . '<BR/>';

        $this->Attivita->Notaspesa->UpdateAll(array('Notaspesa.eAttivita'=>$dest), array('Notaspesa.eAttivita'=>$source));
        $m= "Spostate tutte le NoteSpese dall'attività $source all'attivita $dest";
        $this->log($m, 'debug');
        $message .= $m . '<BR/>';

        $this->Attivita->Fatturaemessa->UpdateAll(array('Fatturaemessa.attivita_id'=>$dest), array('Fatturaemessa.attivita_id'=>$source));
        $m= "Spostate tutte le Fatture dall'attività $source all'attivita $dest";
        $this->log($m, 'debug');
        $message .= $m . '<BR/>';


        //Aggiungo l'alias alla destinazione
        //TODO: Controllare che l'alias non esista già prima di aggiungere
        $ad['Alias'][] = array('name'=> $as['Attivita']['name']);
        $m="Tento di aggiungere alias dall'attività $source all'attivita $dest";
        $this->log($m, 'debug');
        $message .= $m . '<BR/>';
        $this->log($ad);
        if (!$this->Attivita->saveAll($ad))
        {
            $m= "Errore durante l'aggiunta di alias dall'attività $source all'attivita $dest" . '<BR/>';
            $this->log($m, 'debug');
            $message .= $m . '<BR/>';        
        }
        $m= "Aggiunto con succcesso alias dall'attività $source all'attivita $dest" . '<BR/>';
        $this->log($m, 'debug');
        $message .= $m . '<BR/>';

        $this->Attivita->delete($source);
        $m= "Eliminata l'attività $source" . '<BR/>';
        $this->log($m, 'debug');
        $message .= $m . '<BR/>';
        
        $this->Session->setFlash($message);
        $this->redirect(array('controller'=>'ore','action'=>'stats', '?' => array('as_values_attivita'=>$dest . ",")));
        }
        
    }
    
    
    //Stampa un preventivo dell'attività con l'indicazione delle fasi e del totale
    function preventivo($id = null)
    {
        if (!$id) {
			$this->Session->setFlash(__('Invalid attivita'));
			$this->redirect(array('action' => 'index'));
		}
        
        //Qui tiro su l'anagrafica dell'azienda che emette la fattura
        $azienda =  $this->Attivita->Persona->findById(Configure::read('iGas.idAzienda'));        
        $this->set('azienda', $azienda);
        
        $legendaCodiceiva = $this->Attivita->Faseattivita->LegendaCodiciIva->find('list',array('cache' => 'codiceiva', 'cacheConfig' => 'short'));        
        $this->set('legendacodiciiva',$legendaCodiceiva);

        $this->Attivita->Faseattivita->LegendaCodiciIva->recursive= -1;
        $ci = $this->Attivita->Faseattivita->LegendaCodiciIva->find('all');        
        $percentiva = array();
        foreach ($ci as $c)
        {
            $percentiva[$c['LegendaCodiciIva']['id']] = $c['LegendaCodiciIva']['Percentuale'];
        }
        //$this->Attivita->recursive=-1;
        //$this->Attivita->contain('Persona');
        $attivita = $this->Attivita->findById($id);
        $this->set('percentiva', $percentiva);
		$this->set('attivita', $attivita);
        
        $this->set('title_for_layout',"{$attivita['Attivita']['name']} | Offerta");      
        //8 caratteri del cliente
        $cli = str_replace(' ', '', substr($attivita['Persona']['DisplayName'], 0, 8));        
        //8 caratteri dell'attivita
        $att = str_replace(' ', '', substr($attivita['Attivita']['name'], 0, 8));
        $this->set('name', "Offerta-" . Configure::read('iGas.NomeAzienda') . "-$cli-$att-$id.pdf" );      
    }
    
    function stampa($id)
    {           
        $this->layout ='stampa';
        $this->response->type('pdf');
        $this->preventivo($id);        
        $this->render('preventivo');
		//$this->Attivita->contain('Attivita.Persona','Rigafattura','ProvenienzaSoldi','Rigafattura.Codiceiva');
        $a = $this->Attivita->findById($id);
		
        $d = new DateTime($a['Attivita']['DataPresentazione']);
        $anno = $d->format('Y');
        $progressivo = $a['Attivita']['id'];
		//8 caratteri del cliente
        $cli = str_replace(' ', '',substr($a['Persona']['DisplayName'], 0,8));
		//8 caratteri dell'attivita
		$att = str_replace(' ', '',substr($a['Attivita']['name'],0,8));
		
        $this->response->download("$anno-$progressivo-" . Configure::read('iGas.NomeAzienda')."Offerta-$cli-$att.pdf"); 
    }
	
    //Mostra l'avanzamento di una commessa, confrontando il preventivo con il consuntivo
    function avanzamento($id)
    {
        //Estraggo attività, ore, notespese e primanota dall'attivita
        $a = $this->Attivita->findById($id);
        $elencoCodici = array();
       
        $this->set('title_for_layout', "Avanzamento Attivita  - $id - " .  $a['Attivita']['name']);
        $this->set('attivita',$a);
        
        //=================== ORE =====================
        //Estraggo la ORE
        $this->set('ore', $this->Attivita->oreUsate($id));              
        $temp = $this->Attivita->Ora->find('all', array(            
                'fields' => array('faseattivita_id', 'SUM(Ora.numOre) as S'),
                'group' => array('faseattivita_id'),
                'conditions' => array('Ora.eAttivita' => $id, 'Ora.pagato !=' => 1 ),
            ));
        //Rigiro l'array in modo da renderla più facile da usare nella view
        $ore = array();
        foreach ($temp as $t)
        {
                if (isset($t['Ora']))
                {
                    $ore[$t['Ora']['faseattivita_id']] = $t[0]['S']; 
                }
                else
                {
                    $ore['']=$t[0]['S'];
                }
        }        
        $this->set('hh', $ore);
        
        //=================== NOTA SPESE =====================
        //Estraggo la nota spese
        $this->set('notaspese', $this->Attivita->notespeseDaRimborsare($id));
        
        //=================== PRIMA NOTA =====================
        //Estraggo le righe della prima nota
        $pn = array();

        $temp = $this->Attivita->Primanota->find('all', array(                
                'fields' => array('Faseattivita.id as id', 'Faseattivita.descrizione as descrizione', 'Primanota.importo'),
                //'group' => array('Primanota.faseattivita_id'),                    CON QUESTO ESTRAGGO SOLO IL PRIMO VALORE RELATIVO A CIASCUNA FASE
                'conditions' => array('Primanota.attivita_id' => $id),
            ));


        //Rigiro l'array in modo da renderla più facile da usare nella view
        foreach ($temp as $t) {
            $pn[$t['Faseattivita']['id']]['Entrate'] = 0;
            $pn[$t['Faseattivita']['id']]['Uscite'] = 0;
        }

        foreach ($temp as $t)
        {   
            if($t['Primanota']['importo'] >= 0)        
                $pn[$t['Faseattivita']['id']]['Entrate'] += $t['Primanota']['importo'];
            else 
                $pn[$t['Faseattivita']['id']]['Uscite'] += $t['Primanota']['importo'];
        }

        $legendaCodiceiva = $this->Attivita->Faseattivita->LegendaCodiciIva->find('all');

        foreach ($legendaCodiceiva as $l) {
            $elencoCodici[$l['LegendaCodiciIva']['id']] = $l['LegendaCodiciIva']['Percentuale']/100;
        }

        $elencoCodici[''] = 0;

        //MANDO ALLA VIEW UN ARRAY CHE ASSOCIA IL CODICE IVA ALLA PERCENTUALE, PER SEMPLIFICARE IL CALCOLO

        $this->set('LegendaCodiciIva',$elencoCodici);
        $this->set('pn', $pn);              

        //=================== DOCUMENTI RICEVUTI =====================
        //Estraggo le righe dei documenti ricevuti

        $dr = array();
        $temp = $this->Attivita->Fatturaricevuta->find('all', array(                
                'fields' => array('Faseattivita.id as id', 'Faseattivita.descrizione as descrizione', 'SUM(Fatturaricevuta.importo) as S'),
                'group' => array('Fatturaricevuta.faseattivita_id'),
                'conditions' => array('Fatturaricevuta.attivita_id' => $id),
            ));     
        //Rigiro l'array in modo da renderla più facile da usare nella view
        foreach ($temp as $t)
        {                
                $dr[$t['Faseattivita']['id']] = $t[0]['S']; 
        }
        $this->set('dr', $dr);
    }

	//Mostra il riassunto degli avanzamenti di tutte le commesse indicate nell'array $ids\
	function avanzamento_gen()
	{
        $conditions = array();
        $conditionsPn = array();
        $conditionsFr = array();
        $conditionsFa = array();
        $conditionsNs = array();
        $tit = '';
		
        if (!empty($this->request->named['nomeattivita']))
        {
            $conditions['Attivita.name LIKE'] = '%'. $this->request->named['nomeattivita'] .'%';
			$tit = "attività che contengono: " . $this->request->named['nomeattivita'];
        }   
        
        if (!empty($this->request->named['progetto']))
        {
            $conditions['Attivita.progetto_id'] = $this->request->named['progetto'];			
			$p = $this->Attivita->Progetto->findById($this->request->named['progetto']);
			$tit = $p['Progetto']['name'];
        }   
        
		if (!empty($this->request->named['area']))
        {
            $conditions['Attivita.area_id'] = $this->request->named['area'];			
        }  

        if (!empty($this->request->named['anno']))
        {
            $conditions['YEAR(Attivita.DataInizio)'] = $this->request->named['anno'];
        }  
		
		$this->set('title_for_layout', 'Avanzamento Generale');
		$this->Attivita->recursive = -1;
		$a = $this->Attivita->find('all', array(
						'conditions' => $conditions,
						'order' => array('Attivita.area_id', 'Attivita.name'),
				));
		
        //Calcolo le entrate in prima nota        
		$temp = $this->Attivita->Primanota->find('all', array(                
                'fields' => array('Primanota.attivita_id as id', 'SUM(Primanota.importo) as S'),
                'group' => array('Primanota.attivita_id'),
                'conditions' => array('Primanota.importo >' => 0),
            ));

        //Rigiro l'array in modo da renderla più facile da usare nella view
        foreach ($temp as $t)
        {
                $pne[$t['Primanota']['id']] = $t[0]['S']; 
        }
        
        
        //Calcolo le entrate in prima nota        
        $temp = $this->Attivita->Primanota->find('all', array(                
                'fields' => array('Primanota.attivita_id as id', 'SUM(Primanota.importo) as S'),
                'group' => array('Primanota.attivita_id'),
                'conditions' => array('Primanota.importo <' => 0),
            ));

		//Rigiro l'array in modo da renderla più facile da usare nella view
		foreach ($temp as $t)
		{
				$pnu[$t['Primanota']['id']] = $t[0]['S']; 
		}		

       //Calcolo i documenti ricevuti
        $temp = $this->Attivita->Fatturaricevuta->find('all', array(                
                'fields' => array('Fatturaricevuta.attivita_id as id', 'SUM(Fatturaricevuta.importo) as S'),
                'group' => array('Fatturaricevuta.attivita_id'),      
                'conditions' => array('Fatturaricevuta.pagato' => 0),        
            ));

        //Rigiro l'array in modo da renderla più facile da usare nella view
        foreach ($temp as $t)
        {
                $docric[$t['Fatturaricevuta']['id']] = $t[0]['S']; 
        }       

        //Calcolo le fasi in entrata
		$temp = $this->Attivita->Faseattivita->find('all', array(                
                'fields' => array('Faseattivita.attivita_id', 'SUM(Faseattivita.qta * Faseattivita.costou) as S'),
                'group' => array('Faseattivita.attivita_id'),
                'conditions' => array('Faseattivita.entrata' => 1),
            ));					
		//Rigiro l'array in modo da renderla più facile da usare nella view
		foreach ($temp as $t)
		{
				$fentrate[$t['Faseattivita']['attivita_id']] = $t[0]['S']; 
		}
		
        //Calcolo le fasi in uscita        
        $temp = $this->Attivita->Faseattivita->find('all', array(                
                'fields' => array('Faseattivita.attivita_id', 'SUM(Faseattivita.qta * Faseattivita.costou) as S'),
                'group' => array('Faseattivita.attivita_id'),
                'conditions' => array('Faseattivita.entrata' => 0),
            ));                 
        //Rigiro l'array in modo da renderla più facile da usare nella view
        foreach ($temp as $t)
        {
                $fuscite[$t['Faseattivita']['attivita_id']] = $t[0]['S']; 
        }

		$temp = $this->Attivita->Notaspesa->find('all', array(           
                'fields' => array('Attivita.id', 'SUM(Notaspesa.importo) as S'),
                'group' => array('Notaspesa.eAttivita'),
                'conditions' => array('Notaspesa.rimborsato' => 0),
            ));			
		//Rigiro l'array in modo da renderla più facile da usare nella view
		foreach ($temp as $t)
		{
				$ns[$t['Attivita']['id']] = $t[0]['S']; 
		}
		
        $temp = $this->Attivita->Ora->find('all', array(            
                'fields' => array('Attivita.id', 'SUM(Ora.numOre) as S'),
                'group' => array('Ora.eAttivita'),
                'conditions' => array('Ora.pagato' => 0),
            ));
		//Rigiro l'array in modo da renderla più facile da usare nella view
		foreach ($temp as $t)
		{
				$ore[$t['Attivita']['id']] = $t[0]['S']; 
		}
		


		$temp = $this->Attivita->Area->find('all', array(
					'recursive' => -1,
					));
		foreach ($temp as $t)
		{
				$aree[$t['Area']['id']] = $t['Area']['name']; 
		}
		//Se c'è l'area, l'aggiungo al titolo
		if (!empty($this->request->named['area']))
		{
			$tit .= 'Area: ' .  $aree[$this->request->named['area']];
		}
		
		$this->set(compact('a','pnu','pne','fentrate','fuscite','ns','ore','aree','tit','docric'));		
	}
	
	function attivita_fasi()
	{
		$this->set('title_for_layout', 'Avanzamento Generale');
		$this->Attivita->recursive = 1;
		$a = $this->Attivita->find('all', array(
						'order' => array('Attivita.area_id', 'Attivita.name'),
				));
				
		$this->set('attivita', $a);
	}

    public function ultimemodifiche() {

        $lastmodified = array();

        $res = $this->Attivita->find('all', array(
                                                    'fields' => array('Attivita.name', 'Attivita.modified'),
                                                    'limit' => '10',
                                                    'order' => array('Attivita.modified' => 'desc')));

        foreach ($res as $r) {
            
            $lastmodified[$r['Attivita']['id']]['Nome'] = $r['Attivita']['name'];
            $lastmodified[$r['Attivita']['id']]['Modifica'] = $r['Attivita']['modified'];
        }

        return $lastmodified;
    }

}
?>
