<?php

use Google\Service\Bigquery\ForeignTypeInfo;

App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');

class NotaspeseController extends AppController
{
    public $helpers = ['Tristate', 'Table', 'PdfToImage'];

    private function getConditionFromQueryString()
    {
        $conditions = [];
        $from = date('Y-m-01');
        $to = date('Y-m-t');
        $faseattivita_id = null;
        $persone = "";

        $persone = $this->request->query('persone');
        //Se la stringa è vuota non devo mettere la condizione
        if (!empty($persone)) {
            if (is_numeric($persone)) {
                $persone = [$persone];
            }
            $conditions['Notaspesa.eRisorsa IN'] = $persone;
        }

        $attivita = $this->request->query('attivita');
        if (!empty($attivita)) {
            if (is_numeric($attivita)) {
                $attivita = [$attivita];
            }
            if (is_array($attivita)) $conditions['Notaspesa.eAttivita IN'] = $attivita;
        }

        if (!empty($this->request->query('faseattivita_id'))) {
            $faseattivita_id = $this->request->query('faseattivita_id');
            $conditions['Notaspesa.faseattivita_id IN'] = $faseattivita_id;
        }


        if (!empty($this->request->query('from'))) {
            $from = $this->request->query('from');
            $conditions['Notaspesa.data >='] = $from;
        }
        if (!empty($this->request->query('to'))) {
            $to  = $this->request->query('to');
            $conditions['Notaspesa.data <='] = $to;
        }

        //Se vuoto imposto un default per non tirare su troppa roba
        if (count($conditions) == 0) {
            $persone = [AuthComponent::user('persona_id')];
            $conditions['Notaspesa.data >='] = $from;
            $conditions['Notaspesa.data <='] = $to;
            $conditions['Notaspesa.eRisorsa IN'] = $persone;
        }

        $this->set('attivita_selected', $attivita);
        $this->set('persona_selected', $persone);
        $this->set('from', $from);
        $this->set('to', $to);
        $this->set('faseattivita_id', $faseattivita_id);


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
            [
                'conditions' => $conditions,
                'fields' => [
                    'SUM(Notaspesa.importo) as importo'
                ]
            ]
        );
        //result2: get total importo of 'notaspese' according to search criteria grouped by attivita
        $result2 = $this->Notaspesa->find(
            'all',
            [
                'conditions' => $conditions,
                'contain' => ['Attivita.name'],
                'fields' => [
                    'Notaspesa.eAttivita, SUM(Notaspesa.importo) as importo'
                ],
                'group' => [
                    'Notaspesa.eAttivita'
                ]
            ]
        );
        //result3: get total importo of 'notaspese' according to search criteria grouped by risorsa (persona)
        $result3 = $this->Notaspesa->find(
            'all',
            [
                'conditions' => $conditions,
                'contain' => ['Persona.displayname'],
                'fields' => [
                    'Notaspesa.eRisorsa, SUM(Notaspesa.importo) as importo, Persona.DisplayName'
                ],
                'group' => [
                    'Notaspesa.eRisorsa'
                ]
            ]
        );
        //result4: get total importo of 'notaspese' according to search criteria grouped by attivita, risorsa (persona)
        $result4 = $this->Notaspesa->find(
            'all',
            [
                'conditions' => $conditions,
                'contain' => ['Persona.displayname', 'Attivita.name'],
                'fields' => [
                    'Notaspesa.eAttivita, Notaspesa.eRisorsa, SUM(Notaspesa.importo) as importo, Persona.DisplayName'
                ],
                'group' => [
                    'Notaspesa.eAttivita',
                    'Notaspesa.eRisorsa'
                ],
                'order' => [
                    'Notaspesa.eRisorsa',
                    'Notaspesa.eAttivita'
                ]
            ]
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
            [
                'fields' => ['Attivita.id', 'Attivita.name', 'Progetto.name'],
                'order' => ['Attivita.progetto_id', 'Attivita.name']
            ]
        );

        $attivitaGrouped = [];
        foreach ($attivita as $a) {
            if (!isset($attivitaGrouped[$a['Progetto']['name']])) $attivitaGrouped[$a['Progetto']['name']] = [];
            array_push($attivitaGrouped[$a['Progetto']['name']], $a);
        }

