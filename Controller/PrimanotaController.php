<?php
class PrimanotaController extends AppController {
    public $helpers = ['Cache','PhpExcel.PhpSpreadsheet']; 
	public $cacheAction = "1 day";
    public $components = ['DataTable', 'Paginator', 'UploadFiles'];
	public $paginate = [
        'limit' => 50,
    ];

    public function pnlist()
    {
        $this->DataTable->mDataProp = true;
        $this->set('response', $this->DataTable->getResponse());
        $this->set('_serialize','response');
    }

    function index($id=NULL)
    {
        $this->Primanota->recursive=0;
        $this->Primanota->Fatturaemessa->Behaviors->load('Containable');
        $from = '';
        $to ='';
        $this->Cookie->name = str_replace(  ' ',
                                            '',
                                            'igas_primanota_' . Configure::read('iGas.NomeAzienda')
                                             );
        $conditions = [];

        //Se salvo il form iniziale passo da qui
        if (!empty($this->request->data))
        {

            $this->_gestioneImporto();

            //Salvo il risultato
            if ($this->Primanota->save($this->request->data)) {
				$id = $this->Primanota->getLastInsertID();
				// Qua gestisco l'upload del documento
				$uploaded_file=$this->request->data['Primanota']['uploadFile'];
				$uploadError=$this->UploadFiles->upload($id,$uploaded_file,$this->request->controller);
				if(strlen($uploadError)>0){
					$this->Flash->error(__($uploadError));
				}
                $this->Session->setFlash('PrimaNota Salvata con Successo');
            }
            else {
                $this->Session->setFlash('Errore durante il salvataggio della Prima Nota');
            }
        }

        $this->_preparaDropDown();

        //Leggo tutti i parametri in variabili
        $attivita_id= $id;
        $campi = ['attivita' =>['db'=> 'Primanota.attivita_id', 'valore'=>null],
                  'persona' => ['db' => 'Primanota.persona_id', 'valore' => null],
                  'provenienzasoldi' => ['db' => 'Provenienzasoldi.id', 'valore' => null],
                  'fase' => ['db' => 'Primanota.faseattivita_id', 'valore' => null],
                  'from' => ['db' => 'Primanota.data >=', 'valore' => null],
                  'to' => ['db' => 'Primanota.data <=', 'valore' => null],
                  'legenda_cat_spesa' => ['db' => 'Primanota.legenda_cat_spesa_id', 'valore' => null],
                  'progetto' => ['db' => 'Attivita.progetto_id', 'valore' => null]
                ];
        $valorizzato = false;   //il form ha qualche campo settato o è tutto vuoto (in questo caso leggo dal cookie)
        //Leggo tutti i valori dalla querystring
        foreach ($campi as $c=>$v) {
            $campi[$c]['valore'] = $this->request->query($c);
            if (!empty($campi[$c]['valore']))
            {
                $valorizzato = true;
            }
        }

        //eccezione: per ragioni storiche accetto il doppio tipo di parametro
        if (empty($id))
        {
            $attivita_id = $this->request->query('attivita');
        }

        //Se non ci sono parametri prendo dal cookie, se ce n'è anche solo uno uso quello
        if (!$valorizzato)
        {
            $cookieprep = $this->Cookie->read('Primanota.filtro');
            foreach ($campi as $c => $v)
            {
                $campi[$c]['valore'] = $this->getCookieValue($cookieprep, $c);
            }
        }

        //Imposto le condizioni per il filtro
        foreach ($campi as $c => $v) {
            if (!empty($campi[$c]['valore'])) {
                $conditions[$campi[$c]['db']] = $campi[$c]['valore'];
                $cookieprep[$c] = $campi[$c]['valore'];

            }
            $this->set("v_$c", $campi[$c]['valore']);
        }
        //Salvo un cookie con il filtro impostato
        $this->Cookie->write('Primanota.filtro', $cookieprep, false, '365 days');

        $this->set('primanota', $this->Primanota->find('all',
                        ['conditions'=>$conditions,
                              'order'=>['Primanota.data DESC'],
                             ]
                  ));

        //Leggo tutti i tag e li porto alla view
        $fields=['name'];

        //TODO: Potrei filtrare TAG con un prefisso (es: R.), ma devo capire come salvare i tag di questo tipo con un prefisso
        //$t = $this->Primanota->Tag->find('all', array('fields'=>$fields, 'recursive'=>-1, 'conditions'=> array('name LIKE'=> 'R%')));
		$t = $this->Primanota->Tag->find('all', ['fields'=>$fields, 'recursive'=>-1]);
        $taglist = [];
        foreach($t as $t1)
        {
            $taglist[]= $t1['Tag']['name'];
        }
        natcasesort($taglist);
        $this->set('taglist', $taglist);

        $this->set('persone',$this->Primanota->Persona->find('list'));
        $this->set('name', "PrimaNota-$from-$to-" . Configure::read('iGas.NomeAzienda') . "");
    }

