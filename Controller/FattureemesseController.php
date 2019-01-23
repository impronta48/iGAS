<?php
class FattureemesseController extends AppController {

    public $name = 'Fattureemesse';
    public $helpers = array('Number');
    public $uses = array('Fatturaemessa', 'Persona','Primanota');
    public $components = array('RequestHandler');

	function index($anno = null) {


        $conditions=array();
        if (!empty($this->request->named['attivita']))
        {
            $conditions = array('Fatturaemessa.attivita_id'=>$this->request->named['attivita']);
        }
        if (!empty($this->request->named['persona']))
        {
            $conditions['Attivita.cliente_id'] = $this->request->named['persona'];
            $this->set('persona', $this->request->named['persona']);
        }
        if (!empty($this->request->named['anno']))
        {
                $anno = $this->request->named['anno'];
                $conditions['AnnoFatturazione'] = $anno;
        }
        if (empty($anno) )
        {
           // $anno = "";
        }
        if (empty($anno) && empty($this->request->named['pagato']))
        {
           // $conditions['AnnoFatturazione'] = "";
        }

        $this->Fatturaemessa->recursive = 1;
        $this->paginate = array('limit' => 500, 'maxLimit' => 500);

        $this->set('anno', $anno);
		$this->set('fattureemesse', $this->paginate('Fatturaemessa',$conditions));
        $this->set('title_for_layout', 'Fatture Emesse '. $anno);
	}

    function scadenziario($anno = null) {
        $this->set('title_for_layout', 'Scadenziario Fatture Emesse '. $anno);
		$this->Fatturaemessa->recursive = 1;
        $this->paginate = array('limit' => -1);
        $this->Fatturaemessa->Behaviors->load('Containable');
        $this->Fatturaemessa->contain('Attivita.Persona');

        if (empty($anno))
        {
            $anno = date('Y');
        }
        $cond = array('AnnoFatturazione'=>$anno);
        $fatture = $this->paginate('Fatturaemessa',$cond);

        //Preparo l'array che restituirò, quello con tutte le scadenze
        $scad= array();
        foreach ($fatture as $f)
        {
            $d = new DateTime($f['Fatturaemessa']['data']);
			if (isset($f['Fatturaemessa']['ScadPagamento']))
			{
				$d->modify( "+".$f['Fatturaemessa']['ScadPagamento'].' days');
			}
            //m = mese di scadenza della fattura
            $m = $d->format('n'); //n = numero del mese senza lo 0
            $f['Fatturaemessa']['DataScadenza'] =$d->format('Y-m-d');

            //Aggiungo al mese di scadenza la fattura corrente
            $scad[$m][] = $f;

        }
		$this->set('fattureemesse', $scad);
		$this->set('anno', $anno);
	}

    //Segna una fattura come soddisfatta
    //In post ho la possibilità di ricevere un anticipo e non il totale
    //Se non passo nulla in post, viene soddisfatta completamente
    function soddisfa($id)
    {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fatturaemessa'));
			$this->redirect($this->request->referer());
		}

        //Questo è il valore che l'utente ha inserito nel form
        $acconto = $this->data['Fatturaemessa']['Acconto'];

        //Leggo i valori della fattura
        $this->Fatturaemessa->recursive = 1;
        $this->Fatturaemessa->Behaviors->load('Containable');
        $this->Fatturaemessa->contain('Attivita.Persona');
        $f = $this->Fatturaemessa->findById($id);
        $totLordo = $f['Fatturaemessa']['TotaleLordo'];
        $parziale = $f['Fatturaemessa']['Soddisfatta'];

        if ($acconto > $totLordo+1 - $parziale)
        {
            $this->Session->setFlash('Impossibile che l\'acconto sia superiore al totale fattura');
			$this->redirect(array('action' => 'index'));
        }

        //Aggiungo una riga in prima nota
        //TODO: Devo fare attenzione a non aggiungerne due (per ora limito solo l'interfaccia utente)

