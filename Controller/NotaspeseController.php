<?php
App::uses('AppController', 'Controller');
class NotaspeseController extends AppController
{

    public $components = array('RequestHandler', 'UploadFiles', 'GoogleDrive', 'PhpExcel.PhpSpreadsheet');
    public $helpers = array('Tristate', 'Table', 'PdfToImage', 'PhpExcel.PhpSpreadsheet');

    private function getConditionFromQueryString()
    {
        $conditions = array();
        $attivita = "";
        $persone = "";

        if (isset($this->request->query['persone'])) {
            $persone = $this->request->query['persone'];
            //Se la stringa è vuota non devo mettere la condizione
            if (!empty($persone)) {
                if (is_numeric($persone)) {
                    $persone = array($persone);
                }
                $conditions['Notaspesa.eRisorsa IN'] = $persone;
            }
        }

        if (!empty($this->request->query['attivita'])) {
            $attivita = $this->request->query['attivita'];
            //Se la stringa è vuota non devo mettere la condizione
            if (!empty($attivita)) {
                if (is_numeric($attivita)) {
                    $attivita = array($attivita);
                }
                if (is_array($attivita)) $conditions['Notaspesa.eAttivita IN'] = $attivita;
            }
        }
        if (!empty($this->request->query['faseattivita_id'])) {
            $conditions['Notaspesa.faseattivita_id IN'] = $this->request->query['faseattivita_id'];
        }

        if (!empty($this->request->query['from'])) {
            $conditions['Notaspesa.data >='] = $this->request->query['from'];
        }
        if (!empty($this->request->query['to'])) {
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
                'contain' => array('Persona.displayname', 'Attivita.name'),
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
    function _getAttivitaListGroupedByProgetto()
    {
        $this->loadModel('Attivita');
        $attivita = $this->Attivita->find(
            'all',
            array(
                'fields' => array('Attivita.id', 'Attivita.name', 'Progetto.name'),
                'order' => array('Attivita.progetto_id', 'Attivita.name')
            )
        );

        $attivitaGrouped = array();
        foreach ($attivita as $a) {
            if (!isset($attivitaGrouped[$a['Progetto']['name']])) $attivitaGrouped[$a['Progetto']['name']] = array();
            array_push($attivitaGrouped[$a['Progetto']['name']], $a);
        }

        return $attivitaGrouped;
    }

    function add($id = null)
    {
        //debug($this->Session->read('notaspeseUploadReferer'));
        //debug($this->Session->read('scontrinoIdToUpload'));

        $persona = 1;
        $anno = date('Y');
        $mese = date('M');
        $giorno = 1;
        $attivita = 1;
        $destinazione = '';

        //Preparo il filtro per il riepilogo delle note spese
        $conditions = array();
        $this->set('title_for_layout', 'Aggiungi Nota Spese');

        //Parametri passati per nome
        if (isset($this->request->params['named']['persona'])) {
            $persona = $this->request->params['named']['persona'];
            $conditions['Notaspesa.eRisorsa'] = $persona;
        } else if ($this->Session->read('Auth.User.persona_id')) {
            $persona = $this->Session->read('Auth.User.persona_id');
            $conditions['Notaspesa.eRisorsa'] = $persona;
        }
        if (isset($this->request->params['named']['anno'])) {
            $anno = $this->request->params['named']['anno'];
            $conditions['YEAR(Notaspesa.data)'] = $anno;
        }
        if (isset($this->request->params['named']['mese'])) {
            $mese = $this->request->params['named']['mese'];
            $conditions['MONTH(Notaspesa.data)'] = $mese;
        }
        if (isset($this->request->params['named']['giorno'])) {
            $giorno = $this->request->params['named']['giorno'];
        }
        if (isset($this->request->params['named']['attivita'])) {
            $attivita = $this->request->params['named']['attivita'];
            $conditions['Notaspesa.eAttivita'] = $attivita;
        }
        if (isset($this->request->params['named']['dest'])) {
            $destinazione = $this->request->params['named']['dest'];
        }

        //Parametri passati per query string (dopo innovazioni di filippo)
        if (isset($this->request->query['persona'])) {
            $persona = $this->request->query['persona'];
            $conditions['Notaspesa.eRisorsa'] = $persona;
        }

        if (($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2) or ($persona == $this->Session->read('Auth.User.persona_id'))) {
            // Autorizzato
        } else {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(array('action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')));
        }

        if (isset($this->request->query['anno'])) {
            $anno = $this->request->query['anno'];
            $conditions['YEAR(Notaspesa.data)'] = $anno;
        }
        if (isset($this->request->query['mese'])) {
            $mese = $this->request->query['mese'];
            $conditions['MONTH(Notaspesa.data)'] = $mese;
        }
        if (isset($this->request->query['giorno'])) {
            $giorno = $this->request->query['giorno'];
        }
        if (isset($this->request->query['attivita'])) {
            $attivita = $this->request->query['attivita'];
            $conditions['Notaspesa.eAttivita'] = $attivita;
        }
        if (isset($this->request->query['dest'])) {
            $destinazione = $this->request->query['dest'];
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

                //Se la nota spese non è di tipo viaggio, tolgo l'origine
                if ($this->data['Notaspesa']['eCatSpesa'] !== 1) { //Spostamento 
                    $this->data['Notaspesa']['origine'] = null;
                    $this->data['Notaspesa']['destinazione'] = null;
                }
                //Questi tre valori devono essere passati in qualche modo al metodo $this->GoogleDrive->upload()
                //Lo faccio con le sessioni
                $this->Session->write('IdPersona', $persona);
                $this->Session->write('NomePersona', $this->Notaspesa->Persona->find('list', array('conditions' => array('id' => $persona)))[$persona]);
                $this->Session->write('Anno', $anno);
                $this->Session->write('Mese', $mese);
                if (!$id) {
                    //Prendo l'id legato al salvataggio
                    $id = $this->Notaspesa->getLastInsertID();
                }
                // Qua gestisco l'upload del documento su filesystem
                // $uploaded_file=$this->request->data['Notaspesa']['uploadFile'];
                // $uploadError=$this->UploadFiles->upload($id,$uploaded_file,strtolower($this->request->controller));
                //if(strlen($uploadError)>0){
                //	$this->Flash->error(__($uploadError));
                //} else {
                //$this->setUploadToDrive($id);
                //}

                //A seconda del submit premuto vado nella direzione opportuna
                if (isset($this->request->data['submit-ore'])) {
                    //$this->redirect(array('controller' => 'ore',  'action' => 'add','?'=>['persona'=>$persona,'attivita'=>$attivita,'anno'=>$anno,'mese'=>$mese,'giorno'=>$giorno]));
                    if ($this->GoogleDrive::DEBUG === true) {
                        error_log("\n\n\n#######################################################\n", 3, $this->GoogleDrive::DEBUGFILE);
                        error_log("INIZIO UPLOAD SU DRIVE CHIAMANDO setUploadToDrive()\n", 3, $this->GoogleDrive::DEBUGFILE);
                    }
                    //$this->setUploadToDrive($id,array('controller' => 'ore',  'action' => 'add','?'=>['persona'=>$persona,'attivita'=>$attivita,'anno'=>$anno,'mese'=>$mese,'giorno'=>$giorno]));
                } else {
                    //$this->redirect(array('action' => 'add', '?'=>['persona'=>$persona,'attivita'=>$attivita,'anno'=>$anno,'mese'=>$mese,'giorno'=>$giorno,'dest'=>$destinazione]));
                    if ($this->GoogleDrive::DEBUG === true) {
                        error_log("\n\n\n#######################################################\n", 3, $this->GoogleDrive::DEBUGFILE);
                        error_log("INIZIO UPLOAD SU DRIVE CHIAMANDO setUploadToDrive()\n", 3, $this->GoogleDrive::DEBUGFILE);
                    }
                    //$this->setUploadToDrive($id,array('action' => 'add', '?'=>['persona'=>$persona,'attivita'=>$attivita,'anno'=>$anno,'mese'=>$mese,'giorno'=>$giorno,'dest'=>$destinazione]));
                    //$this->redirect(array('action' => 'add', 'persona'=>$persona,'anno'=>$anno,'mese'=>$mese));
                }
            } else {
                $this->Session->setFlash('Errore durante il salvataggio della trasferta.', '/pages/home');
            }
        }
        $this->set('eAttivita', $this->Notaspesa->Attivita->getlist());

        //Se sono un impiegato posso vedere solo le mie ore
        if (Auth::hasRole(Configure::read('Role.impiegato'))) {
            $this->set('eRisorse', $this->Notaspesa->Persona->find('list', array(
                'conditions' => array('id' => $persona)
            )));
        } else {
            //Devo usare questa versione ottimizzata altrimenti va in out of memory
            $this->loadModel('Impiegato');
            $erisorse = $this->Impiegato->find('list', [
                'cache' => 'persona',
                'CacheConfig' => 'short',
                'fields' => ['Persona.id', 'Persona.DisplayName'],
                'contain' => [
                    'Persona' => ['fields' => 'DisplayName'],
                ],
                'recursive' => -1,
                'order' => ['Persona.DisplayName'],
            ]);

            $this->set('eRisorse', $erisorse);
        }

        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', array('cache' => 'legendamezzi', 'cacheConfig' => 'long')));
        $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list', array(
            'conditions' => array('not' => array('voceNotaSpesa' => NULL)),
            'cache' => 'legendacatspesa_notnull', 'cacheConfig' => 'short'
        )));
        $this->set('eProvSoldi', $this->Notaspesa->Provenienzasoldi->find('list', array('cache' => 'provenienzasoldi', 'cacheConfig' => 'long')));
        $this->set('eRisorsa', $persona);
        $this->set('attivita_default', $attivita);
        $this->set('anno', $anno);
        $this->set('mese', $mese);
        $this->set('giorno', $giorno);
        $this->set('destinazione', $destinazione);


        //Massimoi: 28/1/2014
        //Riporto sempre tutte le ore caricate in questo mese sotto il form
        $result = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'id', 'Notaspesa.eRisorsa', 'importo', 'Notaspesa.data', 'descrizione', 'origine',
                    'destinazione', 'km', 'eAttivita', 'LegendaCatSpesa.name', 'fatturabile', 'rimborsabile', 'provenienzasoldi_id', 'IdGoogleCloud', 'faseattivita_id', 'Faseattivita.Descrizione',
                ),
                'order' => array('Notaspesa.eRisorsa',  'Notaspesa.data'),
            )
        );

        $this->set('result', $result);
    }

    //Wrapper per la funzione edit
    function edit($id)
    {

        if (!$this->Notaspesa->findById($id)) {
            return $this->redirect(
                array(
                    'controller' => 'notaspese',
                    'action' => 'add',
                    '?' => array(
                        'persona' => $this->Session->read('Auth.User.persona_id'),
                        'anno' => date('Y'),
                        'mese' => date('m')
                    )
                )
            );
        }

        if (($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2) or
            ($this->Notaspesa->findById($id)['Notaspesa']['eRisorsa'] == $this->Session->read('Auth.User.persona_id'))
        ) {
            // Si può continuare
        } else {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(
                array(
                    'controller' => 'notaspese',
                    'action' => 'add',
                    '?' => array(
                        'persona' => $this->Session->read('Auth.User.persona_id'),
                        'anno' => date('Y'),
                        'mese' => date('m')
                    )
                )
            );
        }

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
            } else {
                $this->Session->setFlash('Impossibile salvare questa notaspese.');
                debug($this->Notaspesa->validationErrors);
            }
        }
        $this->loadModel('Impiegato');
        $erisorse = $this->Impiegato->find('list', [
            'cache' => 'persona',
            'CacheConfig' => 'short',
            'fields' => ['Persona.id', 'Persona.DisplayName'],
            'contain' => [
                'Persona' => ['fields' => 'DisplayName'],
            ],
            'recursive' => -1,
            'order' => ['Persona.DisplayName'],
        ]);

        $this->set('eRisorse', $erisorse);

        $this->data = $this->Notaspesa->findById($id);
        $this->set('id', $id);
        $this->set('eAttivita', $this->Notaspesa->Attivita->getlist());
        $this->set('eRisorsa', $this->data['Notaspesa']['eRisorsa']);
        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', array('cache' => 'legendamezzi', 'cacheConfig' => 'short')));
        $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list', array('cache' => 'legendacatspesa_notnull', 'cacheConfig' => 'short')));
        $this->set('eProvSoldi', $this->Notaspesa->Provenienzasoldi->find('list', array()));
    }

    //Funzione che wrappa detail ma chiama una vista che permette di modificare
    function edit_list()
    {
        $persona = 8571;
        $anno = date('Y');
        $mese = date('m');
        $giorno = date('d');
        $attivita = 1;
        $this->Notaspesa->recursive = -1;

        //Preparo il filtro per il riepilogo delle ore
        $conditions = array();

        //
        if (empty($this->request->params['named'])) {
            $this->Session->setFlash('Ti consiglio di invocare questa funzione passando dal menu a sinistra '
                . Router::url(array('action' => 'scegli_persona'))
                . '   per non rischiare di fare confusione e caricare le spese a nome di altri. ');
            $this->redirect(array('action' => 'scegli_persona'));
        }

        if (isset($this->request->params['named']['persona'])) {
            $persona = $this->request->params['named']['persona'];
            $conditions['Notaspesa.eRisorsa'] = $persona;
        }
        if (isset($this->request->params['named']['anno'])) {
            $anno = $this->request->params['named']['anno'];
            $conditions['YEAR(Notaspesa.data)'] = $anno;
        }
        if (isset($this->request->params['named']['mese'])) {
            $mese = $this->request->params['named']['mese'];
            $conditions['MONTH(Notaspesa.data)'] = $mese;
        }
        if (isset($this->request->params['named']['giorno'])) {
            $giorno = $this->request->params['named']['giorno'];
            //In realtà non voglio filtrare per il giorno, ma solo portarmelo dietro
            //$conditions['DAY(Notaspesa.data)'] = $giorno;
        }
        if (isset($this->request->params['named']['attivita'])) {
            $attivita = $this->request->params['named']['attivita'];
            //$conditions['Ora.eAttivita'] = $attivita;
        }

        $this->set('attivita_list', $this->Notaspesa->Attivita->getlist());
        $this->set('eRisorse', $this->Notaspesa->Persona->find('list', array('cache' => 'persona', 'cacheConfig' => 'short')));
        $this->set('eRisorsa', $persona);
        $this->set('anno', $anno);
        $this->set('mese', $mese);
        $this->set('giorno', $giorno);

        $this->Notaspesa->contain('LegendaCatSpesa', 'Faseattivita');
        $result = $this->Notaspesa->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'id', 'Notaspesa.eRisorsa', 'importo', 'Notaspesa.data', 'descrizione', 'origine',
                    'destinazione', 'km', 'eAttivita', 'LegendaCatSpesa.name', 'fatturabile', 'rimborsabile', 'faseattivita_id', 'Faseattivita.Descrizione',
                ),
                'order' => array('Notaspesa.eRisorsa',  'Notaspesa.data'),
            )
        );

        $this->set('result', $result);
        $this->set('title_for_layout', "Modifica Nota Spese");
        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', array('cache' => 'legendamezzi', 'cacheConfig' => 'short')));
    }

    //Manda o salva un pezzo di form che corrisponde ad una riga di strasferta
    function edit_riga()
    {
        $this->request->onlyAllow('ajax');
        $this->layout = 'ajax';
        $this->autoRender = false;

        $giorno = date('d');
        $attivita = 1;
        $dest = '';

        //Guardo se mi hai già passato un ID e lo memorizzo
        if (isset($this->request->query['id'])) {
            $id = $this->request->query['id'];
        }
        if (isset($this->request->params['named']['attivita'])) {
            $attivita = $this->request->params['named']['attivita'];
        }
        if (isset($this->request->params['named']['dest'])) {
            $dest = $this->request->params['named']['dest'];
        }
        if (isset($this->request->params['named']['giorno'])) {
            $giorno = $this->request->params['named']['giorno'];
            //In realtà non voglio filtrare per il giorno, ma solo portarmelo dietro
            //$conditions['DAY(data)'] = $giorno;
        }
        //Mi hanno chiamato per salvare
        if (!empty($this->data)) {
            if (!$this->Notaspesa->save($this->data)) {
                $this->set('error', 'Errore durante il salvataggio della trasferta.');
            } else {
                //Se ha salvato correttamente restituisco la riga non in edit
                $this->data = $this->Notaspesa->read();
                $this->set('data', $this->data);
                $this->render('view_riga');
            }
        } else {
            //Se c'è già un ID devo prima leggere i valori e poi generale il form
            if (!empty($id)) {
                $this->Notaspesa->id = $id;
                $this->data = $this->Notaspesa->read();
            }
            //Preparo i paremetri da passare alla view per visualizzare/modificare il risultato
            $this->set('eAttivita', $this->Notaspesa->Attivita->getlist());
            $this->set('eRisorse', $this->Notaspesa->Persona->find('list', array('cache' => 'persona', 'cacheConfig' => 'short')));
            $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', array('cache' => 'legendamezzi', 'cacheConfig' => 'short')));
            $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list', array('cache' => 'legendacatspesa', 'cacheConfig' => 'short')));
            $this->set('attivita_default', $attivita);
            $this->set('dest', $dest);
            $this->set('giorno', $giorno);
            $this->render('edit_riga');
            //Todo: non viene gestita la fase, se la perde ad ogni edit!
        }
    }

    public function setUploadToDrive($id = null, $redirect = null)
    {
        $this->autoRender = false;
        $this->Session->write('scontrinoIdToUpload', $id);
        //$refPage=explode(strtolower($this->request->params['controller']),$this->referer());
        //debug($refPage);die();
        //$this->Session->write('notaspeseUploadReferer', '/'.strtolower($this->request->params['controller']).$refPage[1]);
        //$thisUrl=Router::url(Array('','?'=>$this->request->query,$this->request->named),true);
        if ($redirect == null) {
            $redirect = $this->referer();
        }
        $this->Session->write('notaspeseUploadReferer', $redirect);
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("------------------------------------\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Sono in setUploadToDrive(), creo 2 variabili di sessione:\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log('scontrinoIdToUpload: ' . $this->Session->read('scontrinoIdToUpload') . "\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log('notaspeseUploadReferer: ' . print_r($this->Session->read('notaspeseUploadReferer'), true) . "\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Redirigo verso /notaspese/uploadToDrive\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        $this->redirect(array('controller' => 'notaspese', 'action' => 'uploadToDrive'));
    }

    public function setDeleteFromDrive($id = null, $redirect = null)
    {
        $this->autoRender = false;
        $this->Session->write('scontrinoIdToDelete', $id);
        $refPage = explode(strtolower($this->request->params['controller']), $this->referer());
        //debug($refPage);die();
        //$thisUrl=Router::url(Array('','?'=>$this->request->query),true);
        $this->Session->write('notaspeseUploadReferer', '/' . strtolower($this->request->params['controller']) . $refPage[1]);
        //$this->Session->write('notaspeseUploadReferer', $redirect);
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("------------------------------------\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Sono in setDeleteFromDrive(), creo 2 variabili di sessione:\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log('scontrinoIdToDelete: ' . $this->Session->read('scontrinoIdToDelete') . "\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log('notaspeseUploadReferer: ' . print_r($this->Session->read('notaspeseUploadReferer'), true) . "\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Redirigo verso /notaspese/delFromDrive\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        $this->redirect(array('controller' => 'notaspese', 'action' => 'delFromDrive'));
    }

    /**
     * Questa funzione usa autenticazione con Service Account
     *
     * @return object $googleService
     */
    private function googleApiConnectServiceAccount()
    {
        //$this->autoRender = false;
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . Configure::read('google.oauth')); //ServiceAccount
        $googleApiObj = new Google_Client(); //ServiceAccount
        $googleApiObj->useApplicationDefaultCredentials(/*'google.oauth'*/); //ServiceAccount
        $googleApiObj->addScope(Google_Service_Drive::DRIVE);
        $googleService = new Google_Service_Drive($googleApiObj);
        return $googleService;
    }

    /**
     * Questa funzione usa autenticazione oauth2
     * E' da testare dopo le ultime modifiche fatte ma iGAS attualmente usa googleApiConnectServiceAccount per connettersi
     * alle API di Google
     *
     * @return object $googleService
     */
    private function googleApiConnectOauth2()
    {
        //$this->autoRender = false;
        $googleApiObj = new Google_Client; //OAuth2
        $googleApiObj->setApplicationName(Configure::read('iGas.NomeAzienda')); //Oauth2
        $oauth_creds = Configure::read('google.oauth'); //Oauth2
        $googleApiObj->setAuthConfig($oauth_creds); //Oauth2
        $googleApiObj->setAccessType('offline'); //Oauth2
        $googleApiObj->addScope(Google_Service_Drive::DRIVE);
        $googleService = new Google_Service_Drive($googleApiObj);
        //$redirect_uri = Router::url(["controller"=>"notaspese","action"=>"add"], true);
        $redirect_uri = Router::url(null, true); //Oauth2
        $googleApiObj->setRedirectUri($redirect_uri); //Oauth2
        //debug($this->request->query);
        //debug($redirect_uri);
        //die();
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("------------------------------------\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Sono in googleApiConnect()\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        if (null === $this->Session->read('upload_token')) {
            if ($this->GoogleDrive::DEBUG === true) {
                error_log("Non è settato nessun token in sessione" . "\n", 3, $this->GoogleDrive::DEBUGFILE);
                error_log("Questo è l'url al quale Google ritornerà il token\n", 3, $this->GoogleDrive::DEBUGFILE);
                error_log($redirect_uri . "\n", 3, $this->GoogleDrive::DEBUGFILE);
                error_log("Dopo la chiamata a googleApiConnect() vedo cosa c'è nella querystring\n", 3, $this->GoogleDrive::DEBUGFILE);
                error_log(print_r($this->request->query, true) . "\n", 3, $this->GoogleDrive::DEBUGFILE);
            }
            if (isset($this->request->query['code'])) {
                $token = $googleApiObj->fetchAccessTokenWithAuthCode($this->request->query['code']);
                if ($this->GoogleDrive::DEBUG === true) {
                    error_log("Questo è il token ottenuto\n", 3, $this->GoogleDrive::DEBUGFILE);
                    error_log(print_r($token, true) . "\n", 3, $this->GoogleDrive::DEBUGFILE);
                }
                $googleApiObj->setAccessToken($token);
                if ($this->GoogleDrive::DEBUG === true) {
                    error_log("Ottenuto l'accesso passando il token all'oggetto Google_Client!!!\n", 3, $this->GoogleDrive::DEBUGFILE);
                    error_log("Setto il token in sessione per non dover rifare l'autenticazione\n", 3, $this->GoogleDrive::DEBUGFILE);
                }
                $this->Session->write('upload_token', $token);
            } else {
                $auth_url = $googleApiObj->createAuthUrl();
                //debug($auth_url);die();
                if ($this->GoogleDrive::DEBUG === true) {
                    error_log("Non ho ricevuto ancora token, quindi redirigo verso questo indirizzo di Google\n", 3, $this->GoogleDrive::DEBUGFILE);
                    error_log("Ricorda che Google, dopo aver controllato le credenziali, redirigerà verso " . $redirect_uri . "\n", 3, $this->GoogleDrive::DEBUGFILE);
                    error_log(filter_var($auth_url, FILTER_SANITIZE_URL) . "\n", 3, $this->GoogleDrive::DEBUGFILE);
                }
                $this->redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
            }
        } else {
            if ($this->GoogleDrive::DEBUG === true) {
                error_log("E' già presente un token in sessione\n", 3, $this->GoogleDrive::DEBUGFILE);
                error_log(print_r($this->Session->read('upload_token'), true) . "\n", 3, $this->GoogleDrive::DEBUGFILE);
            }
            $googleApiObj->setAccessToken($this->Session->read('upload_token'));
            if ($this->GoogleDrive::DEBUG === true) {
                error_log("Ottenuto l'accesso passando il token all'oggetto Google_Client!!!\n", 3, $this->GoogleDrive::DEBUGFILE);
            }
        }
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("Sono alla fine di googleApiConnect(), restituisco l'oggetto Google utile per usare le API\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        return $googleService;
    }

    /**
     * Questa funzione usa autenticazione oauth2
     * E' uguale a googleApiConnectOauth2 ma senza sistema di debug e senza controlli per vedere se ci sono già token in sessione
     *
     * @return object $googleService
     */
    private function googleApiConnect_ok()
    {
        $googleApiObj = new Google_Client;
        $googleApiObj->setApplicationName(Configure::read('iGas.NomeAzienda'));
        $oauth_creds = Configure::read('google.oauth');
        $googleApiObj->setAuthConfig($oauth_creds);
        //$googleApiObj->setAccessType('offline');
        $googleApiObj->addScope(Google_Service_Drive::DRIVE);
        $googleService = new Google_Service_Drive($googleApiObj);
        //$redirect_uri = Router::url(["controller"=>"notaspese","action"=>"add"], true);
        $redirect_uri = Router::url(null, true);
        $googleApiObj->setRedirectUri($redirect_uri);
        //debug($this->request->query);
        //debug($redirect_uri);
        if (isset($this->request->query['code'])) {
            $token = $googleApiObj->fetchAccessTokenWithAuthCode($this->request->query['code']);
            //debug($token);
            $googleApiObj->setAccessToken($token);
            $this->Session->write('upload_token', $token);
        } else {
            $auth_url = $googleApiObj->createAuthUrl();
            //debug($auth_url);die();
            $this->redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
        }
        return $googleService;
    }

    public function delFromDrive()
    {
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("------------------------------------\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Sono in delFromDrive()\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Devo eliminare il file da Drive, per farlo chiamo googleApiConnectServiceAccount() per connettermi alle API\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        $googleService = $this->googleApiConnectServiceAccount();
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("------------------------------------\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Sono in delFromDrive(). Ora che ho l'oggetto Google API necessario posso chiamare il component GoogleDrive->deleteFile()\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        $result = $this->GoogleDrive->deleteFile($googleService, $this->Session->read('scontrinoIdToDelete'));
        if (startsWith($result, 'SUCCESS')) {
            if ($this->Notaspesa->hasAny(array('Notaspesa.id' => $this->Session->read('scontrinoIdToDelete')))) {
                $this->Notaspesa->id = $this->Session->read('scontrinoIdToDelete');
                $this->Notaspesa->saveField('IdGoogleCloud', null);
            }
        }
        $this->Session->setFlash(__($result));
        //debug($this->Session->read('notaspeseUploadReferer'));
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("Ho fatto tutto, redirigo verso notaspeseUploadReferer creato all'inizio di tutto questo round trip.\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        $this->redirect($this->Session->consume('notaspeseUploadReferer'));
    }

    public function uploadToDrive()
    {
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("------------------------------------\n", 3, $this->GoogleDrive::DEBUGFILE);
            error_log("Sono in uploadToDrive()\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        //$this->Session->setFlash(__($this->GoogleDrive->echoCurrentUrl()));
        //$this->GoogleDrive->getController($this);//Cercavo di passare l'oggetto Controller al Component per poter poi fare $this->Controller->redirect nel Component
        $id = $this->Session->read('scontrinoIdToUpload'); //Se qua faccio $this->Session->consume $id non viene valorizzato. Questo è assurdo.
        $fileExt = $this->UploadFiles->checkIfFileExists(WWW_ROOT . 'files' . DS . $this->request->controller . DS . $id . '.');
        $fileToUpload = WWW_ROOT . 'files' . DS . $this->request->controller . DS . $id . '.' . $fileExt;
        if (file_exists($fileToUpload)) {
            //$this->Session->delete('scontrinoIdToUpload');//Se deleto questa $id della riga sopra diventa null. Questo è assurdo.
            if ($this->GoogleDrive::DEBUG === true) {
                error_log("E' stato caricato un file sul server, lo carico anche su Drive, per farlo chiamo googleApiConnectServiceAccount() per connettermi alle API\n", 3, $this->GoogleDrive::DEBUGFILE);
            }
            $googleService = $this->googleApiConnectServiceAccount();
            $folderParams = array(
                Configure::read('google.drive.notaspese'),
                $this->Session->consume('NomePersona') . '_' . $this->Session->read('IdPersona'),
                $this->Session->consume('Anno') . '-' . $this->Session->consume('Mese') . 'notaspese persona ' . $this->Session->consume('IdPersona')
            );
            if ($this->GoogleDrive::DEBUG === true) {
                error_log("------------------------------------\n", 3, $this->GoogleDrive::DEBUGFILE);
                error_log("Sono in uploadToDrive(). Ora che ho l'oggetto Google API necessario posso chiamare il component GoogleDrive->upload()\n", 3, $this->GoogleDrive::DEBUGFILE);
            }
            $gDriveId = $this->GoogleDrive->upload($googleService, $fileToUpload, $folderParams); //Se l'upload ha successo ritorna l'ID del file assegnato da Google
            $result = 'File caricato con successo, l\'id del file su Google Drive è ' . $gDriveId;
            $this->Notaspesa->id = $id;
            $this->Notaspesa->saveField('IdGoogleCloud', $gDriveId);
        } else {
            $result = 'Nessuno scontrino caricato, niente da uploadare su Google Drive';
        }
        $this->Session->setFlash(__($result));
        //debug($this->Session->read('notaspeseUploadReferer'));die();
        if ($this->GoogleDrive::DEBUG === true) {
            error_log("Ho fatto tutto, redirigo verso notaspeseUploadReferer creato all'inizio di tutto questo round trip.\n", 3, $this->GoogleDrive::DEBUGFILE);
        }
        $this->redirect($this->Session->consume('notaspeseUploadReferer'));
    }

    private function _decode_tristate(&$conditions, $param)
    {
        if ($this->request->query($param) != null) {

            if ($this->request->query($param) >= 0) {

                $testo = 'Notaspesa.' . $param;
                $conditions[$testo] = $this->request->query[$param];
            }
            //Se è < 0 non metto proprio la condizione (=indefinito)
        }
    }

    //Funzione analoga a stats ma restituise il dettaglio, dati i parametri
    function detail()
    {

        $attivita = '';
        $persone = '';
        $faseattivita = '';
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
                    'id', 'Notaspesa.eRisorsa', 'importo', 'Notaspesa.data', 'descrizione', 'origine',
                    'destinazione', 'Faseattivita.descrizione', 'km', 'eAttivita', 'LegendaCatSpesa.name', 'rimborsato', 'fatturato',
                    'rimborsabile',
                    'fatturabile'
                ),
                'order' => array('Notaspesa.eRisorsa', 'Notaspesa.data'),
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
        $this->set('eProvSoldi', $this->Notaspesa->Provenienzasoldi->find('list', array()));

        $this->set('title_for_layout', "$attivita | $persone | Dettaglio Nota Spese");
    }

    public function delete($id, $dest = null)
    {
        //$this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Notaspese'));
            $this->redirect(array('action' => 'index')); //La view index non è mai esistita e non c'è il metodo index in questo controller
        }
        if ($this->Notaspesa->delete($id)) {
            $fileExt = $this->UploadFiles->checkIfFileExists(WWW_ROOT . 'files' . DS . $this->request->controller . DS . $id . '.');
            if (!empty($fileExt)) {
                unlink(WWW_ROOT . 'files' . DS . $this->request->controller . DS . $id . '.' . $fileExt);
                if ($this->GoogleDrive::DEBUG === true) {
                    error_log("\n\n\n#######################################################\n", 3, $this->GoogleDrive::DEBUGFILE);
                    error_log("INIZIO DELETE SU DRIVE CHIAMANDO setDeleteFromDrive()\n", 3, $this->GoogleDrive::DEBUGFILE);
                }
                $this->setDeleteFromDrive($id, array('', '?' => $this->request->query)); //Con autenticazione Oauth2, Perchè questo qua non può stare e fa apparire un alert con su scritto undefined???
            }
            $this->Session->setFlash(__('Notaspese deleted'));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('Notaspese was not deleted'));
        $this->redirect(array('action' => 'index')); //La view index non è mai esistita e non c'è il metodo index in questo controller
    }

    public function deleteDoc($id = null)
    {
        $this->autoRender = false;
        $fileExt = $this->UploadFiles->checkIfFileExists(WWW_ROOT . 'files' . DS . $this->request->controller . DS . $id . '.');
        if (unlink(WWW_ROOT . 'files' . DS . $this->request->controller . DS . $id . '.' . $fileExt)) {
            $this->Session->setFlash(__('Documento cancellato'));
            if ($this->GoogleDrive::DEBUG === true) {
                error_log("\n\n\n#######################################################\n", 3, $this->GoogleDrive::DEBUGFILE);
                error_log("INIZIO DELETE SU DRIVE CHIAMANDO setDeleteFromDrive()\n", 3, $this->GoogleDrive::DEBUGFILE);
            }
            $this->setDeleteFromDrive($id);
        } else {
            $this->Session->setFlash(__('Non è stato possibile cancellare il documento nè sul Server nè su Drive'));
        }
        $this->redirect($this->referer());
    }

    public function duplicate($id)
    {

        $this->autoRender = false;

        $row = $this->Notaspesa->findById($id);

        $row["Notaspesa"]["id"] = null;
        $this->Notaspesa->create();
        $this->Notaspesa->save($row);

        $this->redirect($this->referer());
    }

    //Genera la notaspese in un formato adatto alla stampa
    public function stampa()
    {

        if (!isset($this->request->data['Notaspesa'])) {
            $ids = $this->Session->read('idnotaspese');
        } else {
            $ids = array_keys($this->request->data['Notaspesa']);
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
        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', array('cache' => 'legendamezzi', 'cacheConfig' => 'long')));
        $this->set('name', Configure::read('iGas.NomeAzienda') . "-NotaSpese");
    }

    public function stampa_collaboratore()
    {
        if (!isset($this->request->data['Notaspesa'])) {
            $ids = $this->Session->read('idnotaspese');
        } else {
            $ids = array_keys($this->request->data['Notaspesa']);
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
        if (!empty($cliente_id)) {
            $cliente = $this->Notaspesa->Persona->findById($cliente_id);
            $this->set('cliente', $cliente['Persona']);
        } else {
            $this->set('cliente', null);
        }

        $this->Session->write('idnotaspese', $ids);
        $this->set('name', Configure::read('iGas.NomeAzienda') . "-NotaSpese-Collaboratore");
    }

    public function scegli_persona()
    {

        //Se sono impiegato voglio vedere solo me stesso
        if (Auth::hasRole(Configure::read('Role.impiegato'))) {
            return $this->redirect(array('action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')));
        } else {
            $conditions['YEAR(Notaspesa.data)'] = date('Y');
        }

        $persone = $this->Notaspesa->find('all', array(
            'conditions' => $conditions,
            'fields' => array('DISTINCT Persona.id', 'Persona.Cognome', 'Persona.Nome')
        ));

        $anni = $this->Notaspesa->find('first', array('fields' => array('DISTINCT YEAR(Notaspesa.data) as Anno'), 'order' => 'Anno'));

        $this->set('eRisorsa', $this->Notaspesa->Persona->find('list', array('cache' => 'persona', 'cacheConfig' => 'short')));
        $this->set('persone', $persone);
        $this->set('annomin', $anni[0]);
        $this->set('title_for_layout', 'Scegli Persona | NotaSpese ');
        if ($this->request->is('post')) {
            return $this->redirect(array('action' => 'scegli_mese', $this->request->data['Notaspesa']['eRisorsa']));
        }
    }

    public function redirect_to_add()
    {
        $persona = $this->request->params['named']['persona'];
        $anno = $this->request->query['anno']['year'];
        $mese = $this->request->query['mese'];

        $this->redirect(array('action' => 'add', 'persona' => $persona, 'anno' => $anno, 'mese' => $mese));
    }

    public function scegli_mese($persona = null)
    {

        if (is_null($persona)) {
            return $this->redirect(array('action' => 'scegli_persona'));
        }

        if (
            $persona != $this->Session->read('Auth.User.persona_id') &&
            Auth::hasRole(Configure::read('Role.impiegato'))
        ) {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(array('action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')));
        }

        $this->set('persona', $this->Notaspesa->Persona->findById($persona));
        $this->set('title_for_layout', 'Scegli Mese | NotaSpese ' . $persona);
    }

    //Considera pagate una serie di ore, e quindi le toglie dal calcolo dell'avanzamento
    public function rimborsa($val)
    {
        $this->request->allowMethod('ajax', 'post');
        $this->autoRender = false;
        $ns = $this->request->data['Notaspesa'];

        if ($val == 'set') {
            $val = 1;
        } else {
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