    //Verifica se un valore c'è nel cookie e poi lo salva
    private function getCookieValue($cookieprep, $name)
    {
        if (isset($cookieprep[$name])) {
            return $cookieprep[$name];
        }
        return null;
    }

    function edit($id =null)
    {
        if (!$id) {
			$this->Session->setFlash(__('Invalid id for fatturaemessa'));
			$this->redirect($this->referer());
		}

		if (!empty($this->request->data)) {
            $this->_gestioneImporto();
			if ($this->Primanota->save($this->request->data)) {
				// Qua gestisco l'upload del documento
				$uploaded_file=$this->request->data['Primanota']['uploadFile'];
				$uploadError=$this->UploadFiles->upload($id,$uploaded_file,$this->request->controller);
				if(strlen($uploadError)>0){
					$this->Flash->error(__($uploadError));
				}
				$this->Session->setFlash('Riga di Prima Nota salvata con successo');
				$attivita_id = $this->request->data['Primanota']['attivita_id'];
                $this->redirect(['controller'=>'primanota','action'=>'index']);

			} else {
				$this->Session->setFlash('Impossibile salvare la riga di Prima Nota');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Primanota->read(null, $id);

            //Leggo tutti i tag e li porto alla view
            $fields=['name'];
            $t = $this->Primanota->Tag->find('all', ['fields'=>$fields, 'recursive'=>-1]);
            $taglist = [];
            foreach($t as $t1)
            {
                $taglist[]= $t1['Tag']['name'];
            }
            $this->set('taglist', $taglist);
            $this->_preparaDropDown();
		}

    }
	/**
	* delete method
	*
	* @throws NotFoundException
	* @param string $id = id prima nota
	* @param string $aid  = attivita_id
	* @return void
	*/
	public function delete($id = null, $aid = null) {
        $this->Primanota->id = $id;
        if (!$this->Primanota->exists()) {
            throw new NotFoundException(__('Invalid PrimaNota'));
        }
        //TODO: Prima di cancellare dovrei controllare se la spesa era legata ad una fattura
        //e segnalare all'utente che quella riga non è più pagata

        if ($this->Primanota->delete()) {
			$fileExt=$this->UploadFiles->checkIfFileExists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'.');
            if(!empty($fileExt)){
                unlink(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'.'.$fileExt);
            }
            $this->Session->setFlash(__('Primanota deleted'));
            return $this->redirect(['action' => 'index', $aid]);
        }
        $this->Session->setFlash(__('Primanota was not deleted'));
        return $this->redirect(['action' => 'index', $aid]);

 }

	public function deleteDoc($id = null) {
		$fileExt=$this->UploadFiles->checkIfFileExists(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'.');
		unlink(WWW_ROOT.'files'.DS.$this->request->controller.DS.$id.'.'.$fileExt);
		$this->Session->setFlash(__('Documento cancellato'));
		$this->redirect($this->referer());
	}

