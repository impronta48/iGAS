<?php
App::uses('AppController', 'Controller');
class NotaspeseController extends AppController {
	
    public $components = array('RequestHandler', 'UploadFiles', 'GoogleDrive');
    public $helpers = array('Tristate', 'Table');
    
    private function getConditionFromQueryString()
    {
       $conditions = array();
       $attivita="";
       $persone="";
       
       if(isset($this->request->query['persone']))
        {
            $persone = $this->request->query['persone'];                        
            //Se la stringa è vuota non devo mettere la condizione
            if (!empty($persone))                
            {   
                if (is_numeric($persone))
                {
                    $persone = array($persone);
                }
                $conditions['Notaspesa.eRisorsa IN'] = $persone;
                
            }
        }

        if (!empty($this->request->query['attivita']))
        {
            $attivita = $this->request->query['attivita'];            
            //Se la stringa è vuota non devo mettere la condizione
            if (!empty($attivita))
            {
                if (is_numeric($attivita)) 
                {
                    $attivita = array($attivita);                
                }
                if (is_array($attivita)) $conditions['Notaspesa.eAttivita IN'] = $attivita;                
            }
        }
        if (!empty($this->request->query['faseattivita_id']))
        {
            $conditions['Notaspesa.faseattivita_id IN'] = $this->request->query['faseattivita_id'];
        }

        if (!empty($this->request->query['from']))
        {
            $conditions['Notaspesa.data >='] = $this->request->query['from'];
            
        }
        if (!empty($this->request->query['to']))
        {            
            $conditions['Notaspesa.data <='] = $this->request->query['to'];
        }
        
        $this->set('attivita_selected', $attivita);
        $this->set('persona_selected', $persone);

        return $conditions;
    }


