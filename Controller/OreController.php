<?php
//require_once (APP . 'Plugin' . DS . 'Tools'. DS . 'vendor' . DS . 'SpreadsheetExcelReader'. DS. 'SpreadsheetExcelReader.php');
App::uses('AppController', 'Controller', 'CakeEmail', 'Network/Email');
App::uses('CakeEmail', 'Network/Email'); // Perchè CakePHP mi obbliga a spezzare App::uses in 2 righe per far funzionare CakeEmail ???

class OreController extends AppController
{

    public $components = array('RequestHandler', 'PhpExcel.PhpSpreadsheet');
    public $helpers = array('Cache', 'PhpExcel.PhpSpreadsheet');
    //public $cacheAction = "1 month";

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
                $conditions['Ora.eRisorsa IN'] = $persone;
            }
        }
        if (!empty($this->request->query['attivita'])) {
            $attivita = $this->request->query['attivita'];
            //Se la stringa è vuota non devo mettere la condizione
            if (!empty($attivita)) {
                if (is_numeric($attivita)) {
                    $attivita = array($attivita);
                }
                if (is_array($attivita)) $conditions['Ora.eAttivita IN'] = $attivita;
            }
        }

        if (!empty($this->request->query['from'])) {
            $conditions['Ora.data >='] = $this->request->query['from'];
        }
        if (!empty($this->request->query['to'])) {
            $conditions['Ora.data <='] = $this->request->query['to'];
        }
        if (!empty($this->request->query['faseattivita_id'])) {
            $conditions['Ora.faseattivita_id IN'] = $this->request->query['faseattivita_id'];
        }


        $this->set('attivita_selected', $attivita);
        $this->set('persona_selected', $persone);
        return $conditions;
    }

    //display statistics about 'ore'
    function stats()
    {
        $this->Ora->recursive = -1;
        $conditions = $this->getConditionFromQueryString();

        if (($this->Session->read('Auth.User.group_id') != 1) and ($this->Session->read('Auth.User.group_id') != 2)) {
            $conditions['Ora.eRisorsa IN'] = array($this->Session->read('Auth.User.persona_id'));
        }

        //result1: get total number of 'ore' according to search criteria
        $result1 = $this->Ora->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'SUM(Ora.numOre) as numOre'
                )
            )
        );
        //result2: get total number of 'ore' according to search criteria grouped by attivita                
        $result2 = $this->Ora->find(
            'all',
            array(
                'conditions' => $conditions,
                'contain' => array('Attivita.name'),
                'fields' => array(
                    'Ora.eAttivita, Attivita.name, SUM(Ora.numOre) as numOre'
                ),
                'group' => array(
                    'Ora.eAttivita'
                ),
                'order' => array(
                    'Attivita.name'
                ),
            )
        );
        //result3: get total number of 'ore' according to search criteria grouped by risorsa (persona)        
        $result3 = $this->Ora->find(
            'all',
            array(
                'conditions' => $conditions,
                'contain' => array('Persona.displayname'),
                'fields' => array(
                    'Ora.eRisorsa, Persona.DisplayName, SUM(Ora.numOre) as numOre'
                ),
                'group' => array(
                    'Ora.eRisorsa'
                ),
                'order' => array(
                    'Persona.DisplayName',
                )
            )
        );
        //result4: get total number of 'ore' according to search criteria grouped by attivita, risorsa (persona)
        $result4 = $this->Ora->find(
            'all',
            array(
                'conditions' => $conditions,
                'contain' => array('Persona.displayname', 'Attivita.name'),
                'fields' => array(
                    'Ora.eAttivita, Ora.eRisorsa, Attivita.name, Persona.DisplayName, SUM(Ora.numOre) as numOre'
                ),
                'group' => array(
                    'Ora.eAttivita',
                    'Ora.eRisorsa'
                ),
                'order' => array(
                    'Persona.DisplayName',
                    'Attivita.name'
                )
            )
        );

        $this->set('result1', $result1);
        $this->set('result2', $result2);
        $this->set('result3', $result3);
        $this->set('result4', $result4);

        $attivita_list = $this->Ora->Attivita->getlist();
        $this->set('attivita_list', $attivita_list);

        $persona_list = $this->Ora->getPersone();
        $this->set('persona_list', $persona_list);

        $fa = $this->Ora->Faseattivita->getSimple();
        $this->set('faseattivita', $fa);

        //display 'attivita' select options
        //$progetti = $this->_getAttivitaListGroupedByProgetto();
        //$this->set('progetti', $progetti);
        $this->set('title_for_layout', "Statistiche Ore | Foglio Ore");
    }


    //Funzione analoga a stats ma restituise il dettaglio, dati i parametri
    function detail()
    {
        $attivita = '';
        $persone = '';
        $faseattivita = '';
        $this->Ora->recursive = -1;
        $this->Ora->contain('Faseattivita.descrizione');
        $conditions = $this->getConditionFromQueryString();

        $result = $this->Ora->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'Ora.id', 'Ora.eRisorsa', 'numOre', 'data', 'dettagliAttivita', 'luogoTrasferta', 'eAttivita', 'pagato', 'fatturato', 'Faseattivita.Descrizione'
                ),
                'order' => array('Ora.eRisorsa',  'data'),
            )
        );
        $this->set('result', $result);

        $this->set('faseattivita_selected', $faseattivita);
        $this->set('attivita_selected', $attivita);
        $this->set('persona_selected', $persone);

        //Queste mi servono per scrivere il nome dell'attività invece del numero
        $attivita_list = $this->Ora->Attivita->getlist();
        $this->set('attivita_list', $attivita_list);

        $persona_list = $this->Ora->getPersone();
        $this->set('persona_list', $persona_list);

        $fa = $this->Ora->Faseattivita->getSimple();
        $this->set('faseattivita', $fa);

        $this->set('title_for_layout', $this->str_attivita_persone($attivita, $persone) . " | Dettaglio Ore");
    }

    //Esplicito i nomi di attività e persone
    private function str_attivita_persone($attivita, $persone)
    {
        $persona_list = $this->Ora->Persona->find('list');
        $attivita_list = $this->Ora->Attivita->getlist();

        $l = '';
        if (is_array($attivita)) {
            foreach ($attivita as $a) {
                $l .= $attivita_list[$a] . " ";
            }
        }
        $l .= ' / ';
        if (is_array($persone)) {
            foreach ($persone as $a) {
                $l .= $persona_list[$a] . " ";
            }
        }
        return $l;
    }


    function upload()
    {
        if (!empty($this->request->data['Ora'])) {
            foreach ($this->request->data['Ora']['file'] as $file) {
                if ($this->_isFileUploaded($file)) {
                    if ($this->_isSpreadSheet($file)) {
                        //process file
                        $result[$file['name']]['ore'] = $this->_getOre($file['tmp_name']);
                        $result[$file['name']]['nota_spese'] = $this->_getNotaSpese($file['tmp_name']);
                    } else {
                        //invalid file
                        $result[$file['name']]['ore'] = '';
                        $result[$file['name']]['nota_spese'] = '';
                    }
                }
            }

            $keys = array_keys($result);

            $flashMessage = '';

            $this->loadModel('Attivita');
            $this->loadModel('Notaspesa');
            foreach ($keys as $filename) {
                if (empty($result[$filename]['ore']) && empty($result[$filename]['nota_spese'])) {
                    $flashMessage .= $filename . ' is an invalid file and could not be processed.<br>';
                } else {
                    //Massimoi 2/5/12 - Scrivo i messaggi informativi
                    $flashMessage .= $filename . ': ' . $result[$filename]['ore']['info'] . '<br>';
                    $flashMessage .= $filename . ': ' . $result[$filename]['nota_spese']['info'] . '<br>';

                    //Se non ci sono errori procedo
                    if (!empty($result[$filename]['ore']['error'])) $flashMessage .= $filename . ': ' . $result[$filename]['ore']['error'] . '<br>';
                    else if (!empty($result[$filename]['ore']['nota_spese'])) $flashMessage .= $filename . ': ' . $result[$filename]['nota_spese']['error'] . '<br>';
                    else {
                        //massimoi 27/8/13
                        $o = $result[$filename]['ore']['data'][0];
                        $st = new DateTime($o['data']);

                        //Elimino tutti i record di questo mese per questo utente prima di importare.
                        //In questo modo non devo controllare prima di inserire
                        if ($this->Ora->deleteAll(
                            array(
                                'Ora.eRisorsa' => $o['eRisorsa'],
                                'MONTH(Ora.data)' =>  $st->format('m'),
                                'YEAR(Ora.data)' =>  $st->format('Y'),
                            ),
                            false
                        )) {
                            $flashMessage .= 'Cancellata la vecchia versione del foglio ore di ' . $st->format('m-Y') . '<br/>';
                        }
                        //Stesso ragionamento per la nota spese
                        if ($this->Notaspesa->deleteAll(
                            array(
                                'eRisorsa' => $o['eRisorsa'],
                                'MONTH(data)' =>  $st->format('m'),
                                'YEAR(data)' =>  $st->format('Y'),
                            ),
                            false
                        )) {
                            $flashMessage .= 'Cancellata la vecchia versione della nota spese di ' . $st->format('m-Y') . '<br/>';
                        }

                        $db_save_ok = true;
                        //save 'ore'
                        foreach ($result[$filename]['ore']['data'] as $o) {
                            //MASSIMOI 27-8-13 - siccome ho cancellato prima non devo più fare questo controllo, inserisco sempre.
                            //check that this 'ora' was not processed yet, otherwise skip
                            //							$duplicate = $this->Ora->find('all', array('conditions' => array(
                            //								'Ora.eRisorsa' => $o['eRisorsa'],
                            //								'Ora.eAttivita' => $o['eAttivita'],
                            //								'Ora.data' => $o['data'],
                            //							)));

                            //Se la riga c'è già la ignoro e non la importo come aggiornamento
                            //							if(empty($duplicate))
                            {
                                $this->Ora->create($o);
                                if (!$this->Ora->save($this->Ora->data)) {
                                    $flashMessage .= $filename . ': one or more "ore" could not be saved due to a database problem. Process again the file (already inserted records won\'t be affected).<br>';
                                    $flashMessage .= "Attività: " . $o['eAttivita'] . '<br/>';
                                    $flashMessage .= "data: " . $o['data'] . '<br/>';
                                    $this->log($this->Ora->validationErrors, 'debug');
                                    $db_save_ok = false;
                                    break;
                                }
                            }
                        }

                        if (isset($result[$filename]['nota_spese']['data'])) {
                            //save 'nota spese'
                            foreach ($result[$filename]['nota_spese']['data'] as $o) {
                                //check that this 'nota spesa' was not processed yet, otherwise skip
                                //							$duplicate = $this->Notaspesa->find('all', array('conditions' => array(
                                //								'Notaspesa.eRisorsa' => $o['eRisorsa'],
                                //								'Notaspesa.eAttivita' => $o['eAttivita'],
                                //								'Notaspesa.data' => $o['data'],
                                //								'Notaspesa.importo' => $o['importo'],
                                //							)));
                                //							if(empty($duplicate))
                                {
                                    $this->Notaspesa->create($o);
                                    if (!$this->Notaspesa->save($this->Notaspesa->data)) {
                                        $flashMessage .= $filename . ': one or more "nota spese" could not be saved due to a database problem. Process again the file (already inserted records won\'t be affected).<br>';
                                        $db_save_ok = false;
                                        break;
                                    }
                                }
                            }
                        }

                        if ($db_save_ok) $flashMessage .= $filename . ': file was successfully processed.<br>';
                    }
                }
            }
            $this->Session->setFlash(__($flashMessage));
        }
        $this->set('title_for_layout', "Carica Foglio Ore XLS | Foglio Ore");
    }

    //Carica il foglio ore (deve avere l'etichetta Ore_iMpronta)
    function _getOre($fileurl)
    {
        $result['data'] = array();
        $result['error'] = '';
        $result['info'] = '';

        $data = new Spreadsheet_Excel_Reader($fileurl);
        $ore_impronta_sheet =   $this->_getXlsSheetName2Number($data, 'Ore_iMpronta');
        if ($ore_impronta_sheet < 0) {
            $this->Session->setFlash('Impossibile trovare il foglio Ore_iMpronta');
            return -1;
        }
        $aliases_row = 6;

        $rows = $data->rowcount($ore_impronta_sheet);
        $result['info'] .= "Righe: $rows<br/>";
        $cols = $data->colcount($ore_impronta_sheet);
        $result['info'] .= "Colonne: $cols<br/>";
        $this->log("Inserimento foglio ore: Caricato nuovo foglio: $fileurl - righe: $rows - colonne: $cols", 'debug');

        $details = $this->_getDettagliFoglioOre($fileurl);

        //get id of the resource (person) to which this foglio ore is related to
        $tokens = explode(" ", $details['nome_risorsa']);
        $risorsa_id = $this->_getRisorsaID($tokens[0], $tokens[1]);
        $result['info'] .= 'Foglio Caricato per ' . $tokens[0] . ' ' . $tokens[1] . ', id: ' . $risorsa_id . '<br/>';

        $this->log("Inserimento foglio ore: Dettagli Persona: $risorsa_id", 'debug');

        if ($risorsa_id == 0) {
            $result['error'] = 'Resource ' . $details['nome_risorsa'] . ' is unknown';
            return $result;
        }

        $this->loadModel('Attivita');
        $this->Attivita->recursive = -1;
        //build entries for each attivita
        for ($attivita_col = 2; $attivita_col < $cols; $attivita_col++) //for each attivita (last column is the total)
        {

            $ore = array(); //reset at each iteration
            $attivita_alias = $data->val($aliases_row, $attivita_col, $ore_impronta_sheet);

            //Massimoi: 5 Settembre 2013 - Se trovo la colonna totale esco subito = ho finito le colonne utili
            if (trim(strtolower($attivita_alias)) == 'totale') {
                break;
            }

            //Massimoi - 26/8/13
            //Nel file excel è indicato l'alias di un progetto (o il suo nome)
            if (!empty($attivita_alias)) {
                //Massimoi: 5/9/13 - Tolgo gli alias separati da virgole e normalizzo (cattiva idea usare un campo tag!)
                //Cerco l'attività per nome
                $attivita = $this->Attivita->findByName($attivita_alias);
                //Se non la trovo per nome la cerco per alias
                if (empty($attivita['Attivita']['id'])) {
                    $this->log("Attivita $attivita_alias non trovata, cerco un alias", 'debug');
                    $attivita = $this->Attivita->Alias->findByName($attivita_alias);
                    $this->log($attivita, 'debug');
                }

                //debug($attivita);
                if (empty($attivita['Attivita']['id'])) {
                    $this->log("Attivita $attivita_alias non trovata, creo un'attivita nuova", 'debug');
                    //Massimoi 2/5/12 [ se non c'è l'attività nè l'alias, la creo vuota
                    $d = array(
                        'Attivita' => array(
                            'name' => $attivita_alias,
                            'area_id' => 1,                    //TODO: Leggere una variabile di configurazione: default_area
                            'progetto_id' => 6,                //TODO: Leggere una variabile di configurazione: default_project
                            'cliente_id' => 1,                //TODO: Leggere una variabile di configurazione: default_customer							
                        ),
                    );
                    $this->Attivita->create();
                    $this->Attivita->save($d);
                    //Leggo l'array completa dell'attività					
                    $attivita = $this->Attivita->read();
                    // ] Massimoi

                    $result['info'] .= 'Attivita alias "' . $attivita_alias . '" has been created<br/>';
                    //return $result;
                }
                $this->log("Inserimento foglio ore: Trovata attivita $attivita_alias : " . $attivita['Attivita']['id'], 'debug');
                for ($row = $aliases_row + 2; $row < $rows - 4; $row += 3) //for each day
                {
                    $numero_ore = $data->val($row, $attivita_col, $ore_impronta_sheet);
                    if (!empty($numero_ore)) {
                        if (is_nan($numero_ore)) {
                            $result['error'] = 'Cell (' . $row . ',' . $attivita_col . ') is not a valid number';
                            return $result;
                        } else {
                            $luogoTrasferta = $data->val($row + 2, $attivita_col, $ore_impronta_sheet);

                            //add 'ora' to the result
                            array_push($ore, array(
                                'eRisorsa' => $risorsa_id,
                                'eAttivita' => $attivita['Attivita']['id'],
                                'data' => $details['anno'] . '-' . $this->_formatMese($details['mese']) . '-' . $this->_formatGiorno($data->val($row, 1, $ore_impronta_sheet)) . ' 00:00:00',
                                'numOre' => $data->val($row, $attivita_col, $ore_impronta_sheet), //num ore!
                                'dettagliAttivita' => $data->val($row + 1, $attivita_col, $ore_impronta_sheet),
                                'LuogoTrasferta' => $luogoTrasferta,
                                'Trasferta' => (empty($luogoTrasferta)) ? 0 : 1,
                                'Pernottamento' => 0, //???
                                'statoApprovazione' => 0 //???
                            ));
                        }
                    }
                }

                $result['data'] = array_merge($result['data'], $ore);
            }
        }

        return $result;
    }

    //Gets the XLS sheet number corresponding to the given sheet name
    //lowercase comparison
    function _getXlsSheetName2Number($xls, $name)
    {
        $name =  strtolower($name);
        //debug("Cerco il foglio: $name");

        $sheet_number = -1;
        for ($i = 0; $i < count($xls->sheets); $i++) {
            if (strtolower($xls->boundsheets[$i]['name']) == $name) {
                $sheet_number = $i;
                break;
            }
        }

        //No match: return -1
        //debug("Sheet Number $sheet_number = $name");
        return $sheet_number;
    }

    function _getNotaSpese($fileurl)
    {

        $result['data'] = array();
        $result['error'] = '';
        $result['info'] = '';

        $data = new Spreadsheet_Excel_Reader($fileurl);

        $nota_spese_sheet = $this->_getXlsSheetName2Number($data, 'NotaSpese');
        $start_row = 5;

        //Se non c'è il foglio della nota spese esco subito
        if ($nota_spese_sheet < 0) {
            return;
        }

        $rows = $data->rowcount($nota_spese_sheet);
        $cols = $data->colcount($nota_spese_sheet);

        $details = $this->_getDettagliFoglioOre($fileurl);

        //get id of the resource (person) to which this foglio ore is related to
        $tokens = explode(" ", $details['nome_risorsa']);
        $risorsa_id = $this->_getRisorsaID($tokens[0], $tokens[1]);
        if ($risorsa_id == 0) {
            $result['error'] = 'Resource ' . $details['nome_risorsa'] . ' is unknown';
            return $result;
        }

        $this->loadModel('Notaspesa');
        $this->loadModel('Attivita');
        //build entries for each nota spesa
        for ($row = $start_row; $row <= $rows; $row++) {
            //NOTE: since the library is not capable of handling dates in the correct way, by default set as date first day of the month to which foglio ore refers to
            $importo = $data->raw($row, 4, $nota_spese_sheet);
            if (empty($importo)) $importo = (float) $data->raw($row, 4, $nota_spese_sheet);
            if (is_nan($importo)) {
                $result['error'] = 'Cell (' . $row . ',4) is not a valid number';
                return $result;
            }

            $attivita_alias = $data->val($row, 3, $nota_spese_sheet);
            if (empty($attivita_alias)) {
                $result['error'] = 'A nota spesa cannot be processed because attivita alias in cell (' . $row . ',3) is empty';
                return $result;
            }

            //Cerco l'attività per nome
            $attivita = $this->Attivita->findByName($attivita_alias);
            //Se non la trovo per nome la cerco per alias
            if (empty($attivita['Attivita']['id'])) {
                $this->log("NotaSpese: Attivita $attivita_alias non trovata, cerco un alias", 'debug');
                $attivita = $this->Attivita->Alias->findByName($attivita_alias);
                $this->log($attivita, 'debug');
            }

            if (empty($attivita['Attivita']['id'])) {
                $result['error'] = 'Attivita alias "' . $attivita_alias . '" is unknown';
                return $result;
            }

            array_push($result['data'], array(
                'eAttivita' => $attivita['Attivita']['id'],
                'eRisorsa' => $risorsa_id,
                'data' => $details['anno'] . '-' . $this->_formatMese($details['mese']) . '-01 00:00:00',
                'eCatSpesa' => 0, //???				
                'importo' => $importo,
                'fatturabile' => 0, //???
                'rimborsabile' => 0, //???
            ));
        }

        return $result;
    }

    function _getRisorsaID($nome, $cognome)
    {
        //TODO: al momento individuo la risorsa sulla base della coppia (nome, cognome) ma il meccanismo non è efficiente in quanto ci possono
        //essere omonimi, persone con più nomi ecc...  --> bisognerebbe che i fogli ore riportassero l'id della risorsa!!!
        $this->loadModel('Persona');
        $risorsa = $this->Persona->find('first', array('conditions' => array('Persona.Nome LIKE' => $nome, 'Persona.Cognome LIKE' => $cognome)));
        return (empty($risorsa)) ? 0 : $risorsa['Persona']['id'];
    }

    //retrieves details of this 'foglio ore'
    function _getDettagliFoglioOre($fileurl)
    {
        $ore_impronta_sheet = 0;

        $data = new Spreadsheet_Excel_Reader($fileurl, false); //false: do not store information about fonts,colors,etc...
        $details['nome_risorsa'] = $data->val(1, 1, $ore_impronta_sheet);
        $details['mese'] = $data->val(3, 1, $ore_impronta_sheet);
        $details['anno'] = $data->val(4, 1, $ore_impronta_sheet);

        return $details;
    }

    //from cakephp cookbook
    function _isFileUploaded($params)
    {
        if ((isset($params['error']) && $params['error'] == 0) || (!empty($params['tmp_name']) && $params['tmp_name'] != 'none')) {
            return is_uploaded_file($params['tmp_name']);
        }
        return false;
    }

    function _isSpreadSheet($file)
    {
        return true;

        $allowedTypes = array(
            'application/vnd.ms-excel'
        );

        if (in_array($file['type'], $allowedTypes)) return true;
        return false;
    }

    function _formatMese($mese)
    {
        if (strlen($mese) == 1) return '0' . $mese;
        return $mese;
    }

    function _formatGiorno($mese)
    {
        if (strlen($mese) == 1) return '0' . $mese;
        return $mese;
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

    //Massimoi - 30/8/2013 - Mostra quali fogli ore sono stati caricati per ogni dipendente per ogni anno
    function riassuntocaricamenti($anno)
    {
        $attivita_list = $this->Ora->Attivita->getlist();
        $this->set('attivita_list', $attivita_list);
        $persona_list = $this->Ora->getPersone();
        $this->set('persona_list', $persona_list);
        $this->set('currentMonth', date('m'));
        $conditions = [];
        $conditions = $this->getConditionFromQueryString();
        $conditions['YEAR(Ora.data)'] = $anno;
        $conteggi = $this->Ora->find('all', array(
            'conditions' => $conditions,
            'group' => array('Persona.id', 'Persona.Cognome', 'MONTH(Ora.data)'),
            'order' => array('Persona.id', 'Persona.Cognome', 'MONTH(Ora.data)'),
            'fields' => array('Persona.id', 'Persona.Cognome', 'MONTH(Ora.data) as Mese', 'SUM(Ora.numOre) as OreTot')
        ));

        //Giro la tabella risultante in modo da avere questa struttura associativa (che mi facilita la view)
        //Persona => (Gennaio => ore, Feb => ore, ...)
        $p = '';
        $risult = array();
        $ore = array();
        $personaId = '';
        foreach ($conteggi as $c) {
            //Se cambia persona svuoto l'array
            if ($p != $c['Persona']['Cognome']) {
                if ($p != '') {
                    $risult[$p] = $ore;
                    $risult[$p]['Id'] = $personaId;
                }
                $p = $c['Persona']['Cognome'];

                $ore = array();
            }
            $ore[$c[0]['Mese']] = $c[0]['OreTot'];
            $personaId = $c['Persona']['id'];
        }
        $risult[$p] = $ore;
        $risult[$p]['Id'] = $personaId;

        $this->set('conteggi', $risult);
        $this->set('title_for_layout', "$anno | Riassunto Caricamenti | Foglio Ore");
    }

    /**
     * Ancora non testato qui
     *
     * @param [type] $idPersona
     * @param [type] $anno
     * @param [type] $mese
     * @return void
     */
    public function inviaMailDiSollecito($idPersona = null, $anno = null, $mese = null)
    {
        if (empty($idPersona) or $idPersona == NULL) {
            $this->Session->setFlash('Id Persona non valido.');
            $this->redirect(array('action' => 'check', date('Y')));
        }
        $this->autoRender = false;
        $this->loadModel('Persona');
        $conditions = array('Persona.id' => $idPersona);
        $persona = $this->Persona->find('first', array(
            'conditions' => $conditions,
            'fields' => array('Persona.id', 'Persona.DisplayName', 'Persona.EMail')
        ));
        if (empty($persona['Persona']['EMail']) || $persona['Persona']['EMail'] == NULL) {
            $this->Session->setFlash('L\'impiegato selezionato non ha un indirizzo mail settato.');
            $this->redirect(array('action' => 'check', date('Y')));
        }
        $nomeAzienda = Configure::read('iGas.NomeAzienda');
        $emailObj = new CakeEmail();
        $emailObj->viewVars(array(
            'personaDisplayName' => $persona['Persona']['DisplayName'],
            'personaId' => $persona['Persona']['id'],
            'mese' => $mese,
            'anno' => $anno
        ));
        $emailObj->template('sollecitoore');
        $emailObj->from(Configure::read('iGas.emailSender'));
        $emailObj->to($persona['Persona']['EMail']);
        $emailObj->emailFormat('text');
        $emailObj->subject("iGAS $nomeAzienda -  Non hai caricato tutte le ore di $mese/$anno");
        $emailObj->send();
        $this->Session->setFlash('Mail di sollecito inviata correttamente.');
        $this->redirect(array('action' => 'check', date('Y')));
    }

    public function check($anno)
    {
        $conditions = array('YEAR(Ora.data)' => $anno);
        $conditionsImpiegati = array('YEAR(dataValidita)' => $anno);
        $conteggi = $this->Ora->find('all', array(
            'conditions' => $conditions,
            'group' => array('Persona.Cognome', 'MONTH(Ora.data)'),
            'order' => array('Persona.Cognome', 'MONTH(Ora.data)'),
            'fields' => array('Persona.id', 'Persona.Cognome', 'Persona.Nome', 'MONTH(Ora.data) as Mese', 'SUM(Ora.numOre) as OreTot')
        ));
        $this->loadModel('Impiegato');
        $conteggiImpiegati = $this->Impiegato->find('all', array(
            //'conditions' => $conditionsImpiegati,
            'group' => array('Persona.Cognome', 'dataValidita'),
            'order' => array('Persona.Cognome', 'dataValidita'),
            'fields' => array('persona_id', 'oreLun', 'oreMar', 'oreMer', 'oreGio', 'oreVen', 'oreSab', 'oreDom', 'Persona.Cognome', 'Persona.Nome', 'dataValidita')
        ));
        $p = $pImp = '';
        $risult = $risultImpiegati = array();
        $ore = $oreDaCaricare = array('Mesi' => array(
            '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
            '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0
        ));
        //$ore = $oreDaCaricare = array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,
        //'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>0,'12'=>0);
        foreach ($conteggi as $c) {
            //Se cambia persona svuoto l'array
            if ($p != $c['Persona']['id']) {
                if ($p != '') {
                    $risult[$p] = $ore;
                }
                $p = $c['Persona']['id'];
                $ore = array(
                    'Cognome' => $c['Persona']['Cognome'],
                    'Nome' => $c['Persona']['Nome'],
                    'Mesi' => array(
                        '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
                        '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0
                    )
                );
            }

            foreach (@$ore['Mesi'] as $keyMonth => $val) {
                if ($c[0]['Mese'] == $keyMonth) {
                    $ore['Mesi'][$keyMonth] = $c[0]['OreTot'];
                }
            }
        }
        foreach ($conteggiImpiegati as $c) {
            //Se cambia persona svuoto l'array
            if ($pImp != $c['Impiegato']['persona_id']) {
                if ($pImp != '') {
                    $risultImpiegati[$pImp] = $oreDaCaricare;
                }
                $pImp = $c['Impiegato']['persona_id'];
                $oreDaCaricare = array(
                    'Cognome' => $c['Persona']['Cognome'],
                    'Nome' => $c['Persona']['Nome'],
                    'Mesi' => array(
                        '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
                        '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0
                    )
                );
            }
            foreach ($oreDaCaricare['Mesi'] as $keyMonth => $val) {
                if (date('Y', strtotime($c['Impiegato']['dataValidita'])) == $anno) {
                    //debug(date('Y-m',strtotime($c['Impiegato']['dataValidita'])));
                    //debug(date('Y-m',strtotime($anno.'-'.$keyMonth)));
                    /*
                    debug(
                        strtotime(date('Y-m',strtotime($anno.'-'.$keyMonth))) - strtotime(date('Y-m',strtotime($c['Impiegato']['dataValidita'])))
                    );
                    */
                    if (strtotime(date('Y-m', strtotime($c['Impiegato']['dataValidita']))) - strtotime(date('Y-m', strtotime($anno . '-' . $keyMonth))) <= 0) {
                        $oreDaCaricare['Mesi'][$keyMonth] = $c['Impiegato']['oreLun'] + $c['Impiegato']['oreMar'] + $c['Impiegato']['oreMer'] + $c['Impiegato']['oreGio'] + $c['Impiegato']['oreVen'] + $c['Impiegato']['oreSab'] + $c['Impiegato']['oreDom'];
                    } else {
                        if ($oreDaCaricare['Mesi'][$keyMonth] == '' || $oreDaCaricare['Mesi'][$keyMonth] == NULL) {
                            if (prev($c)) {
                                $oreDaCaricare['Mesi'][$keyMonth] = $c['Impiegato']['oreLun'] + $c['Impiegato']['oreMar'] + $c['Impiegato']['oreMer'] + $c['Impiegato']['oreGio'] + $c['Impiegato']['oreVen'] + $c['Impiegato']['oreSab'] + $c['Impiegato']['oreDom'];
                            } else {
                                $oreDaCaricare['Mesi'][$keyMonth] = 0;
                            }
                            //$oreDaCaricare['Mesi'][$keyMonth] = 'ANNOPRECEDENTE';
                        }
                    }
                } else {
                    for ($a = $anno; $a > 1990; --$a) { // Qua 1990 fa schifo ma tanto esco con break appena posso...
                        if (date('Y', strtotime($c['Impiegato']['dataValidita'])) == $a) {
                            if ($oreDaCaricare['Mesi'][$keyMonth] == '' || $oreDaCaricare['Mesi'][$keyMonth] == NULL) {
                                prev($c);
                                $oreDaCaricare['Mesi'][$keyMonth] = $c['Impiegato']['oreLun'] + $c['Impiegato']['oreMar'] + $c['Impiegato']['oreMer'] + $c['Impiegato']['oreGio'] + $c['Impiegato']['oreVen'] + $c['Impiegato']['oreSab'] + $c['Impiegato']['oreDom'];
                                next($c);
                                break;
                            }
                        }
                    }
                }
            }
        }
        $risultImpiegati[$pImp] = $oreDaCaricare;
        if (count($conteggi) > 0) {
            $risult[$p] = $ore;
            foreach ($risultImpiegati as $keyPersona => $impiegatoData) {
                if (!array_key_exists($keyPersona, $risult)) {
                    $risult[$keyPersona] = array(
                        'Cognome' => $impiegatoData['Cognome'],
                        'Nome' => $impiegatoData['Nome'],
                        'Mesi' => array(
                            '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0,
                            '7' => 0, '8' => 0, '9' => 0, '10' => 0, '11' => 0, '12' => 0
                        )
                    );
                }
            }
        } else {
            $risult = array();
        }
        //debug($risult);
        //debug($risultImpiegati);
        $this->set('conteggi', $risult);
        $this->set('conteggiImpiegati', $risultImpiegati);
        $this->set('title_for_layout', "$anno | Check Ore");
    }

    public function stampa()
    {
        if (!isset($this->request->data['Ora'])) {
            $ids = $this->Session->read('idore');
        } else {
            $ids = array_keys($this->request->data['Ora']);
        }

        $righeore = $this->Ora->find('all', array(
            'conditions' => array('Ora.id IN' => $ids),
            'order' => array('Ora.data'),
        ));
        $this->set('ore', $righeore);

        //Qui tiro su l'anagrafica dell'azienda che emette la fattura
        $this->loadModel('Persona');
        $azienda =  $this->Persona->findById(Configure::read('iGas.idAzienda'));
        $this->set('azienda', $azienda);

        //Scrivo come destinatario della nota spese il cliente della prima attività
        $cliente_id = $righeore[0]['Attivita']['cliente_id'];
        $cliente = $this->Persona->findById($cliente_id);

        $this->set('cliente', $cliente['Persona']);

        $this->Session->write('idore', $ids);
    }

    //Aggiunta delle ore manualmente (senza foglio ore)
    public function add()
    {
        $persona = $this->Auth->user('persona_id');
        $anno = date('Y');
        $mese = date('m');
        $giorno = date('d');
        $attivita = 1;

        //  if ($persona != $this->Session->read('Auth.User.persona_id') && 
        //          Auth::hasRole(Configure::read('Role.impiegato')) )
        // {
        //      $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
        //      return $this->redirect(array('action' => 'scegli_mese',$this->Session->read('Auth.User.persona_id') ));   
        // }

        if (isset($this->request->params['named']['persona'])) {
            $persona = $this->request->params['named']['persona'];
        }

        if (isset($this->request->params['named']['anno'])) {
            $anno = $this->request->params['named']['anno'];
        }
        if (isset($this->request->params['named']['mese'])) {
            $mese = $this->request->params['named']['mese'];
        }
        if (isset($this->request->params['named']['giorno'])) {
            $giorno = $this->request->params['named']['giorno'];
            //In realtà non voglio filtrare per il giorno, ma solo portarmelo dietro
        }
        if (isset($this->request->params['named']['attivita'])) {
            $attivita = $this->request->params['named']['attivita'];
        }

        if ($this->request->is('post')) {
            debug($this->request->data);die;
            $this->Ora->create();
            if ($this->Ora->save($this->request->data)) {
                $this->Session->setFlash('Ora Aggiunta correttamente.');

                //Visto che a questo punto l'ora è inserita posso inviare una mail di conferma
                //Da spostare in una sezione per permettere all'amministratore di inviare mail di sollecito
                //verso quelli che non hanno caricato ore.
                /*
				$emailObj = new CakeEmail('smtp');
				$emailObj->template('confermacaricamentoore');
				$emailObj->sender(array('postmaster@localhost' => Configure::read('iGas.NomeAzienda')));
				$emailObj->from(array('bill@microsoft.com' =>'Bill Gates'));
				$emailObj->to('test@localhost');
				$emailObj->emailFormat('text');
				$emailObj->returnPath('postmaster@localhost');
				$emailObj->replyTo(array('postmaster@localhost' => Configure::read('iGas.NomeAzienda')));
				$emailObj->subject('Foglio ore caricato');
                $emailObj->send();
                */
                $dataArray = explode('-', $this->request->data['Ora']['data']);
                //A Seconda del submit gestisco un'operazione diversa
                if (isset($this->request->data['submit-ns'])) {
                    return $this->redirect(array(
                        'controller' => 'notaspese', 'action' => 'add',
                        'persona' => $this->request->data['Ora']['eRisorsa'],
                        'attivita' => $this->request->data['Ora']['eAttivita'],
                        'anno' => $dataArray[0], // $this->request->data['Ora']['data']['year']
                        'mese' => $dataArray[1], // $this->request->data['Ora']['data']['month']
                        'giorno' => $$dataArray[2], // this->request->data['Ora']['data']['day']
                        'dest' => $this->request->data['Ora']['LuogoTrasferta'],
                    ));
                } else {
                    return $this->redirect(array(
                        'action' => 'add',
                        'persona' => $this->request->data['Ora']['eRisorsa'],
                        'anno' => $dataArray[0], // $this->request->data['Ora']['data']['year']
                        'mese' => $dataArray[1], // $this->request->data['Ora']['data']['month']
                        'giorno' => $dataArray[2], // $this->request->data['Ora']['data']['day']
                    ));
                }
            }
            $this->Session->setFlash($this->Ora->error);
            $this->Session->setFlash('Impossibile salvare questa ora.');
        }

        //Se passo la persona prendo solo le attività recenti        
        $this->set('eAttivita', $this->Ora->Attivita->getlist($persona));


        $persona_ore = $this->Ora->Persona->findById($persona);
        $nomePersona = '';
        if (!empty($persona_ore)) {
            $nomePersona = $this->Ora->Persona->findById($persona)['Persona']['DisplayName'];
        }
        $this->set('nomePersona', $nomePersona);
        $this->set('eRisorsa', $persona);
        $this->set('anno', $anno);
        $this->set('mese', $mese);
        $this->set('giorno', $giorno);

        //TODO: Davide fai la chiamata a $this->Impiegato->oreContratto($persona, $mese, $anno);
        $this->loadModel('Impiegato');
        $oreContratto = $this->Impiegato->oreContratto($persona, $mese, $anno);
        $this->set('oreContratto', $oreContratto);


        //Preparo il filtro per il riepilogo delle ore
        $conditions = array();
        //Applico il filtro alle condizioni del report ore mostrato in basso
        //(di default o passate come parametro)
        $conditions['Ora.eRisorsa'] = $persona;
        $conditions['YEAR(Ora.data)'] = $anno;
        $conditions['MONTH(Ora.data)'] = $mese;
        //Non filtro su giorno e attività perchè voglio vedere il report mensile della persona
        //$conditions['DAY(data)'] = $giorno;
        //$conditions['Ora.eAttivita'] = $attivita;

        $result = $this->Ora->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'id', 'Ora.eRisorsa', 'numOre', 'data', 'dettagliAttivita', 'luogoTrasferta', 'eAttivita', 'Faseattivita.Descrizione'
                ),
                'order' => 'data'
            )
        );

        $this->set('result', $result);
        $this->set('title_for_layout', "$anno-$mese-$giorno | $nomePersona | Aggiungi Ore | Foglio Ore");

        //$fa = $this->Ora->Faseattivita->getSimple(null,0,1);
        //$this->set('faseattivita', $fa);
    }
    public function addMobile()
    {
        $this->layout = 'nomenu-vue';
        $persona = $this->Auth->user('persona_id');

        //Se passo la persona prendo solo le attività recenti        
        $this->set('eAttivita', $this->Ora->Attivita->getlist($persona));
        $this->set('allAttivita', $this->Ora->Attivita->getlist());


        $persona_ore = $this->Ora->Persona->findById($persona);
        $nomePersona = '';
        if (!empty($persona_ore)) {
            $nomePersona = $this->Ora->Persona->findById($persona)['Persona']['DisplayName'];
        }
        $this->set('nomePersona', $nomePersona);
        $this->set('eRisorsa', $persona);



        // $result = $this->getOrebyPersona($persona);
        // $this->set('result', $result);
        $this->set('title_for_layout', date('d-m-Y')." | $nomePersona | Aggiungi Ore | Foglio Ore");
    }
    public function getOrebyPersona($personaId, $giorno = null){
        $conditions = array();
        $conditions['Ora.eRisorsa'] = $personaId;
        $conditions['YEAR(Ora.data)'] = date('Y');
        $conditions['MONTH(Ora.data)'] = date('m');
        if($giorno!=null){
            $conditions['DAY(Ora.data)'] = $giorno;
            $conditions['Ora.stop'] = null;
        }
        // debug($conditions);die;
        $result = $this->Ora->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'id', 'Ora.eRisorsa', 'numOre', 'data', 'start', 'stop', 'location_start', 'location_stop', 'dettagliAttivita', 'eAttivita', 'faseattivita_id', 'Faseattivita.Descrizione'
                ),
                'order' => 'data'
            )
        );
        $this->set('res', $result);
    }
    public function saveOra()
    {
        if (!empty($this->request->data)) {
    //    debug($this->request->data);die;
            $this->Ora->create();
            if ($this->Ora->save($this->request->data)) {

                $this->set('res', ['result' => '1', 'msg' => 'Ora Aggiunta correttamente.']);
            } else {
                //debug($this->request->data); die();
                $this->set('res', ['result' => '0', 'msg' => 'Impossibile salvare questa ora.']);
            }
        }else {
            //debug($this->request->data); die();
            $this->set('res', ['result' => '0', 'msg' => 'oggetto data non valorizzato']);
        }
    }

    //Modifica delle ore manualmente (senza foglio ore)
    public function edit($id)
    {
        $this->set('faseattivita', $this->Ora->Faseattivita->getSimple());
        if (!empty($this->request->data)) {

            //debug($this->request->data);
            if ($this->Ora->save($this->request->data)) {
                $this->Session->setFlash('Ora Modificata correttamente.');
                $dataArray = explode('-', $this->request->data['Ora']['data']);
                return $this->redirect(array(
                    'action' => 'add',
                    'persona' => $this->request->data['Ora']['eRisorsa'],
                    'anno' => $dataArray[0], // $this->request->data['Ora']['data']['year']
                    'mese' => $dataArray[1], // $this->request->data['Ora']['data']['month']
                    'giorno' => $dataArray[2], // $this->request->data['Ora']['data']['day']
                ));
            }
            $this->Session->setFlash($this->Ora->error);
            $this->Session->setFlash('Impossibile salvare questa ora.');
        }


        $this->set('eAttivita', $this->Ora->Attivita->getlist());
        $this->set('eRisorse', $this->Ora->Persona->find('list'));

        $this->request->data = $this->Ora->read(null, $id);
        $d = new DateTime($this->request->data['Ora']['data']);
        $mese = $d->format('m');
        $anno = $d->format('Y');
        $persona = $this->request->data['Ora']['eRisorsa'];

        $this->set('anno', $anno);
        $this->set('mese', $mese);
        $this->set('giorno', $d->format('d'));
        $this->set('eRisorsa', $persona);

        $fa = $this->Ora->Faseattivita->getSimple();
        $this->set('faseattivita', $fa);
        $this->set('title_for_layout', "$anno-$mese-" . $d->format('d') . " | $persona | Modifica Ore | Foglio Ore");
    }


    public function scegli_persona()
    {
        $conditions = array();

        //Se sono impiegato voglio vedere solo me stesso
        if (Auth::hasRole(Configure::read('Role.impiegato'))) {
            return $this->redirect(array('action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')));
        } else {
            $conditions['YEAR(Ora.data)'] = date('Y');
        }

        $persone = $this->Ora->find('all', array(
            'conditions' => $conditions,
            'fields' => array('DISTINCT Persona.id', 'Persona.Cognome', 'Persona.Nome')
        ));

        $this->set('eRisorsa', $this->Ora->Persona->find('list'));
        $this->set('persone', $persone);
        $this->set('title_for_layout', 'Scegli Persona | Foglio Ore ');
        if ($this->request->is('post')) {
            return $this->redirect(array('action' => 'scegli_mese', $this->request->data['Ora']['eRisorsa']));
        }
    }

    public function scegli_mese($persona = null)
    {

        if (is_null($persona)) {
            return $this->redirect(array('action' => 'add'));
        }

        if (
            $persona != $this->Session->read('Auth.User.persona_id') &&
            Auth::hasRole(Configure::read('Role.impiegato'))
        ) {
            $this->Session->setFlash('Non sei autorizzato ad accedere al foglio ore di altri');
            return $this->redirect(array('action' => 'scegli_mese', $this->Session->read('Auth.User.persona_id')));
        }

        $this->set('persona', $this->Ora->Persona->findById($persona));
        $this->set('title_for_layout', 'Scegli Mese | Foglio Ore ' . $persona);
    }

    public function delete($id, $dest = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Ore'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Ora->id = $id;
        $varToPassToModel = $this->Ora->read(['numOre', 'faseattivita_id'])['Ora'];
        if ($this->Ora->delete($id)) {
            $this->Session->setFlash(__('Ore deleted'));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('Ore was not deleted'));
        $this->redirect(array('action' => 'index'));
    }


    //Mostra un report delle ore spese per ogni attività
    public function attivita($anno = null)
    {
        $conditions = array();
        if (!empty($anno)) {
            $conditions['YEAR(Attivita.DataInizio)'] = $anno;
        }

        $r = $this->Ora->find('all', array(
            'group' => array('eAttivita'),
            'fields' => array('Attivita.name', 'eAttivita', 'SUM(Ora.numOre) as S', 'Attivita.ImportoAcquisito'),
            'conditions' => $conditions,
        ));

        $this->set('r', $r);
    }

    //Genera un report di tipo pivot per tutte le ore lavorate
    public function pivot()
    {
        //Query che riporta tutte le ore lavorate aggregate per anno, attività, persona
        $r = $this->Ora->find('all', array(
            'group' => array('YEAR(Ora.data)',  'eAttivita', 'eRisorsa', 'faseattivita_id'),
            'fields' => array('YEAR(Ora.data) as Anno', 'MONTH(Ora.data) as Mese', 'Attivita.name', 'Attivita.id', 'SUM(Ora.numOre) as Ore', 'Attivita.ImportoAcquisito', 'Persona.DisplayName', 'Faseattivita.Descrizione'),
        ));

        foreach ($r as &$row) {
            $row = Set::flatten($row);
        }

        $this->set('r', $r);
        $this->set('_serialize', array('r'));
    }

    //Considera pagate una serie di ore, e quindi le toglie dal calcolo dell'avanzamento
    public function paga($val)
    {
        $this->request->allowMethod('ajax', 'post');
        $this->autoRender = false;
        $ore = $this->request->data['Ora'];

        if ($val == 'set') {
            $val = 1;
        } else {
            $val = 0;
        }

        //Estraggo tutti gli id delle ore da aggiornare
        $ids = array_keys($ore);
        $this->log(print_r($ore, false));

        //Faccio un aggiornamento unico
        $this->Ora->updateAll(
            array('Ora.pagato' => $val),
            // conditions
            array('Ora.id' => $ids)
        );

        $this->Session->setFlash('Le ore selezionate sono considerate pagate');
    }

    public function box()
    {

        $res = array();
        $anno = date('Y');
        $mese = date('m');

        $persone = $this->Ora->find('all', array(
            'fields' => array('DISTINCT Persona.id', 'Persona.Cognome', 'Persona.Nome'),
            'joins' => array(array(
                'table' => 'notaspese',
                'alias' => 'Notaspesa',
                'type' => 'INNER'
            ))
        ));

        $ore = $this->Ora->find('all', array(
            'fields' => array('SUM(Ora.numOre) as S', 'eRisorsa', 'data'),
            'group' => 'Ora.eRisorsa',
            'conditions' => array('Ora.data >=' => "$anno-$mese-01")
        ));
        $this->loadModel('Notaspesa');

        $spese = $this->Notaspesa->find('all', array(
            'fields' => array('SUM(Notaspesa.importo) as S', 'Notaspesa.eRisorsa'),
            'group' => 'Notaspesa.eRisorsa',
            'conditions' => array('Notaspesa.data >=' => "$anno-$mese-01")
        ));

        foreach ($persone as $p) {
            $res[$p['Persona']['id']]['Nome'] = $p['Persona']['Nome'];
            $res[$p['Persona']['id']]['Cognome'] = $p['Persona']['Cognome'];
            $res[$p['Persona']['id']]['Ore'] = 0;
            $res[$p['Persona']['id']]['Spese'] = 0;
        }

        foreach ($ore as $o) {
            if (isset($res[$o['Ora']['eRisorsa']])) {
                $res[$o['Ora']['eRisorsa']]['Ore'] = round($o[0]['S'], 2);
            }
        }

        foreach ($spese as $s) {
            if (isset($res[$s['Notaspesa']['eRisorsa']])) {
                $res[$s['Notaspesa']['eRisorsa']]['Spese'] = round($s[0]['S'], 2);
            }
        }

        return $res;
    }

    public function totali()
    {

        $totale = array();
        $anno = date('Y');

        $totale['Ore'] = $this->Ora->find('all', array(
            'fields' => array('SUM(Ora.numOre) as S'),
            'conditions' => array('Ora.data >=' => "$anno-01-01")
        ));

        $this->loadModel('Notaspesa');

        $totale['Spese'] = $this->Notaspesa->find('all', array(
            'fields' => array('SUM(Notaspesa.importo) as S'),
            'conditions' => array('Notaspesa.data >=' => "$anno-01-01")
        ));

        return $totale;
    }

    //Genera il timesheet annuale per una persona filtrando sui 
    //1) progetti passati come parametro in get attivita_id
    //2) la persona passata in persona_id
    //3) la persona passata in anno
    public function ytimesheet()
    {
        $persona_id = $this->request->query('persona_id');
        $attivita_id = $this->request->query('attivita_id');
        $anno = $this->request->query('anno');

        $result = $this->Ore->find(
            'all',
            [
                'conditions' =>
                [
                    'persona_id' => $persona_id,
                    'attivita_id' => $attivita_id,
                ],
                'order' => ['data']
            ]
        );

        $this->set('result', $result);
    }
}