    //Converte i campi importoentrata e uscita in un unico campo importo con il segno positivo o negativo
	private function _gestioneImporto(){
        //Gestisco i campi utili solo alla visualizzazione
		if (isset($this->request->data['Primanota']['importoEntrata'])/*and $this->request->data['Primanota']['importoEntrata']*/)
		{
			$this->request->data['Primanota']['importo'] = str_replace(',','.', $this->request->data['Primanota']['importoEntrata']);
			$this->request->data['Primanota']['imponibile'] = str_replace(',','.', $this->request->data['Primanota']['imponibile']);
			$this->request->data['Primanota']['iva'] = str_replace(',','.', $this->request->data['Primanota']['iva']);
		}
		else
		{
			//Se è un'uscita va memorizzata con il meno
			$this->request->data['Primanota']['importo'] = - str_replace(',','.', $this->request->data['Primanota']['importoUscita']);
			$this->request->data['Primanota']['imponibile'] = - str_replace(',','.', $this->request->data['Primanota']['imponibileUscita']);
			$this->request->data['Primanota']['iva'] = - str_replace(',','.', $this->request->data['Primanota']['ivaUscita']);
		}
		//Tolgo questi campi che servivano solo per facilitare l'input
		unset($this->request->data['Primanota']['ImportoEntrata']);
		unset($this->request->data['Primanota']['ImportoUscita']);
    }



private function _preparaDropDown()
    {
        //Preparo i dropdown
        $this->set('provenienzesoldi', $this->Primanota->Provenienzasoldi->find('list',['cache' => 'Provenienzasoldi', 'cacheConfig' => 'short']));
        $this->set('legenda_cat_spesa', $this->Primanota->LegendaCatSpesa->find('list',['cache' => 'LegendaCatSpesa', 'cacheConfig' => 'short']));
        $this->set('attivita', $this->Primanota->Attivita->getlist());
        $this->set('progetti', $this->Primanota->Attivita->Progetto->find('list'));
        $fe = $this->Primanota->Fatturaemessa->find('list', [
                        'fields'=>['id', 'Descrizione'],
                        'order'=>'AnnoFatturazione desc, Progressivo',
                        'recursive' => -1,
                        //Todo: questa condizione non è proprio precisa, bisogna anche considerare
                        //che la fattura non sia completamente soddisfatta (es: mi hanno dato un anticipo)
                        'conditions' => ['Soddisfatta' => null],
                    ]);

        $notset = ['0'=> '-- Non definito --'];
        $fe = Hash::merge($notset, $fe);
        $this->set('fatturaemessa', $fe);

        $fatturaricevuta = $this->Primanota->Fatturaricevuta->find('all');
        $fr = Hash::combine($fatturaricevuta,
                    '{n}.Fatturaricevuta.id',
                    '{n}.Fatturaricevuta.motivazione',
                    '{n}.Attivita.name'
            );

        $fr = Hash::merge($notset, $fr);
        $this->set('fatturaricevuta', $fr);

		$fa = $this->Primanota->Faseattivita->getSimple(null, -1);
		$this->set('faseattivita', $fa);

        $fe = $this->Primanota->Fatturaemessa->contain('Attivita');
    }

    //Vado alla prima nota di cui mi hai passato l'id della fattura ricevuta
    public function viewfr($idfr = null)
    {
        $this->Primanota->recursive=0;
        $pn = $this->Primanota->find('first', ['conditions' => ['fatturaricevuta_id' => $idfr]]);
        $this->redirect('edit/'. $pn['Primanota']['id']);
    }