	//display statistics about 'notaspese'
	public function stats()
	{
        $this->Notaspesa->recursive = -1;     
        
        $conditions = $this->getConditionFromQueryString();


        //result1: get total importo of 'nota spese' according to search criteria
        $result1 = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'SUM(Notaspesa.importo) as importo'
                )
            )
        );
        //result2: get total importo of 'notaspese' according to search criteria grouped by attivita
        $result2 = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'contain' => array('Attivita.name'),
                'fields' => array(
                    'Notaspesa.eAttivita, SUM(Notaspesa.importo) as importo'
                ),
                'group' => array(
                    'Notaspesa.eAttivita'
                )
            )
        );
        //result3: get total importo of 'notaspese' according to search criteria grouped by risorsa (persona)
        $result3 = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'contain' => array('Persona.displayname'),
                'fields' => array(
                    'Notaspesa.eRisorsa, SUM(Notaspesa.importo) as importo, Persona.DisplayName'
                ),
                'group' => array(
                    'Notaspesa.eRisorsa'
                )
            )
        );
        //result4: get total importo of 'notaspese' according to search criteria grouped by attivita, risorsa (persona)
        $result4 = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'contain' => array('Persona.displayname','Attivita.name'),
                'fields' => array(
                    'Notaspesa.eAttivita, Notaspesa.eRisorsa, SUM(Notaspesa.importo) as importo, Persona.DisplayName'
                ),
                'group' => array(
                    'Notaspesa.eAttivita',
                    'Notaspesa.eRisorsa'
                ),
                'order' => array(
                    'Notaspesa.eRisorsa',
                    'Notaspesa.eAttivita'
                )
            )
        );

        $this->set('result1', $result1);
        $this->set('result2', $result2);
        $this->set('result3', $result3);
        $this->set('result4', $result4);

        $attivita_list = $this->Notaspesa->Attivita->getlist();
        $this->set('attivita_list', $attivita_list);

        $persona_list = $this->Notaspesa->getPersone();
        $this->set('persona_list', $persona_list);
        
        $fa = $this->Notaspesa->Faseattivita->getSimple();
        $this->set('faseattivita', $fa); 
        
        $this->set('title_for_layout', "Statistiche Note Spese");        
	}

	//returns an associative array of 'attivita' with indication of the name of parent 'progetto'
	function _getAttivitaListGroupedByProgetto() {
		$this->loadModel('Attivita');
		$attivita = $this->Attivita->find(
			'all', 
			array(
				'fields' => array('Attivita.id', 'Attivita.name', 'Progetto.name'),
				'order' => array('Attivita.progetto_id', 'Attivita.name')
		));
	
		$attivitaGrouped = array();
		foreach($attivita as $a) {
			if(!isset($attivitaGrouped[ $a['Progetto']['name'] ])) $attivitaGrouped[ $a['Progetto']['name'] ] = array();
			array_push($attivitaGrouped[ $a['Progetto']['name'] ], $a);
		}

		return $attivitaGrouped;
	}
	
	function add($id = null){
		//debug($this->Session->read('notaspeseUploadReferer'));
		//debug($this->Session->read('scontrinoIdToUpload'));
        $persona=1;
        $anno=date('Y');
        $mese=date('M');
        $giorno=1;
        $attivita=1;        
        $destinazione='';        
        
        //Preparo il filtro per il riepilogo delle note spese
        $conditions = array();
        $this->set('title_for_layout', 'Aggiungi Nota Spese');
        

        //Parametri passati per nome
        if (isset($this->request->params['named']['persona']))
        {
            $persona= $this->request->params['named']['persona'];
            $conditions['Notaspesa.eRisorsa'] =$persona;
        }
        if (isset($this->request->params['named']['anno']))
        {
            $anno= $this->request->params['named']['anno'];
            $conditions['YEAR(data)'] = $anno;
        }
        if (isset($this->request->params['named']['mese']))
        {
            $mese= $this->request->params['named']['mese'];
            $conditions['MONTH(data)'] = $mese;
        }
        if (isset($this->request->params['named']['giorno']))
        {
            $giorno= $this->request->params['named']['giorno'];
            $conditions['DAY(data)'] = $giorno;
        }
        if (isset($this->request->params['named']['attivita']))
        {
            $attivita= $this->request->params['named']['attivita'];
            $conditions['Notaspesa.eAttivita'] = $attivita;
        }        
        if (isset($this->request->params['named']['dest']))
        {
            $destinazione= $this->request->params['named']['dest'];            
        }        
        
        //Parametri passati per query string (dopo innovazioni di filippo)
        if (isset($this->request->query['persona']))
        {
            $persona= $this->request->query['persona'];
            $conditions['Notaspesa.eRisorsa'] =$persona;
        }
        
        if ($persona != $this->Session->read('Auth.User.persona_id') && 
            Auth::hasRole(Configure::read('Role.impiegato')) )
        {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(array('action' => 'scegli_mese',$this->Session->read('Auth.User.persona_id') ));   
        }

        if (isset($this->request->query['anno']))
        {
            $anno= $this->request->query['anno'];
            $conditions['YEAR(data)'] = $anno;
        }
        if (isset($this->request->query['mese']))
        {
            $mese= $this->request->query['mese'];
            $conditions['MONTH(data)'] = $mese;
        }
        if (isset($this->request->query['giorno']))
        {
            $giorno= $this->request->query['giorno'];
            $conditions['DAY(data)'] = $giorno;
        }
        if (isset($this->request->query['attivita']))
        {
            $attivita= $this->request->query['attivita'];
            $conditions['Notaspesa.eAttivita'] = $attivita;
        }        
        if (isset($this->request->query['dest']))
        {
            $destinazione= $this->request->query['dest'];            
        }    

		//Mi hanno chiamato per salvare
		if (!empty($this->data)) {		
			if ($this->Notaspesa->save($this->data)) {
                
				$this->Session->setFlash('NotaSpesa salvata con successo');
                $anno = $this->data['Notaspesa']['data']['year'];
                $mese = $this->data['Notaspesa']['data']['month'];
                $giorno = $this->data['Notaspesa']['data']['day'];
                $attivita = $this->data['Notaspesa']['eAttivita'];
                $persona = $this->data['Notaspesa']['eRisorsa'];
                $destinazione = $this->data['Notaspesa']['destinazione'];
				
				if(!$id){
					//Prendo l'id legato al salvataggio
					$id = $this->Notaspesa->getLastInsertID();
				}
				// Qua gestisco l'upload del documento su filesystem
				$uploaded_file=$this->request->data['Notaspesa']['uploadFile'];
				$uploadError=$this->UploadFiles->upload($id,$uploaded_file,$this->request->controller);
				if(strlen($uploadError)>0){
					$this->Flash->error(__($uploadError));
				}

                //A seconda del submit premuto vado nella direzione opportuna
                if (isset($this->request->data['submit-ore'] ))
                {
                   $this->redirect(array('controller' => 'ore',  'action' => 'add', 'persona'=>$persona,'attivita'=>$attivita,'anno'=>$anno,'mese'=>$mese,'giorno'=>$giorno));
                }
                else
                {
                   $this->redirect(array('action' => 'add', 'persona'=>$persona,'attivita'=>$attivita,'anno'=>$anno,'mese'=>$mese,'giorno'=>$giorno,'dest'=>$destinazione));
                   //$this->redirect(array('action' => 'add', 'persona'=>$persona,'anno'=>$anno,'mese'=>$mese));
                }

			} else {
				$this->Session->setFlash('Errore durante il salvataggio della trasferta.', '/pages/home');
			}
		} else //Mi hanno chiamato in lettura
		{	           
            $this->set('eAttivita', $this->Notaspesa->Attivita->getlist());
            
            //Se sono un impiegato posso vedere solo le mie ore
            if ( Auth::hasRole(Configure::read('Role.impiegato')) )
            {
                $this->set('eRisorse', $this->Notaspesa->Persona->find('list', array(
                        'conditions' => array('id' => $persona))));
            }
            else
            {
                $this->set('eRisorse', $this->Notaspesa->Persona->find('list',array('cache' => 'persona', 'CacheConfig' => 'short')));
            }

            $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all',array('cache' => 'legendamezzi', 'cacheConfig' => 'long')));
            $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list',array('conditions' => array('not' => array('voceNotaSpesa' => NULL)),
                             'cache' => 'legendacatspesa_notnull', 'cacheConfig' => 'short')));
            $this->set('eProvSoldi', $this->Notaspesa->Provenienzasoldi->find('list',array('cache' => 'provenienzasoldi', 'cacheConfig' => 'long')));
            $this->set('eRisorsa', $persona);
            $this->set('attivita_default', $attivita);
            $this->set('anno', $anno);
            $this->set('mese',$mese);            
            $this->set('giorno',$giorno);
            $this->set('destinazione',$destinazione);
		}
        
		//Massimoi: 28/1/2014
        //Riporto sempre tutte le ore caricate in questo mese sotto il form                
        $result = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                   'id','Notaspesa.eRisorsa', 'importo', 'data', 'descrizione', 'origine',
                   'destinazione','km', 'eAttivita','LegendaCatSpesa.name', 'fatturabile', 'rimborsabile', 'provenienzasoldi_id', 'faseattivita_id','Faseattivita.Descrizione',                    
                ),
                'order' => array('Notaspesa.eRisorsa',  'data'),                
            )
        );
        
       $this->set('result', $result); 
	}
    
    //Wrapper per la funzione edit
    function edit($id) {       

        if (!empty($this->request->data)) {

            //debug($this->request->data); die

                if ($this->Notaspesa->save($this->request->data, false)) {
                    $this->Session->setFlash('Notaspese Modificata correttamente.');
					/*
					//Non ha senso mettere l'upload scontrino anche qua, in realtà quando fai edit dalla view edit
					//il form ti rimanda al metodo add di questo controller....
					$uploaded_file=$this->request->data['Notaspesa']['uploadFile'];
					$uploadError=$this->UploadFiles->upload($id,$uploaded_file,$this->request->controller);
					if(strlen($uploadError)>0){
						$this->Flash->error(__($uploadError));
					}
					*/
                } 
                else {
                    $this->Session->setFlash('Impossibile salvare questa notaspese.');
                    debug($this->Notaspesa->validationErrors);  
                }
             
        }
		$this->data = $this->Notaspesa->findById($id);
		$this->set('id', $id);
		$this->set('eAttivita', $this->Notaspesa->Attivita->getlist());
		$this->set('eRisorse', $this->Notaspesa->Persona->find('list',array('cache' => 'persona', 'cacheConfig' => 'short')));
		$this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all',array('cache' => 'legendamezzi', 'cacheConfig' => 'short')));
		$this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list',array('cache' => 'legendacatspesa_notnull', 'cacheConfig' => 'short')));
        $this->set('eProvSoldi', $this->Notaspesa->Provenienzasoldi->find('list',array()));			

    }
    
    //Funzione che wrappa detail ma chiama una vista che permette di modificare
    function edit_list() {
        $persona=8571;
        $anno=date('Y');
        $mese=date('m');
        $giorno=date('d');
        $attivita=1;        
		$this->Notaspesa->recursive = -1;
		
        //Preparo il filtro per il riepilogo delle ore
        $conditions = array();    

        //
        if (empty($this->request->params['named']))
        {
              $this->Session->setFlash('Ti consiglio di invocare questa funzione passando dal menu a sinistra '
                            . Router::url(array('action'=>'scegli_persona'))
                            . '   per non rischiare di fare confusione e caricare le spese a nome di altri. ');
              $this->redirect(array('action'=>'scegli_persona'));
        }

        if (isset($this->request->params['named']['persona']))
        {
            $persona= $this->request->params['named']['persona'];
            $conditions['Notaspesa.eRisorsa'] =$persona;
        }
        if (isset($this->request->params['named']['anno']))
        {
            $anno= $this->request->params['named']['anno'];
            $conditions['YEAR(data)'] = $anno;
        }
        if (isset($this->request->params['named']['mese']))
        {
            $mese= $this->request->params['named']['mese'];
            $conditions['MONTH(data)'] = $mese;
        }    
        if (isset($this->request->params['named']['giorno']))
        {
            $giorno= $this->request->params['named']['giorno'];
            //In realtà non voglio filtrare per il giorno, ma solo portarmelo dietro
            //$conditions['DAY(data)'] = $giorno;
        }
        if (isset($this->request->params['named']['attivita']))
        {
            $attivita= $this->request->params['named']['attivita'];
            //$conditions['Ora.eAttivita'] = $attivita;
        }        
        
        $this->set('attivita_list', $this->Notaspesa->Attivita->getlist());
        $this->set('eRisorse', $this->Notaspesa->Persona->find('list',array('cache' => 'persona', 'cacheConfig' => 'short')));
        $this->set('eRisorsa', $persona);
        $this->set('anno', $anno);
        $this->set('mese',$mese);
        $this->set('giorno',$giorno);
                
		$this->Notaspesa->contain('LegendaCatSpesa', 'Faseattivita');
        $result = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                   'id','Notaspesa.eRisorsa', 'importo', 'data', 'descrizione', 'origine',
                   'destinazione','km', 'eAttivita','LegendaCatSpesa.name', 'fatturabile', 'rimborsabile', 'faseattivita_id','Faseattivita.Descrizione',                    
                ),
                'order' => array('Notaspesa.eRisorsa',  'data'),				
            )
        );
		
        $this->set('result', $result);        
        $this->set('title_for_layout', "Modifica Nota Spese");   
        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all',array('cache' => 'legendamezzi', 'cacheConfig' => 'short')));
    }
    
    //Manda o salva un pezzo di form che corrisponde ad una riga di strasferta
    function edit_riga()
    {
        $this->request->onlyAllow('ajax');
        $this->layout = 'ajax';
        $this->autoRender = false;
		
        $giorno=date('d');
        $attivita=1;   
        $dest = '';
        
        //Guardo se mi hai già passato un ID e lo memorizzo
        if (isset($this->request->query['id']))
        {
            $id = $this->request->query['id'];
        }
         if (isset($this->request->params['named']['attivita']))
        {
            $attivita= $this->request->params['named']['attivita'];
        }      
        if (isset($this->request->params['named']['dest']))
        {
            $dest= $this->request->params['named']['dest'];
        }      
        if (isset($this->request->params['named']['giorno']))
        {
            $giorno= $this->request->params['named']['giorno'];
            //In realtà non voglio filtrare per il giorno, ma solo portarmelo dietro
            //$conditions['DAY(data)'] = $giorno;
        }   
        //Mi hanno chiamato per salvare        
		if (!empty($this->data)) {		
			if (!$this->Notaspesa->save($this->data))  {
				$this->set('error','Errore durante il salvataggio della trasferta.');
			}
            else {  
                //Se ha salvato correttamente restituisco la riga non in edit
                $this->data = $this->Notaspesa->read();
                $this->set('data',$this->data);
                $this->render('view_riga');  
            }
		}       
        else
        {
            //Se c'è già un ID devo prima leggere i valori e poi generale il form                    
            if (!empty($id))
            {                             
                 $this->Notaspesa->id = $id;
                 $this->data = $this->Notaspesa->read();
            }
            //Preparo i paremetri da passare alla view per visualizzare/modificare il risultato
            $this->set('eAttivita', $this->Notaspesa->Attivita->getlist());						
            $this->set('eRisorse', $this->Notaspesa->Persona->find('list',array('cache' => 'persona', 'cacheConfig' => 'short')));
            $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all',array('cache' => 'legendamezzi', 'cacheConfig' => 'short')));
            $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list',array('cache' => 'legendacatspesa', 'cacheConfig' => 'short')));            
            $this->set('attivita_default', $attivita);            
            $this->set('dest', $dest);
            $this->set('giorno', $giorno);
            $this->render('edit_riga');  
			//Todo: non viene gestita la fase, se la perde ad ogni edit!
        }                
    }
	
	public function setUploadToDrive($id = null) {
		$this->Session->write('scontrinoIdToUpload', $id);
		$refPage=explode($this->request->params['controller'],$this->referer());
		$this->Session->write('notaspeseUploadReferer', '/'.$this->request->params['controller'].$refPage[1]);
		$this->redirect(array('controller' => 'notaspese', 'action' => 'uploadToDrive'));
	}
	
	public function uploadToDrive() {
		//$this->Session->setFlash(__($this->GoogleDrive->echoCurrentUrl()));
		//$this->GoogleDrive->getController($this);//Cercavo di passare l'oggetto Controller al Component per poter poi fare $this->Controller->redirect nel Component
		$id=$this->Session->read('scontrinoIdToUpload');//Se qua faccio $this->Session->consume $id non viene valorizzato. Questo è assurdo.
		$fileToUpload=WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'.pdf';
		//$this->Session->delete('scontrinoIdToUpload');//Se deleto questa $id della riga sopra diventa null. Questo è assurdo.
		$googleApiObj=new Google_Client;
		$googleApiObj->setApplicationName(Configure::read('iGas.NomeAzienda'));
		//$googleApiObj->setDeveloperKey(Configure::read('google_key'));
		$oauth_creds=Configure::read('google.oauth');
		$googleApiObj->setAuthConfig($oauth_creds);
		//$googleApiObj->setAccessType('offline');
		//Uncomment this following 2 lines to upload to Drive
		$googleApiObj->addScope(Google_Service_Drive::DRIVE);
		$googleService = new Google_Service_Drive($googleApiObj);
		//Uncomment this following 2 lines to send mails through gmail
		//$googleApiObj->setScopes(Google_Service_Gmail::GMAIL_COMPOSE);
		//$googleService = new Google_Service_Gmail($googleApiObj);
		$redirect_uri = Router::url(null, true);
		$googleApiObj->setRedirectUri($redirect_uri);
		//debug($this->request->query);
		//debug($redirect_uri);
		if (isset($this->request->query['code'])) {
			$token = $googleApiObj->fetchAccessTokenWithAuthCode($this->request->query['code']);
			//debug($token);
			$googleApiObj->setAccessToken($token);
			$this->Session->write('upload_token', $token);
			//$this->redirect(filter_var($redirect_uri, FILTER_SANITIZE_URL));
		} else {
			$auth_url = $googleApiObj->createAuthUrl();
			debug($auth_url);
			//$this->redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
			$this->redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
		}
		$result=$this->GoogleDrive->upload($googleService,$fileToUpload,Configure::read('google.drive.notaspese'));
		//$result=$this->GoogleMail->sendMessage($googleService,'me');
		$this->Session->setFlash(__($result));
		$this->redirect($this->Session->consume('notaspeseUploadReferer'));
	}
    
    private function _decode_tristate(&$conditions, $param)
    {
        if ($this->request->query($param) !=null) {

            if ($this->request->query($param) >=0 ) {

                $testo = 'Notaspesa.'.$param;
                $conditions[$testo] = $this->request->query[$param];

            }
            //Se è < 0 non metto proprio la condizione (=indefinito)
        }

    }

    //Funzione analoga a stats ma restituise il dettaglio, dati i parametri
    function detail()
    {
        
        $attivita= '';
        $persone= '';
        $faseattivita= '';
        $conditions = $this->getConditionFromQueryString();

        $this->_decode_tristate($conditions, 'fatturato');
        $this->_decode_tristate($conditions, 'fatturabile');
        $this->_decode_tristate($conditions, 'rimborsato');
        $this->_decode_tristate($conditions, 'rimborsabile');

        $result = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                   'id', 'Notaspesa.eRisorsa', 'importo', 'data', 'descrizione', 'origine', 
                    'destinazione', 'Faseattivita.descrizione', 'km', 'eAttivita', 'LegendaCatSpesa.name', 'rimborsato', 'fatturato',
						'rimborsabile', 
                        'fatturabile'
                ),
                'order' => array('Notaspesa.eRisorsa', 'data'),
            )
        );
       $this->set('result', $result); 
       
       //Queste mi servono per scrivere il nome dell'attività invece del numero       
        $attivita_list = $this->Notaspesa->Attivita->getlist();
        $this->set('attivita_list', $attivita_list);

        $fa = $this->Notaspesa->Faseattivita->getSimple();
        $this->set('faseattivita_list', $fa);     

        $persona_list = $this->Notaspesa->getPersone();
        $this->set('persona_list', $persona_list);

        //Mi servono per poter implementare l'autocompletamento nel form
        $this->set('attivita_selected', $attivita);
        $this->set('faseattivita_selected', $faseattivita);
        $this->set('persona_selected', $persone);
        $this->set('eProvSoldi', $this->Notaspesa->Provenienzasoldi->find('list',array()));
        
        $this->set('title_for_layout', "$attivita | $persone | Dettaglio Nota Spese");        
    }

    public function delete($id, $dest=null) {
        $this->autoRender = false; 
        if (!$id) {
			$this->Session->setFlash(__('Invalid id for Notaspese'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Notaspesa->delete($id)) {
			unlink(WWW_ROOT.'files/'.$this->request->controller.'/'.$id.'.pdf');
			$this->Session->setFlash(__('Notaspese deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Notaspese was not deleted'));
		$this->redirect(array('action' => 'index'));
    }
	
	public function deleteDoc($id = null) {
		unlink(WWW_ROOT.'files/'.$this->request->controller.'/'.$id.'.pdf');
		$this->Session->setFlash(__('Documento cancellato'));
		$this->redirect($this->referer());
	}

    public function duplicate($id) {

        $this->autoRender = false; 

        $row = $this->Notaspesa->findById($id);

        $row["Notaspesa"]["id"] = null;
        $this->Notaspesa->create(); 
        $this->Notaspesa->save($row);

        $this->redirect($this->referer());
    }
	
	//Genera la notaspese in un formato adatto alla stampa
	public function stampa() {	

		if (!isset($this->request->data['Notaspesa']))
		{
			$ids = $this->Session->read('idnotaspese');		
		}
		else		
		{
			$ids = array_keys(	$this->request->data['Notaspesa']  );	
		}   	
		
		$righens = $this->Notaspesa->find('all', array(
				'conditions' => array('Notaspesa.id IN' => $ids),
				'order' => array('Notaspesa.data'),
			));		
		$this->set('notaspese', $righens);
		
		//Qui tiro su l'anagrafica dell'azienda che emette la fattura
        $azienda =  $this->Notaspesa->Persona->findById(Configure::read('iGas.idAzienda'));
        $this->set('azienda', $azienda);
		
		//Scrivo come destinatario della nota spese il cliente della prima attività
		$cliente_id = $righens[0]['Attivita']['cliente_id'];
		$cliente = $this->Notaspesa->Persona->findById($cliente_id);

		$this->set('cliente', $cliente['Persona']);
		
        $this->Session->write('idnotaspese', $ids);
        $this->set('name', Configure::read('iGas.NomeAzienda') . "-NotaSpese.pdf");
    }

    public function stampa_collaboratore()
    {       
        if (!isset($this->request->data['Notaspesa']))
        {
            $ids = $this->Session->read('idnotaspese');     
        }
        else        
        {
            $ids = array_keys(  $this->request->data['Notaspesa']  );   
        }       
        
        $righens = $this->Notaspesa->find('all', array(
                'conditions' => array('Notaspesa.id IN' => $ids),
                'order' => array('Notaspesa.data'),
            ));     
        $this->set('notaspese', $righens);
        
        //Qui tiro su l'anagrafica dell'azienda che emette la fattura
        $azienda =  $this->Notaspesa->Persona->findById(Configure::read('iGas.idAzienda'));
        $this->set('azienda', $azienda);
        
        //Scrivo come destinatario della nota spese il cliente della prima attività
        $cliente_id = $righens[0]['Attivita']['cliente_id'];
        $cliente = $this->Notaspesa->Persona->findById($cliente_id);
        $this->set('cliente', $cliente['Persona']);
        
        $this->Session->write('idnotaspese', $ids);
        $this->set('name', Configure::read('iGas.NomeAzienda') . "-NotaSpese-Collaboratore.pdf");
    }
    
    public function scegli_persona()
    {

        //Se sono impiegato voglio vedere solo me stesso
        if (Auth::hasRole(Configure::read('Role.impiegato')))
        {
            return $this->redirect(array('action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')));
        }
        else
        {
            $conditions['YEAR(data)'] = date('Y');    
        }

        $persone = $this->Notaspesa->find('all', array(
                                        'conditions' => $conditions,
                                        'fields' => array('DISTINCT Persona.id', 'Persona.Cognome', 'Persona.Nome')
        ));

        $anni = $this->Notaspesa->find('first', array('fields' => array('DISTINCT YEAR(data) as Anno'), 'order' => 'Anno'));

        $this->set('eRisorsa', $this->Notaspesa->Persona->find('list',array('cache' => 'persona', 'cacheConfig' => 'short')));
        $this->set('persone', $persone);
        $this->set('annomin', $anni[0]);
        $this->set('title_for_layout', 'Scegli Persona | NotaSpese ' );
        if ($this->request->is('post')) {
            return $this->redirect(array('action' => 'scegli_mese', $this->request->data['Notaspesa']['eRisorsa']));
        }
    }

    public function redirect_to_add() {
        $persona = $this->request->params['named']['persona'];
        $anno = $this->request->query['anno']['year'];
        $mese = $this->request->query['mese'];

        $this->redirect(array('action' => 'add', 'persona' => $persona, 'anno' => $anno, 'mese' => $mese));
    }

    public function scegli_mese($persona=null)
    {
        
        if (is_null($persona))
        {
            return $this->redirect(array('action' => 'scegli_persona'));
        }

        if ($persona != $this->Session->read('Auth.User.persona_id') && 
                Auth::hasRole(Configure::read('Role.impiegato')) )
        {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(array('action' => 'scegli_mese',$this->Session->read('Auth.User.persona_id') ));   
        }

        $this->set('persona', $this->Notaspesa->Persona->findById($persona));
        $this->set('title_for_layout', 'Scegli Mese | NotaSpese ' . $persona );
    }
    
    //Considera pagate una serie di ore, e quindi le toglie dal calcolo dell'avanzamento
    public function rimborsa($val)
    {
        $this->request->allowMethod('ajax', 'post');
        $this->autoRender = false;        
        $ns = $this->request->data['Notaspesa'];
     
        if ($val == 'set')
        {
            $val = 1;
        }
        else
        {
            $val = 0;
        }
        
        //Estraggo tutti gli id delle ore da aggiornare
        $ids = array_keys($ns);
        
        //Faccio un aggiornamento unico
        $this->Notaspesa->updateAll(
            array('Notaspesa.rimborsato' => $val),
            // conditions
            array('Notaspesa.id' => $ids)
        );
        
        $this->Session->setFlash('Le notespese selezionate sono considerate rimborsate');
    }
}
?>