        return $attivitaGrouped;
    }

    function add($id = null)
    {
        $persona = AuthComponent::user('persona_id');
        $anno = date('Y');
        $mese = date('m');
        $giorno = date('d');
        $attivita = null;
        $rdata = $this->request->data;
        $destinazione = '';

        //Preparo il filtro per il riepilogo delle note spese
        $conditions = [];
        $this->set('title_for_layout', 'Aggiungi Nota Spese');

        if ($this->request->query('persona')) {
            $persona = $this->request->query['persona'];
            $conditions['Notaspesa.eRisorsa'] = $persona;
        }

        if ($this->request->query('anno')) {
            $anno = $this->request->query['anno'];
            $conditions['YEAR(Notaspesa.data)'] = $anno;
        }
        if ($this->request->query('mese')) {
            $mese = $this->request->query['mese'];
            $conditions['MONTH(Notaspesa.data)'] = $mese;
        }
        if ($this->request->query('giorno')) {
            $giorno = $this->request->query['giorno'];
        }
        if ($this->request->query('attivita')) {
            $attivita = $this->request->query['attivita'];
        }
        if ($this->request->query('dest')) {
            $destinazione = $this->request->query['dest'];
        }

        if (
            $persona != AuthComponent::user('persona_id')  &&
            Auth::hasRole(Configure::read('Role.impiegato'))
        ) {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(['action' => 'scegli_mese', AuthComponent::user('persona_id')]);
        }

        //Mi hanno chiamato per salvare
        if ($this->request->is('post')) {
            $this->Notaspesa->create();
            if (!$this->Notaspesa->save($rdata)) {
                $this->Session->setFlash('Errore durante il salvataggio della Nota Spese.', '/pages/home');
                return;
            }
            $this->Session->setFlash('Nota Spese salvata con successo');

            //Carico il file
            $id = $this->Notaspesa->getLastInsertID();
            $fileData = $this->request->data['Notaspesa']['uploadFile'];
            if ($this->Notaspesa->upload($id, $fileData, $persona, $anno, $mese)) {
                $this->Session->setFlash('Upload dell\'allegato completato con successo.');
            } else {
                $this->Session->setFlash('Upload del file fallito.');
            }

            //Convert the $rdata['Ora']['data'] to a DateTime object and take day, month, year
            $dt = new DateTime($rdata['Notaspesa']['data']);
            $mese = $dt->format('m');
            $giorno = $dt->format('d');
            $anno = $dt->format('Y');

            $attivita = $rdata['Notaspesa']['eAttivita'];
            $persona = $rdata['Notaspesa']['eRisorsa'];
            $destinazione = $rdata['Notaspesa']['destinazione'];

            //Se la nota spese non è di tipo viaggio, tolgo l'origine
            if ($rdata['Notaspesa']['eCatSpesa'] !== 1) { //Spostamento 
                $rdata['Notaspesa']['origine'] = null;
                $rdata['Notaspesa']['destinazione'] = null;
            }

            //TODO: Permettere di allegare il documento

            //A seconda del submit premuto vado nella direzione opportuna
            if (isset($this->request->data['submit-ore'])) {
                return $this->redirect([
                    'controller' => 'ore', 'action' => 'add',
                    '?' => [
                        'persona' => $rdata['Notaspesa']['eRisorsa'],
                        'attivita' => $rdata['Notaspesa']['eAttivita'],
                        'anno' => $anno,
                        'mese' => $mese,
                        'giorno' => $giorno,
                        'dest' => $rdata['Notaspesa']['LuogoTrasferta'] ?? null,
                    ]
                ]);
            } else {
                return $this->redirect([
                    'action' => 'add',
                    '?' => [
                        'persona' => $rdata['Notaspesa']['eRisorsa'],
                        'attivita' => $rdata['Notaspesa']['eAttivita'],
                        'anno' => $anno,
                        'mese' => $mese,
                        'giorno' => $giorno,
                    ]
                ]);
            }
        }

        $this->set('eAttivita', $this->Notaspesa->Attivita->getlist());

        //Se sono un impiegato posso vedere solo le mie ore
        if (Auth::hasRole(Configure::read('Role.impiegato'))) {
            $this->set('eRisorse', $this->Notaspesa->Persona->find('list', [
                'conditions' => ['id' => $persona]
            ]));
        } else {
            //Devo usare questa versione ottimizzata altrimenti va in out of memory
            $this->loadModel('Impiegato');
            $erisorse = $this->Impiegato->list();
            $this->set('eRisorse', $erisorse);
        }

        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', ['cache' => 'legendamezzi', 'cacheConfig' => 'long']));
        $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list', [
            'conditions' => ['not' => ['voceNotaSpesa' => NULL]],
            'cache' => 'legendacatspesa_notnull', 'cacheConfig' => 'short'
        ]));
        $this->set('provenienzasoldi_id', $this->Notaspesa->Provenienzasoldi->find('list', []));
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
            [
                'conditions' => $conditions,
                'fields' => [
                    'id', 'Notaspesa.eRisorsa', 'importo', 'Notaspesa.data', 'descrizione', 'origine',
                    'destinazione', 'km', 'eAttivita', 'LegendaCatSpesa.name', 'fatturabile', 'rimborsabile', 'provenienzasoldi_id', 'IdGoogleCloud', 'faseattivita_id', 'Faseattivita.Descrizione',
                ],
                'order' => ['Notaspesa.eRisorsa',  'Notaspesa.data'],
            ]
        );

        $this->set('result', $result);
    }


    //Wrapper per la funzione edit
    function edit($id)
    {
        $notaspesa = $this->Notaspesa->findById($id);
        $persona = AuthComponent::user('persona_id');
        //Non ho trovato la notaspese
        if (empty($notaspesa)) {
            return $this->redirect(
                [
                    'controller' => 'notaspese',
                    'action' => 'add',
                    '?' => [
                        'persona' => $persona,
                        'anno' => date('Y'),
                        'mese' => date('m')
                    ]
                ]
            );
        }

        //Verifico i permessi
        if (
            $persona != AuthComponent::user('persona_id')  &&
            Auth::hasRole(Configure::read('Role.impiegato'))
        ) {
            $this->Session->setFlash('Non sei autorizzato ad accedere alla nota spese di altri');
            return $this->redirect(['action' => 'scegli_mese', AuthComponent::user('persona_id')]);
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Notaspesa->save($this->request->data, false)) {
                $this->Session->setFlash('Notaspese Modificata correttamente.');
                //Carico il file
                $fileData = $this->request->data['Notaspesa']['uploadFile'];
                $mese = $this->request->data['Notaspesa']['data']['month'];
                $anno = $this->request->data['Notaspesa']['data']['year'];
                
                if ($this->Notaspesa->upload($id, $fileData, $persona, $anno, $mese)) {
                    $this->Session->setFlash('Upload dell\'allegato completato con successo.');
                } else {
                    $this->Session->setFlash('Upload del file fallito.');
                }

                return $this->redirect([
                    'action' => 'add',
                    '?' => [
                        'persona' => $this->request->data['Notaspesa']['eRisorsa'],
                        'anno' => $this->request->data['Notaspesa']['data']['year'],
                        'mese' => $this->request->data['Notaspesa']['data']['month']
                    ]
                ]);
            } else {
                $this->Session->setFlash('Impossibile salvare questa notaspese.' . json_encode($this->Notaspesa->validationErrors));
            }
        }
        $this->loadModel('Impiegato');
        $erisorse = $this->Impiegato->list();

        $this->set('eRisorse', $erisorse);
        $this->data = $this->Notaspesa->findById($id);
        $dt = new DateTime($this->data['Notaspesa']['data']);
        $mese = $dt->format('m');
        $anno = $dt->format('Y');
        $attachments = $this->Notaspesa->getAttachments($id, $persona, $mese, $anno);
        $this->set('attachments', $attachments);

        $this->set('id', $id);
        $this->set('eAttivita', $this->Notaspesa->Attivita->getlist());
        $this->set('eRisorsa', $this->data['Notaspesa']['eRisorsa']);
        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', ['cache' => 'legendamezzi', 'cacheConfig' => 'short']));
        $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list', ['cache' => 'legendacatspesa_notnull', 'cacheConfig' => 'short']));
        $this->set('provenienzasoldi_id', $this->Notaspesa->Provenienzasoldi->find('list', []));
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
        $conditions = [];

        //
        if (empty($this->request->params['named'])) {
            $this->Session->setFlash('Ti consiglio di invocare questa funzione passando dal menu a sinistra '
                . Router::url(['action' => 'scegli_persona'])
                . '   per non rischiare di fare confusione e caricare le spese a nome di altri. ');
            $this->redirect(['action' => 'scegli_persona']);
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
        $this->set('eRisorse', $this->Notaspesa->Persona->find('list', ['cache' => 'persona', 'cacheConfig' => 'short']));
        $this->set('eRisorsa', $persona);
        $this->set('anno', $anno);
        $this->set('mese', $mese);
        $this->set('giorno', $giorno);

        $this->Notaspesa->contain('LegendaCatSpesa', 'Faseattivita');
        $result = $this->Notaspesa->find(
            'all',
            [
                'conditions' => $conditions,
                'fields' => [
                    'id', 'Notaspesa.eRisorsa', 'importo', 'Notaspesa.data', 'descrizione', 'origine',
                    'destinazione', 'km', 'eAttivita', 'LegendaCatSpesa.name', 'fatturabile', 'rimborsabile', 'faseattivita_id', 'Faseattivita.Descrizione',
                ],
                'order' => ['Notaspesa.eRisorsa',  'Notaspesa.data'],
            ]
        );

        $this->set('result', $result);
        $this->set('title_for_layout', "Modifica Nota Spese");
        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', ['cache' => 'legendamezzi', 'cacheConfig' => 'short']));
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
            $this->set('eRisorse', $this->Notaspesa->Persona->find('list', ['cache' => 'persona', 'cacheConfig' => 'short']));
            $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', ['cache' => 'legendamezzi', 'cacheConfig' => 'short']));
            $this->set('eCatSpesa', $this->Notaspesa->LegendaCatSpesa->find('list', ['cache' => 'legendacatspesa', 'cacheConfig' => 'short']));
            $this->set('attivita_default', $attivita);
            $this->set('dest', $dest);
            $this->set('giorno', $giorno);
            $this->render('edit_riga');
            //Todo: non viene gestita la fase, se la perde ad ogni edit!
        }
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
            [
                'conditions' => $conditions,
                'fields' => [
                    'id', 'Notaspesa.eRisorsa', 'importo', 'Notaspesa.data', 'descrizione', 'origine',
                    'destinazione', 'Faseattivita.descrizione', 'km', 'eAttivita', 'LegendaCatSpesa.name', 'rimborsato', 'fatturato',
                    'rimborsabile',
                    'fatturabile'
                ],
                'order' => ['Notaspesa.eRisorsa', 'Notaspesa.data'],
            ]
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
        $this->set('eProvSoldi', $this->Notaspesa->Provenienzasoldi->find('list', []));

        $this->set('title_for_layout', "$attivita | $persone | Dettaglio Nota Spese");
    }

    public function delete($id, $dest = null)
    {
        //$this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Notaspese'));
            $this->redirect(['action' => 'index']); //La view index non è mai esistita e non c'è il metodo index in questo controller
        }
        if ($this->Notaspesa->delete($id)) {
            $this->Session->setFlash(__('Notaspese deleted'));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('Notaspese was not deleted'));
        $this->redirect(['action' => 'index']); //La view index non è mai esistita e non c'è il metodo index in questo controller
    }

    //Elimina l'allegato
    public function deleteDoc($f, $persona, $mese, $anno)
    {
        $f = urldecode($f);
        $persona = AuthComponent::user('persona_id');
        //Verifico i permessi
        if (
            $persona != AuthComponent::user('persona_id')  &&
            Auth::hasRole(Configure::read('Role.impiegato'))
        ) {
            $this->Flash->error('Non sei autorizzato ad accedere alla nota spese di altri');
            return $this->redirect(['action' => 'scegli_mese', AuthComponent::user('persona_id')]);
        }
        // Check if the file exists
        $uploadPath = CakeText::insert($this->Notaspesa->uploadPattern, ['persona' => $persona, 'anno' => $anno, 'mese' => $mese]);
        if (file_exists("$uploadPath{$f}")) {
            // Attempt to delete the file
            if (unlink("$uploadPath{$f}")) {
                echo "File '$f' has been deleted successfully.";
                $this->redirect($this->referer());
            } else {
                echo "Error: Could not delete the file '$f'.";
                $this->redirect($this->referer());
            }
        } else {
            echo "Error: The file '$f' does not exist.";
            $this->redirect($this->referer());
        }
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
        Configure::write('debug', 0);
        if (!isset($this->request->data['Notaspesa'])) {
            $ids = CakeSession::read('idnotaspese');
        } else {
            $ids = array_keys($this->request->data['Notaspesa']);
        }
        if (empty($ids)) {
            $this->Session->setFlash(__('Nessuna nota spese selezionata'));
            $this->redirect('/notaspese/stats');
        }

        $righens = $this->Notaspesa->find('all', [
            'conditions' => ['Notaspesa.id IN' => $ids],
            'order' => ['Notaspesa.data'],
        ]);
        $this->set('notaspese', $righens);

        $attachments = $this->read_attachments($righens);
        $this->set('attachments', $attachments);
        
        //Qui tiro su l'anagrafica dell'azienda che emette la fattura
        $azienda =  $this->Notaspesa->Persona->findById(Configure::read('iGas.idAzienda'));
        $this->set('azienda', $azienda);

        //Scrivo come destinatario della nota spese il cliente della prima attività
        $cliente_id = $righens[0]['Attivita']['cliente_id'];
        $cliente = $this->Notaspesa->Persona->findById($cliente_id);

        $this->set('cliente', $cliente['Persona']);
        CakeSession::write('idnotaspese', $ids);

        $this->set('legenda_mezzi', $this->Notaspesa->LegendaMezzi->find('all', ['cache' => 'legendamezzi', 'cacheConfig' => 'long']));
        $this->set('name', Configure::read('iGas.NomeAzienda') . "-NotaSpese");
    }

    public function stampa_collaboratore()
    {
        Configure::write('debug', 0);
        if (!isset($this->request->data['Notaspesa'])) {
            $ids = $this->Session->read('idnotaspese');
        } else {
            $ids = array_keys($this->request->data['Notaspesa']);
        }

        $righens = $this->Notaspesa->find('all', [
            'conditions' => ['Notaspesa.id IN' => $ids],
            'order' => ['Notaspesa.data'],
        ]);
        $this->set('notaspese', $righens);

        $attachments = $this->read_attachments($righens);
        $this->set('attachments', $attachments);

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

    private function read_attachments($righens){
                //Per ogni riga devo caricare gli allegati
                $attachments = [];
                foreach ($righens as $r ) {
                    $dt = new DateTime($r['Notaspesa']['data']);
                    $idn = $r['Notaspesa']['id'];
                    $mese = $dt->format('m');
                    $anno = $dt->format('Y');
                    $res = $this->Notaspesa->getAttachments($idn, $r['Notaspesa']['eRisorsa'], $mese, $anno);            
                    foreach ($res as $rs) {
                        $attachments[] = $rs;
                    }
                }
                return $attachments;
    }
    public function scegli_persona()
    {

        //Se sono impiegato voglio vedere solo me stesso
        if (Auth::hasRole(Configure::read('Role.impiegato'))) {
            return $this->redirect(['action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')]);
        } else {
            $conditions['YEAR(Notaspesa.data)'] = date('Y');
        }
        $this->loadModel('Impiegato');
        $persone = $this->Impiegato->list();

        $anni = $this->Notaspesa->find('first', ['fields' => ['DISTINCT YEAR(Notaspesa.data) as Anno'], 'order' => 'Anno']);

        $this->set('persone', $persone);
        $this->set('annomin', $anni[0]);
        $this->set('title_for_layout', 'Scegli Persona | NotaSpese ');
        if ($this->request->is('post')) {
            return $this->redirect(['action' => 'scegli_mese', $this->request->data['Notaspesa']['eRisorsa']]);
        }
    }

    public function redirect_to_add()
    {
        $persona = $this->request->params['named']['persona'];
        $anno = $this->request->query['anno']['year'];
        $mese = $this->request->query['mese'];

        $this->redirect(['action' => 'add', 'persona' => $persona, 'anno' => $anno, 'mese' => $mese]);
    }

    public function scegli_mese($persona = null)
    {

        if (is_null($persona)) {
            return $this->redirect(['action' => 'scegli_persona']);
        }

        if (
            $persona != $this->Session->read('Auth.User.persona_id') &&
            Auth::hasRole(Configure::read('Role.impiegato'))
        ) {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(['action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')]);
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
            ['Notaspesa.rimborsato' => $val],
            // conditions
            ['Notaspesa.id' => $ids]
        );

        $this->Session->setFlash('Le notespese selezionate sono considerate rimborsate');
    }
}
