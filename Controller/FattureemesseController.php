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

	public function fattureincloud($id = null){
		if (!$id) {
			$this->Session->setFlash(__('Invalid fatturaemessa'));
			$this->redirect(array('action' => 'index'));
		}
        //Questo mi serve per tirare su l'anagrafica dell'utente
        $this->Fatturaemessa->Behaviors->load('Containable');
        $this->Fatturaemessa->contain('Attivita.Persona','ProvenienzaSoldi','Rigafattura','Rigafattura.Codiceiva');
        //Qui tiro su l'anagrafica dell'azienda che emette la fattura
        $pid = Configure::read('iGas.idAzienda');
        $azienda = $this->Persona->findById($pid);
        $this->set('azienda', $azienda);
        $f = $this->Fatturaemessa->findById($id);
		//debug($azienda);//DEBUG
		//debug($f);//DEBUG
		$url = Configure::read('fattureInCloud.fatture.nuovo'); // dentro iGAS.php
		$request = array(
			// ATTENZIONE: LE DATE PER FATTUREINCLOUD DEVONO ESSERE NEL FORMATO DD/MM/YYYY ALTRIMENTI IL CARICAMENTO FALLISCE
			"api_uid" => Configure::read('fattureInCloud.uid'), // OBBLIGATORIO
			"api_key" => Configure::read('fattureInCloud.key'), // OBBLIGATORIO
			"id_cliente" => "0", //valorizzato se è una fattura di vendita (emessa)
			"id_fornitore" => $f['Attivita']['Persona']['id'], // valorizzato se è una fattura di acquisto
			// Forse sarebbe meglio usare $f['Attivita']['Persona']['Societa'] solo se $f['Attivita']['Persona']['Nome'] e
			// $f['Attivita']['Persona']['Cognome'] sono uguali a '' Se anche $f['Attivita']['Persona']['Societa'] è uguale
			// a '' bisognerebbe scrivere UNCKNOWN
			"nome" => $f['Attivita']['Persona']['Societa'], // OBBLIGATORIO (Nome o ragione sociale del cliente/fornitore)
			"indirizzo_via" => $f['Attivita']['Persona']['Indirizzo'],
			"indirizzo_cap" => $f['Attivita']['Persona']['CAP'], 
			"indirizzo_citta" => $f['Attivita']['Persona']['Citta'], 
			"indirizzo_provincia" => $f['Attivita']['Persona']['Provincia'], 
			"indirizzo_extra" => $f['Attivita']['Persona']['altroIndirizzo'], //Se presente per iGAS questa var contiene solo una via.. Forse sarebbe meglio lasciare vuoto "indirizzo_extra"
			"paese" => "Italia", // Questo non c'è in $f, doveva essere il nome completo del paese, ad esempio Italia, valutare se lasciare vuoto "paese"
			"paese_iso" => $f['Attivita']['Persona']['Nazione'], // Questo deve essere ad esempio IT
			"lingua" => "it", // Questo non c'è in $f
			"piva" => $f['Attivita']['Persona']['piva'], 
			"cf" => $f['Attivita']['Persona']['cf'], // da "indirizzo_via" a "cf" sono dati di fornitori o clienti
			"autocompila_anagrafica" => false, 
			"salva_anagrafica" => false, 
			"numero" => $f['Fatturaemessa']['Progressivo'],  // Qua bisogna mettere $f['Fatturaemessa']['Progressivo']."/".$f['Fatturaemessa']['AnnoFatturazione'] oppure altro?
			"data" => implode('/',array_reverse(explode('-',explode(' ',$f['Fatturaemessa']['created'])[0]))), // $f['Fatturaemessa']['created']
			"valuta" => "EUR", // Questo non c'è in $f
			"valuta_cambio" => 1, //Se non specificato viene utilizzato il tasso di cambio odierno
			"prezzi_ivati" => false, 
			"rivalsa" => 0, // Questo non c'è in $f
			"cassa" => 0, // Questo non c'è in $f
			"rit_acconto" => 0, // Questo non c'è in $f
			"imponibile_ritenuta" => 0, // Questo non c'è in $f
			"rit_altra" => 0, // Questo non c'è in $f
			"marca_bollo" => 0, // Questo non c'è in $f
			"oggetto_visibile" => $f['Attivita']['name'], 
			"oggetto_interno" => "", 
			"centro_ricavo" => $f['Attivita']['name'], // Non so cosa mettere, forse $f['Attivita']['name']
			"centro_costo" => "", // Non so cosa mettere
			"note" => "", 
			"nascondi_scadenza" => false, 
			"ddt" => false, 
			"ftacc" => false, 
			"id_template" => "0", 
			"ddt_id_template" => "0", 
			"ftacc_id_template" => "0", 
			"mostra_info_pagamento" => false, 
			"metodo_pagamento" => "Bonifico", // Questo non c'è in $f
			"metodo_titoloN" => "IBAN", // Questo non c'è in $f
			"metodo_descN" => $f['Attivita']['Persona']['iban'], 
			"mostra_totali" => "tutti", 
			"mostra_bottone_paypal" => false, 
			"mostra_bottone_bonifico" => false, 
			"mostra_bottone_notifica" => false, 
			"lista_articoli" => array(array( // nell'array lista_articoli deve esserci PER FORZA almeno un articolo
				"id" => "0",
				"codice" => "",
				"nome" => "", // Sul DB non c'è e se metto $f['Rigafattura'][0]['DescrizioneVoci'] è ripetuto con il campo JSON descrizione
				"um" => "",
				"quantita" => 1,
				"descrizione" => $f['Rigafattura'][0]['DescrizioneVoci'],
				"categoria" => "",
				"prezzo_netto" => $f['Fatturaemessa']['TotaleNetto'], // OBBLIGATORIO // $f['Fatturaemessa']['TotaleNetto']
				"prezzo_lordo" => $f['Fatturaemessa']['TotaleLordo'], // $f['Fatturaemessa']['TotaleLordo']
				"cod_iva" => 0, // OBBLIGATORIO // Sul DB queste info sono sbagliate? Ad esempio su IGAS 'IVA al 22%' ha ID (codice) 6, su fattureincloud 'IVA al 22%' ha codice 0
				"tassabile" => true,
				"sconto" => 0,
				"applica_ra_contributi" => true,
				"ordine" => 0,
				"sconto_rosso" => 0,
				"in_ddt" => false,
				"magazzino" => true
			)),
			"lista_pagamenti" => array(array(
				"data_scadenza" => date_format(date_add(date_create(explode(' ',$f['Fatturaemessa']['created'])[0]),date_interval_create_from_date_string('30 days')),'d/m/Y'), // OBBLIGATORIO // in $f non c'è ma vedo che nel PDF della fattura di iGAS si vede 'Scadenza: 30 gg'. E' un dato fisso?
				"importo" => $f['Fatturaemessa']['TotaleNetto'], // OBBLIGATORIO
				"metodo" => "not", // OBBLIGATORIO
				"data_saldo" => "" // In $f non c'è
			)),
			"ddt_numero" => "",
			"ddt_data" => "",
			"ddt_colli" => "",
			"ddt_peso" => "",
			"ddt_causale" => "",
			"ddt_luogo" => "",
			"ddt_trasportatore" => "",
			"ddt_annotazioni" => "",
			"PA" => false,
			"PA_tipo_cliente" => "PA",
			"PA_tipo" => "nessuno",
			"PA_numero" => "",
			"PA_data" => "",
			"PA_cup" => "",
			"PA_cig" => "",
			"PA_codice" => "",
			"PA_pec" => "",
			"PA_esigibilita" => "N",
			"PA_modalita_pagamento" => "MP01",
			"PA_istituto_credito" => "",
			"PA_iban" => "",
			"PA_beneficiario" => "",
			"extra_anagrafica" => array(array(
				"mail" => "",
				"tel" => "",
				"fax" => ""
			)),
			"split_payment" => true
		);
		//error_log(date('Ymd_H:i:s')."|".$this->here."|".serialize($request)."\n",3,'C:\xampp\php\debug.log');//DEBUG
		$options = array(
			"http" => array(
				"header"  => "Content-type: text/json\r\n",
				"method"  => "POST",
				"content" => json_encode($request)
			),
		);
		$context  = stream_context_create($options);
		$result = json_decode(file_get_contents($url, false, $context), true);
		if(array_key_exists("error",$result)){
			$this->Session->setFlash(__('ERROR ID: '.$result['error_code']));
			$this->Session->setFlash(__('ERROR MESSAGE: '.$result['error']));
		}
		else {
			$this->Session->setFlash(__('OK - Fattura inviata a FattureInCloud.it'));
			$this->Session->setFlash(__(serialize($result)));
		}
		$this->redirect($this->referer());
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