    //Scrive per ogni mese dell'anno corrente tutte le spese e gli incassi raggruppati per mese
    public function totalimese($anno, $mese=null)
    {
        $this->set('title_for_layout', "$anno - Totali per Mese - Prima Nota");
        $this->Primanota->recursive=0;
        //Estraggo tutte le prime note dell'anno corrente, ordinate per importo e poi per data
        $pn = $this->Primanota->find('all',['conditions'=>['YEAR(Primanota.data)'=> $anno],
                                            'fields'=>['Primanota.data',
                                                            'Primanota.importo',
                                                            'Attivita.name',
                                                            'Persona.DisplayName',
                                                            'Primanota.attivita_id',
                                                            'Primanota.descr',
                                                            'Provenienzasoldi.name'
                                                    ],
                                            'order'=> ['Attivita.name', 'Primanota.data', 'Primanota.importo'],
                                           ]
                               );
        $primanota = [];
        foreach ($pn as $p)
        {
            $d = new DateTime($p['Primanota']['data']);
            //m = mese di scadenza della fattura
            $m = $d->format('n'); //n = numero del mese senza lo 0

            //Aggiungo al mese di scadenza la fattura corrente
            $primanota[$m][] = $p;

        }
        $this->set('primanota', $primanota);
        $this->set('anno', $anno);
    }

    private function _getAnno()
    {
        //Prendo l'anno a cui si riferisce come namedparameter
        if (!empty($this->request->query('anno')))
        {
            return $this->request->query('anno');
        }
        if (!empty($this->params['named']['anno']))
        {
            return $this->params['named']['anno'];
        }
        if (empty($anno) )
        {
            return date('Y');
        }
    }
    //Estrae il bilancio dalla prima nota, prende come parametro un anno
    public function per_anno()
    {
        $anno = $this->_getAnno();

        $pn = $this->Primanota->find('all', [
                'fields' => ['Faseattivita.id as id', 'Faseattivita.descrizione as descrizione', 'Primanota.data', 'Primanota.Descr', 'Primanota.importo',
                        'IF(Primanota.importo>0,"E","U") as Importi',
                        'Attivita.name', 'Persona.DisplayName', 'LegendaCatSpesa.name', 'Provenienzasoldi.name'
                    ],
                'conditions' => ['Primanota.data >=' => "$anno-01-01", 'Primanota.data <=' =>  "$anno-12-31" ],
                'order' => ['Primanota.data'],
            ]);
        $this->set('pn', $pn);

    }

    //Estrae il bilancio dalla prima nota, prende come parametro un anno
    public function bilancio()
    {
        $anno = $this->_getAnno();

        $pn = $this->Primanota->find('all', [
                'fields' => ['SUM(Primanota.importo) as sum',
                        'Attivita.name','LegendaCatSpesa.name', 'Provenienzasoldi.name'
                    ],
                'conditions' => ['Primanota.data >=' => "$anno-01-01",
                                      'Primanota.data <=' =>  "$anno-12-31",
                                      //'Provenienzasoldi.id IN' => array(8,70,73), //Massimoi: avevo messo questo blocco per togliere le prepagate dal bilancio
                                      'LegendaCatSpesa.id <>' => 45, //Tolgo il giroconto
                                      'Primanota.importo > 0'
                                      ],
                'group' => ['LegendaCatSpesa.name'],
                'order' => ['LegendaCatSpesa.name'],
            ]);
        //Entrate
        $this->set('pne', $pn);
        unset($pn);

        $pn = $this->Primanota->find('all', [
                'fields' => ['SUM(Primanota.importo) as sum',
                        'Attivita.name','LegendaCatSpesa.name', 'Provenienzasoldi.name'
                    ],
                'conditions' => ['Primanota.data >=' => "$anno-01-01",
                                      'Primanota.data <=' =>  "$anno-12-31",
                                      //'Provenienzasoldi.id IN' => array(8,70,73), //Massimoi: avevo messo questo blocco per togliere le prepagate dal bilancio
                                      'LegendaCatSpesa.id <>' => 45, //Tolgo il giroconto dal bilancio
                                      'Primanota.importo < 0'],
                'group' => ['LegendaCatSpesa.name'],
                'order' => ['LegendaCatSpesa.name'],
            ]);
        //Uscite
        $this->set('pnu', $pn);
        $this->set('name',"$anno-" . Configure::read('iGas.NomeAzienda')."-Bilancio");
    }