        $p = $this->Primanota->create();
        $p['Primanota']['data'] = date('Y-m-d');
        $p['Primanota']['descr'] = "Incasso fattura ". $f['Fatturaemessa']['Progressivo'] ."/" . $f['Fatturaemessa']['AnnoFatturazione'];
        $p['Primanota']['importo'] = $acconto;
        $p['Primanota']['attivita_id'] = $f['Fatturaemessa']['attivita_id'];

        $p['Primanota']['legenda_cat_spesa_id'] = Configure::read('Fattureemesse.catIncasso');
        $p['Primanota']['provenienzasoldi_id'] = Configure::read('iGas.bancaDefault');

        $p['Primanota']['fatturaemessa_id'] = $f['Fatturaemessa']['id'];
        $p['Primanota']['persona_id'] = $f['Attivita']['cliente_id'];
        $p['Primanota']['persona_descr'] = $f['Attivita']['Persona']['DisplayName'];
        $p['Primanota']['num_documento'] = $f['Fatturaemessa']['Progressivo'] ."/" . $f['Fatturaemessa']['AnnoFatturazione'];
        $p['Primanota']['data_documento'] = $f['Fatturaemessa']['data'];

        //Se mi ha dato un acconto faccio la proporzione tra il netto è l'iva
        $perc = $acconto / $totLordo;
        $p['Primanota']['imponibile'] = $f['Fatturaemessa']['TotaleNetto'] * $perc;
        $p['Primanota']['iva'] = ($totLordo - $f['Fatturaemessa']['TotaleNetto']) * $perc;

         //Aggiorno il campo soddisfatta
        if (!is_null($f))
        {
            $f['Fatturaemessa']['Soddisfatta'] += $acconto;
            if ( $this->Fatturaemessa->save($f))
            {
                if ($this->Primanota->save($p))
                {
                    $this->Session->setFlash(__('Salvato con successo'));
                }
                else
                {
                    $this->Session->setFlash('Impossibile scrivere in prima nota');
                }
            }
            else
            {
                $this->Session->setFlash('Impossibile aggiornare la fattura');
            }
        }
        $this->redirect($this->request->referer());
    }

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid fatturaemessa'));
			$this->redirect(array('action' => 'index'));
		}
        //Questo mi serve per tirare su l'anagrafica dell'utente
        $this->Fatturaemessa->Behaviors->load('Containable');
        $this->Fatturaemessa->contain('Attivita.Persona','ProvenienzaSoldi','Rigafattura','Rigafattura.Codiceiva');

        //Qui tiro su l'anagrafica dell'azienda che emette la fattura
        $pid = Configure::read('iGas.idAzienda');
        $azienda =  $this->Persona->findById($pid);
        $pid = Configure::read('iGas.idAzienda');
        $azienda = $this->Persona->findById($pid);
        $this->set('azienda', $azienda);
        $f = $this->Fatturaemessa->findById($id);

        //Passo alla view i dati della fattura
		$this->set('fatturaemessa', $f );
        $this->set('title_for_layout', 'Visualizza Fattura '. $id);

        $anno = $f['Fatturaemessa']['AnnoFatturazione'];
        $progressivo = $f['Fatturaemessa']['Progressivo'];
		//8 caratteri del cliente
        $cli = str_replace(' ', '', substr($f['Attivita']['Persona']['DisplayName'], 0, 8));
		//8 caratteri dell'attivita
        $att = str_replace(' ', '', substr($f['Attivita']['name'], 0, 8));
        $this->set('name', "$anno-$progressivo-" . Configure::read('iGas.NomeAzienda') . "Fattura-$cli-$att.pdf" );        
	}

	function add($attivita_id = NULL) {
        $this->set('title_for_layout', 'Fattura Emessa Nuova');
        //Todo: Permettere di scegliere l'attività e non rimandare al mittente
        if (empty($attivita_id) && (empty($this->request->data)))
        {
            $this->Session->setFlash(__('Devi associare una fattura ad un\'attività'));
            $this->redirect($this->referer());
        }
		if(isset($this->request->query['serie'])) $serie = $this->request->query['serie'];
		else $serie = null;
        $progressivoLibero = $this->Fatturaemessa->progressivoLibero($serie);
        $this->set('progressivolibero', $progressivoLibero);
		    $this->set('Serie', $serie);
        //Imposto il progressivo e poi rimando allo stesso form dell'edit
        $this->edit();
        $this->render('edit');
	}

	function edit($id = null) {
        if (!is_null($id))
        {
            $this->set('title_for_layout', 'Modifica Fattura Emessa '. $id);
        }

		if (!empty($this->request->data)) {
			if ($this->Fatturaemessa->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The fatturaemessa has been saved'));
                $attivita_id = $this->request->data['Fatturaemessa']['attivita_id'];
                //Todo: migliorare il redirect di questa attività: se arrivo dal report fatture emesse dovrei tornare lì,
                //Il problema è che non posso usare $this->referrer perchè ritorno sull'add quando aggiungo
				$this->redirect(array('controller'=>'attivita','action'=>'fatture', $attivita_id));
			} else {
				$this->Session->setFlash(__('The fatturaemessa could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Fatturaemessa->read(null, $id);
		}

		$serieOptions = array();
    	$serieOptions[''] = 'Nessuna Serie';
    	$serieOptions['PA'] = 'Pubblica Amministrazione';
    	$this->set('serieOptions', $serieOptions);

		$attivita = $this->Fatturaemessa->Attivita->getlist();
		$provenienzesoldi = $this->Fatturaemessa->ProvenienzaSoldi->find('list',array('cache' => 'provenienzasoldi', 'cacheConfig' => 'short'));
		$this->set(compact('attivita', 'provenienzesoldi'));


		$this->loadModel('LegendaCodiciIva');
		$codiciiva = $this->LegendaCodiciIva->find('all',array('cache' => 'LegendaCodiciIva', 'cacheConfig' => 'short'));
       	$this->set('codiciiva', $codiciiva);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for fatturaemessa'));
			$this->redirect($this->referer());
		}
		if ($this->Fatturaemessa->delete($id)) {
      $this->Fatturaemessa->Rigafattura->deleteAll(array('fattura_id'=>$id),false);
      echo 'cancellate anche le righe fattura';
			$this->Session->setFlash(__('Fatturaemessa deleted'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('Fatturaemessa was not deleted'));
		$this->redirect($this->referer());
	}

    //Mostra la lista delle fatture emesse, normalemente solo quelle insoddisfatte
    //Posso filtrare su una sola attività o vedere anche quelle soddisfatte
    //Restituisce json
    function lista($attivita_id = null, $insoddisfatte = TRUE)
    {
         $conditions = array();
         if (!empty($attivita_id))
         {
             $conditions['attivita_id'] = $attivita_id;
             $conditions['Soddisfatta'] = !$insoddisfatte;

         }
         $fe = $this->Primanota->Fatturaemessa->find('all',
                            array(
                                'fields'=>array('id','Progressivo','AnnoFatturazione','Motivazione','TotaleLordo','Attivita.name'),
                                'order' => array('AnnoFatturazione DESC', 'Progressivo'),
                                'conditions' => $conditions,

                               )
                            );

        $fattureemesse = Hash::combine($fe, "{n}.Fatturaemessa.id",
                array('%s-%02d - %s - %s (%d€)',
                    "{n}.Fatturaemessa.AnnoFatturazione",
                    "{n}.Fatturaemessa.Progressivo",
                    "{n}.Fatturaemessa.Motivazione",
                    "{n}.Attivita.name",
                    "{n}.Fatturaemessa.TotaleLordo")
                );

        $this->set(compact('fattureemesse'));
        $this->set('_serialize', array('fattureemesse'));
    }


    //Duplica una fattura
    public function dup($id)
    {
        $this->Fatturaemessa->recursive = -1;
        $this->Fatturaemessa->Behaviors->load('Containable');
        $this->Fatturaemessa->contain('Rigafattura');
        if (!$this->Fatturaemessa->exists($id))
        {
            throw new NotFoundException("Fattura inesistente");
        }

        $fe = $this->Fatturaemessa->findById($id);
        $this->Fatturaemessa->create();

        //Aggiorno i dati della fattura (progressivo, data)
        $fe['Fatturaemessa']['AnnoFatturazione'] = date('Y');
        $fe['Fatturaemessa']['Progressivo'] = $this->Fatturaemessa->progressivoLibero('', date('Y'));
        $fe['Fatturaemessa']['data'] = date('Y-m-d');
		    $fe['Fatturaemessa']['id']=NULL; //Devo svuotare ID se no modifico la fattura vecchia!
        $this->Fatturaemessa->save($fe);
        $fattura_id= $this->Fatturaemessa->id;
        $fe['Fatturaemessa']['id'] = $fattura_id;

        //Devo anche cancellare l'id fattura da tutte le righefattura
    		for ($i=0; $i < count($fe['Rigafattura']); $i++)
    		{
            $fe['Rigafattura'][$i]['fattura_id']= $fattura_id;
            $fe['Rigafattura'][$i]['id']=NULL;
    		}

        //se contiene un mese metto il successivo (mi fermo a 11 perchè non gestisco lo scavalco d'anno
        setlocale(LC_ALL, 'ita');
        $mot =$fe['Fatturaemessa']['Motivazione'];
        for($m =1;  $m <=11; $m++)
        {
            $monthName = strftime('%B', strtotime("2014-$m-01")); // Nome del mese

            if (stripos($mot,$monthName))
            {
                $n= $m+1;
                $nextMonthName = strftime('%B', strtotime("2014-$n-01")); // Nome del mese
                $fe['Fatturaemessa']['Motivazione'] = str_ireplace($monthName, $nextMonthName, $mot);
            }
        }

        if ($this->Fatturaemessa->saveAssociated($fe))
        {
          $this->Session->setFlash('Fattura duplicata, ora si può modificare');
          $this->redirect(array('controller'=> 'fattureemesse',  'action'=>'edit', $fattura_id) );
        }
        else {
          $this->flash('Errore nel salvataggio della fattura');
        }
    }

    public function fatturatoperanno() {

        $fatturato = array();

        $res = $this->Fatturaemessa->find('all', array(
                    'fields' => array('SUM(Fatturaemessa.Soddisfatta) as S', 'Fatturaemessa.AnnoFatturazione'),
                    'group' => 'Fatturaemessa.AnnoFatturazione','fatturaemessa.id'));

        foreach ($res as $r) {
            $fatturato[$r['Fatturaemessa']['AnnoFatturazione']] = $r[0]['S'];
        }

        return $fatturato;
    }

    public function ultimemodifiche() {

        $lastmodified = array();

        $res = $this->Fatturaemessa->find('all', array(
                'fields' => array('Fatturaemessa.Motivazione', 'Fatturaemessa.modified'),
                'limit' => '10',
                'order' => array('Fatturaemessa.modified' => 'desc')));

        foreach ($res as $r) {

            $lastmodified[$r['Fatturaemessa']['id']]['Nome'] = $r['Fatturaemessa']['Motivazione'];
            $lastmodified[$r['Fatturaemessa']['id']]['Modifica'] = $r['Fatturaemessa']['modified'];
        }

        return $lastmodified;
    }

    //TODO: LAVORARE QUI
    //Chiamo il fatturato e poi lo visualizzo con una pivot table
    public function pivot($anno = null)
    {

       if (!isset($anno))
        {
            $anno = date('Y');
        }

        $pn = $this->Fatturaemessa->find('all', array(
                'fields' => array('Faseattivita.id as id', 'Faseattivita.descrizione as descrizione', '.data', 'Primanota.Descr', 'Primanota.importo',
                        'IF(Primanota.importo>0,"Entrate","Uscite") as Importi',
                        'Attivita.name', 'Persona.DisplayName', 'LegendaCatSpesa.name', 'Provenienzasoldi.name'
                    ),
                'conditions' => array('Primanota.data >=' => "$anno-01-01", 'Primanota.data <=' =>  "$anno-12-31"),
                'order' => array('Primanota.data'),
            ));

        foreach($pn as &$row){
            $row = Set::flatten($row);
        }

        $this->set('r', $pn);
        $this->set('_serialize', array('r'));
    }
}