    //Chiamo il bilancio e poi lo visualizzo con una pivot table
    public function pivot($anno = null)
    {

       if (!isset($anno))
        {
            $anno = date('Y');
        }

        $pn = $this->Primanota->find('all', [
                'fields' => ['Faseattivita.id as id', 'Faseattivita.descrizione as descrizione', 'Primanota.data', 'Primanota.Descr', 'Primanota.importo',
                        'IF(Primanota.importo>0,"Entrate","Uscite") as Importi',
                        'Attivita.name', 'Persona.DisplayName', 'LegendaCatSpesa.name', 'Provenienzasoldi.name'
                    ],
                'conditions' => ['Primanota.data >=' => "$anno-01-01", 'Primanota.data <=' =>  "$anno-12-31"],
                'order' => ['Primanota.data'],
            ]);

        foreach($pn as &$row){
            $row = Set::flatten($row);
        }

        $this->set('r', $pn);
        $this->set('_serialize', ['r']);
    }

    public function riclassifica()
    {
        $anno = $this->_getAnno();

        if (!empty($this->request->data)) {
            //Nota che devo specificare il campo "Primanota" nella saveMany, se no, non funziona!
            //Massimoi 30/3/2016
            if ($this->Primanota->saveMany($this->request->data['Primanota'])) {
                $this->Session->setFlash(__('Primanota Aggiornata'));
            } else {
                $this->Session->setFlash(__('Impossibile salvare la primanota.'));
            }
        }

        $this->Paginator->settings =  [
        'fields' => ['Primanota.id', 'Primanota.data', '   Primanota.Descr', 'Primanota.importo', 'Primanota.legenda_cat_spesa_id',
                'Attivita.name', 'Persona.DisplayName', 'LegendaCatSpesa.name', 'Provenienzasoldi.name', 'Primanota.attivita_id'
            ],
        'conditions' => ['Primanota.data >=' => "$anno-01-01", 'Primanota.data <=' =>  "$anno-12-31"],
        'order' => ['Primanota.data'],
        'limit' => 50,
        ];

        $this->data = $this->Paginator->paginate();
        $this->set('legenda_cat_spesa', $this->Primanota->LegendaCatSpesa->find('list'));
        $this->set('attivita', $this->Primanota->Attivita->find('list')); //modificato
    }

    public function totaleperanno()
    {
        $anno = date('Y');
        $annopassato = $anno -1;
        $primanota = [];

        $pn = $this->Primanota->find('all', [
                'fields' => ['Primanota.data', 'Primanota.importo'],
                'conditions' => ['Primanota.data >=' => "$annopassato-01-01", 'Primanota.data <=' =>  "$anno-12-31" ],
                'order' => ['Primanota.data'],
            ]);

        $primanota[$anno]['Entrate'] = 0;
        $primanota[$anno]['Uscite'] = 0;
        $primanota[$annopassato]['Entrate'] = 0;
        $primanota[$annopassato]['Uscite'] = 0;

        foreach ($pn as $p) {

            if($p['Primanota']['data'] >= $anno.'-01-01') {

                if($p['Primanota']['importo'] >= 0) {
                    $primanota[$anno]['Entrate'] += $p['Primanota']['importo'];
                } else {
                    $primanota[$anno]['Uscite'] += $p['Primanota']['importo'];
                }
            }

            else {

            if($p['Primanota']['importo'] >= 0) {
                    $primanota[$annopassato]['Entrate'] += $p['Primanota']['importo'];
                } else {
                    $primanota[$annopassato]['Uscite'] += $p['Primanota']['importo'];
                }
            }
        }

        return $primanota;
    }
}
?>
