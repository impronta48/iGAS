<?php

class PersoneController extends AppController
{

  public $name = 'Persone';
  public $components = ['RequestHandler', 'Paginator', 'UploadFiles','PhpExcel.PhpSpreadsheet']; 
  public $helpers = ['PhpExcel.PhpSpreadsheet'];

  function index()
  {

    $this->Persona->recursive = 1;
    $conditions = [];

    //Read querystring
    $q = $this->request->query('q');
    $paging = $this->request->query('paging');
    $cat = $this->request->query('cat');

    //Value querystring
    if (empty($paging)) {
      $paging = 50;
    }

    if (!empty($q)) {
      $conditions[] = ['OR' => [
        'Persona.nome LIKE' => "%$q%",
        'Persona.cognome LIKE' => "%$q%",
        'Persona.DisplayName LIKE' => "%$q%",
        'Persona.Societa LIKE' => "%$q%",
      ]];
    }

    if ($this->request->ext == 'xls') {
      $this->set('persone', $this->Persona->find('all', [
        'conditions' => $conditions,
        'contains' => ['Persona'],
        'recursive' => -1,
      ]));
      $this->set('name', Configure::read('iGas.NomeAzienda') . "Contatti.xls");
      return;
    } elseif (!empty($cat)) {
      $this->Paginator->settings['Tagged'] = [
        'tagged',
        'model' => 'Persona',
        'by' => $cat,
        'conditions' => $conditions,
        'contain' => ['Persona', 'Tag'],
        'limit' => $paging,
      ];
      $this->set('persone', $this->Paginator->paginate('Tagged'));
    } else {
      $this->Paginator->settings = [
        'conditions' => $conditions,
        'contain' => ['Tag'],
        'order' => ['modified' => 'DESC', 'DisplayName'],
        'limit' => $paging,
      ];
      $this->set('persone', $this->Paginator->paginate());
    }


    //Se hai premuto sul pulsante esporta email ti mando ad una pagina che presenta solo le mail
    if (isset($this->request->data['export-email'])) {
      $this->export_email($this->request->data['Persona']);
      return;
    }

    //Leggo tutti i tag e li porto alla view
    $fields = ['name'];
    $t = $this->Persona->Tag->find('all', ['fields' => $fields, 'recursive' => -1]);
    $taglist = [];
    foreach ($t as $t1) {
      //the value of the select should be the same of the name
      $taglist[$t1['Tag']['name']] = $t1['Tag']['name'];
    }
    natcasesort($taglist);
    $this->set('taglist', $taglist);
  }

  function setAvatarToDisplay($persona)
  {
    $pathWithoutExt = 'profiles' . DS . @$persona['id'] . '.';
    foreach (Configure::read('iGas.commonFiles') as $ext => $mimes) {
      if (!file_exists(IMAGES . $pathWithoutExt . $ext)) {
        if (@$persona['Sex'] == 'M') {
          $path = 'profiles' . DS . 'default-man.png';
        } elseif (@$persona['Sex'] == 'F') {
          $path = 'profiles' . DS . 'default-lady.png';
        } else {
          $path = 'profiles' . DS . 'default.png';
        }
      } else {
        $path = $pathWithoutExt . $ext;
        break;
      }
    }
    return $path;
  }

  function view($id = null)
  {
    if ($id) {
      $persona = $this->Persona->read(null, $id);
      if ($persona) {
        $this->set('persona', $persona['Persona']);
        $this->set('profilePath', $this->setAvatarToDisplay($persona['Persona']));
      } else {
        $this->redirect(['action' => 'index']);
      }
    } else {
      $this->redirect(['action' => 'index']);
    }
  }

  function edit($id = null)
  {
    if (($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2) or ($this->Session->read('Auth.User.persona_id') == $id)) {
      // Si può continuare, altrimenti vieni reindirizzato, questo è brutto lo so ma è la tecnica che attualmente
      // assicura al 100% la profilazione in questo punto
    } else {
      $this->redirect(['action' => 'index']);
    }

    if (!$id && !empty($this->request->data)) {
      $this->Persona->create();
    }

    if (!empty($this->request->data)) {
      if ($this->Persona->save($this->request->data)) {
        $this->Session->setFlash(__('The persona has been saved'));
        if (!$id) {
          //Prendo l'id legato al salvataggio
          $id = $this->Persona->getLastInsertID();
        }
        // Qua gestisco l'upload dell'avatar
        $uploaded_file = $this->request->data['Persona']['uploadFile'];
        $uploadError = $this->UploadFiles->upload($id, $uploaded_file, $this->request->controller, null, true);
        if (strlen($uploadError) > 0) {
          $this->Flash->error(__($uploadError));
        }
        //Per settare on the fly alcune cose gender friendly di default come l'avatar se non specificato
        if ($this->Session->read('Auth.User.persona_id') == $id) {
          $this->Session->write('Auth.User.Persona.Sex', $this->request->data['Persona']['Sex']);
        }
        $this->redirect(['action' => 'index']);
      } else {
        $this->Session->setFlash(__('The persona could not be saved. Please, try again.'));
      }
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->Persona->read(null, $id);
      if ($this->request->data) {
        $this->set('profilePath', $this->setAvatarToDisplay($this->request->data['Persona']));
      } else if (!$id) {
        $this->set('profilePath', null);
      } else {
        $this->redirect(['action' => 'index']);
      }
      //Leggo tutti i tag e li porto alla view
      $fields = ['name'];
      $t = $this->Persona->Tag->find('all', ['fields' => $fields, 'recursive' => -1]);
      $taglist = [];
      foreach ($t as $t1) {
        $taglist[] = $t1['Tag']['name'];
      }
      $this->set('taglist', $taglist);
    }
  }

  function delete($id = null)
  {
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for persona'));
      $this->redirect(['action' => 'index']);
    }
    if ($this->Persona->delete($id)) {
      $this->Session->setFlash(__('Persona deleted'));
      $this->deleteDoc($id, false);
      $this->redirect(['action' => 'index']);
    }
    $this->Session->setFlash(__('Persona was not deleted'));
    $this->redirect(['action' => 'index']);
  }

  function autocomplete()
  {
    $data = [];
    if (isset($this->request->query['term'])) {
      $data = $this->Persona->find('all', [
        'conditions' => [
          'Persona.DisplayName LIKE' => '%' . $this->request->query['term'] . '%'
        ],
        'limit' => 50,
        'fields' => ['id', 'DisplayName', 'Impiegato.costoAziendale', 'Impiegato.venduto'],
      ]);
    }

    $res = [];

    foreach ($data as $d) {
      $a = new StdClass();
      $a->id = $d['Persona']['id'];
      //$a->label = $d['Libro']['titolo'];
      $a->value = $d['Persona']['DisplayName'];
      $a->costoU = $d['Impiegato']['costoAziendale'];
      $a->vendutoU = $d['Impiegato']['venduto'];
      $res[] = $a;
    }
    $this->layout = 'ajax';
    $this->autoLayout = false;
    $this->autoRender = false;

    $this->header('Content-Type: application/json');
    echo json_encode($res);
    exit();
  }

  function suggest()
  {
    $data = [];
    if (isset($this->request->query['q'])) {
      $this->Persona->recursive = 1;
      $data = $this->Persona->find('all', [
        'conditions' => [
          'Persona.DisplayName LIKE' => '%' . $this->request->query['q'] . '%',
          //'Impiegato.TipoImpiegato > ' => 0,
        ],
        'limit' => 50,
        'fields' => ['id', 'DisplayName'],
      ]);
    }

    $res = [];

    foreach ($data as $d) {
      $a = new StdClass();
      $a->value = $d['Persona']['id'];
      $a->name = $d['Persona']['DisplayName'];
      $res[] = $a;
    }
    $this->layout = 'js';
    $this->autoLayout = false;
    $this->autoRender = false;

    //$this->header('Content-Type: application/json');
    echo json_encode($res);
    exit();
  }

  public function consulente($anno, $mese, $personaId = NULL)
  {    
    $proj_speciali = Configure::read('iGas.progettiSpeciali');
    $tabore = $this->_getOreconsulente($anno, $mese, $personaId);

    $this->set('ore', $tabore);
    $this->set('mese', $mese);
    $this->set('anno', $anno);
    $this->set('proj_speciali', $proj_speciali);
    $this->set('title_for_layout', "Foglio Ore per Consulente del Lavoro | Persone");
    $this->set('days', cal_days_in_month(CAL_GREGORIAN, $mese, $anno));
    Configure::write('debug', 0);
    $this->set('name', Configure::read('iGas.NomeAzienda') . "Report-ore-$anno-$mese");
  }

  //Aggiunge un tag a tutti gli elementi passati in post
  function addtag($tag)
  {
    $this->request->allowMethod('ajax', 'post');
    $this->autoRender = false;
    //$this->log($this->request->data);
    $persone = $this->request->data['Persona'];

    foreach ($persone as $key => $value) {
      //Associa il tag passato come parametro a tutte le persone passate in post,
      //paremetro false finale= aggiungo i tag invece di sostituire
      $this->Persona->saveTags($tag, $key, false);
    }
  }

  //Rimuove tutti i tag a tutti gli elementi passati in post
  function deletetag()
  {
    $this->request->allowMethod('ajax', 'post');
    $this->autoRender = false;
    $persone = $this->request->data['Persona'];

    foreach ($persone as $key => $value) {
      //Tolgo tutti i tag dalle persone
      $this->Persona->id = $key;
      $this->Persona->deleteTagged();
    }
  }

  public function subscribe($listId = null)
  {


    $this->request->allowMethod('ajax', 'post');
    $this->autoRender = false;
    $persone = $this->request->data['Persona'];
    //TODO: Gestire correttamente il nome della lista passato come paraemtro
    //Oppure accettare che il nome del parametro sia il segmento
    $listId = Configure::read('iGas.ListID');
    //$this->log($listId);
    try {
      $this->mc = new Mailchimp(Configure::read('iGas.MailchimpApi')); //your api key here
    } catch (Mailchimp_Error $e) {
      $this->Session->setFlash('You have not set a MailChimp API key. Set it in Config/igas.php', 'flash_error');
    }

    foreach ($persone as $key => $value) {
      $this->Persona->recursive = -1;
      $p = $this->Persona->findById($key);
      $id = $p['Persona']['id'];
      $email = $p['Persona']['EMail'];
      //$this->log($p);
      try {
        $this->mc->lists->subscribe($listId, ['email' => $email]);
        $this->Session->setFlash("L'utente $email è stato iscritto alla lista $listId, deve confermare il proprio indirizzo!", 'flash_success');
        $this->log("User $email subscribed successfully!", 'success');
      } catch (Mailchimp_Error $e) {
        if ($e->getMessage()) {
          $this->Session->setFlash($e->getMessage(), 'flash_error');
        } else {
          $this->Session->setFlash('An unknown error occurred', 'flash_error');
        }
      }
    }

    //TODO: Chiedere se voglio creare un segmento per questa spedizione
    //https://apidocs.mailchimp.com/api/2.0/lists/static-segment-members-add.php
    //In ogni caso aggiungo
  }

  public function report($anno, $mese, $idPersona = NULL)
  {

    $this->Persona->recursive = -1;
    $this->loadModel('Attivita');
    $this->Attivita->recursive = -1;

    // Filippo 20/04/16 - Ho impostato il numero corretto di giorni per ogni mese
    $days = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);

    $tabore = $this->_getOre($days, $anno, $mese, $idPersona);

    $special = $this->Attivita->getProgettiSpeciali();

    $this->set('giorni', $days);
    $this->set('ore', $tabore);
    $this->set('mese', $mese);
    $this->set('anno', $anno);
    $this->set('special', $special);
    $this->set('title_for_layout', "Report Ore-Attivit&agrave; | Persone");

    // Nome del file per il layout PDF
    $this->set('name', Configure::read('iGas.NomeAzienda') . "Report-ore-$anno-$mese");
  }

  public function report_fasi($anno, $mese, $idPersona = NULL)
  {

    $this->Persona->recursive = -1;


    // Filippo 20/04/16 - Ho impostato il numero corretto di giorni per ogni mese
    $days = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);

    $tabore = $this->_getOreFasi($days, $anno, $mese, $idPersona);

    $this->set('giorni', $days);
    $this->set('ore', $tabore);
    $this->set('mese', $mese);
    $this->set('anno', $anno);
    $this->set('title_for_layout', "Report Ore-Fasi | Persone");

    // Nome del file per il layout PDF
    if ($this->response->type() == 'application/pdf') {
      $this->layout = 'landscape';
    }
    $this->set('name', Configure::read('iGas.NomeAzienda') . "Report-fasi-$anno-$mese");
  }

  private function _getOreconsulente($anno, $mese, $personaId = NULL)
  {
    $persone_list = $this->Persona->Impiegato->attivo();
    $proj_speciali = Configure::read('iGas.progettiSpeciali');

    $this->loadModel('Attivita');
    $this->Attivita->recursive = -1;
    $proj_speciali_id = $this->Attivita->getProgettiSpeciali();  //Deduco gli id dal nome del progetto

    if ($personaId) {
      $ore = $this->Persona->Impiegato->query("SELECT Persona.id, DisplayName, Ora.data, numOre, eAttivita
                                        FROM ore as Ora, persone as Persona
                                        right join impiegati as Impiegato on Persona.id = Impiegato.persona_id
                                        WHERE Persona.id = $personaId AND Ora.eRisorsa = $personaId AND MONTH(Ora.data) = $mese AND YEAR (Ora.data)=$anno
                                        AND Impiegato.disattivo = 0                                        
                                        and Impiegato.id =(
                                             select id from impiegati where persona_id = Persona.id limit 1
                                          )
                                        ORDER BY DisplayName, data
                                        ");
    } else {
      //Massimoi 6/9/13 - Non c'è speranza di usare il costruttore di query di cake per una query così!
      $ore = $this->Persona->Impiegato->query("SELECT Persona.id, DisplayName, Ora.data, numOre, eAttivita
                                        FROM ore as Ora, persone as Persona
                                        right join impiegati as Impiegato on Persona.id = Impiegato.persona_id
                                        WHERE Ora.eRisorsa = Persona.id AND MONTH(Ora.data) = $mese AND YEAR (Ora.data)=$anno
                                        AND Impiegato.disattivo = 0
                                        and Impiegato.id =(
                                             select id from impiegati where persona_id = Persona.id limit 1
                                          )    
                                        ORDER BY DisplayName, data
                                        ");
    }

    //riordino l'array in modo che sia facile da stampare
    //-----------   | Persona                             | Persona                             | Persona
    //1             | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia |
    //2             | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia |
    //3             | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia |
    //4             | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia |
    //5             | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia |
    //...
    //31             | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia | Progetti, Ferie, Permessi, Malattia |
    $tabore = [];

    //Inizializzo
    foreach ($persone_list as $p) {
      foreach ($ore as $key => $value) {
        if ($p['Persona']['id'] == $value['Persona']['id']) {
          foreach ($proj_speciali as $s) {
            $tabore[$p['Persona']['DisplayName']][$s] =  array_fill(1, 31, 0);
          }
          //Voci del foglio ore che compaiono sempre
          $tabore[$p['Persona']['DisplayName']]['Progetto'] =  array_fill(1, 31, 0);
          $tabore[$p['Persona']['DisplayName']]['Totale'] =  array_fill(1, 31, 0);
          $tabore[$p['Persona']['DisplayName']]['Eccesso'] =  array_fill(1, 31, 0);
          $tabore[$p['Persona']['DisplayName']]['Contratto'] =  $this->_getContratto($p['Persona']['id'], $anno, $mese);
        }
      }
    }

    //Carico le ore
    foreach ($ore as $o) {
      $d = new DateTime($o['Ora']['data']);
      $day = intval($d->format('d'));
      $attivita_id = $o['Ora']['eAttivita'];

      //Se l'attività appartiene ai progetti speciali la carico lì, altrimenti semplicemente come "Progetto"
      if (array_key_exists($attivita_id, $proj_speciali_id)) {
        $tabore[$o['Persona']['DisplayName']][$proj_speciali_id[$attivita_id]][$day] = $o['Ora']['numOre'];
      } else {
        if (!is_numeric($tabore[$o['Persona']['DisplayName']]['Progetto'][$day])) {
          $tabore[$o['Persona']['DisplayName']]['Progetto'][$day] = 0;
        } else {
          $tabore[$o['Persona']['DisplayName']]['Progetto'][$day] += $o['Ora']['numOre'];
        }
      }
    }

    //Calcolo i totali alla fine per ottimizzare ed essere sicuro di fare il conto
    //Tutti i giorni, anche in quelli che non contengono ore
    foreach ($persone_list as $o) {
      foreach ($ore as $key => $value) {
        if ($o['Persona']['id'] == $value['Persona']['id']) {
          for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $mese, $anno); $day++) {
            $sommaPrjSpeciali = 0;
            foreach ($proj_speciali as $s) {
              $sommaPrjSpeciali += $tabore[$o['Persona']['DisplayName']][$s][$day];
            }
            //Calcolo l'effettivo tempo impiegato tra progetti normali e speciali
            $tabore[$o['Persona']['DisplayName']]['Totale'][$day] =
              $tabore[$o['Persona']['DisplayName']]['Progetto'][$day] +
              $sommaPrjSpeciali;
            //Calcolo il Eccesso tra contratto e lavoro
            $tabore[$o['Persona']['DisplayName']]['Eccesso'][$day] =
              $tabore[$o['Persona']['DisplayName']]['Progetto'][$day] +
              $sommaPrjSpeciali -
              $tabore[$o['Persona']['DisplayName']]['Contratto'][$day];
          }
        }
      }
    }
    return $tabore;
  }

  //Carico i valori da contratto per il mese come parametro
  private function _getContratto($pid, $anno, $mese)
  {
    $giorniIta = ['1' => 'Lun', '2' => 'Mar', '3' => 'Mer', '4' => 'Gio', '5' => 'Ven', '6' => 'Sab', '7' => 'Dom'];
    $days = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
    $sett = $this->Persona->Impiegato->find('first', [
      'conditions' => [
        'persona_id' => $pid,
        'dataValidita <=' => "$anno-$mese-01"
      ],
      'order' => 'dataValidita DESC'
    ]);
    $result = [];

    for ($d = 1; $d <= $days; $d++) {
      $n = date('N', strtotime("$anno-$mese-$d"));
      $result[$d] = 0;
      if (isset($sett['Impiegato']['ore' . $giorniIta[$n]])) {
        $result[$d] = (float) $sett['Impiegato']['ore' . $giorniIta[$n]];
      }
    }
    return $result;
  }

  private function _getOre($days, $anno, $mese, $personaId = NULL)
  {

    $persone_list = $this->Persona->Impiegato->attivo();
    $this->loadModel('Attivita');
    $this->Attivita->recursive = -1;
    $special = $this->Attivita->getProgettiSpeciali();  //Deduco gli id dal nome del progetto

    if ($personaId) {
      $ore = $this->Persona->query("SELECT Persona.id, DisplayName, Ora.data, Ora.numOre, eAttivita, Attivita.name
                                        FROM (ore as Ora LEFT JOIN persone as Persona on Ora.eRisorsa = Persona.id)
                                        right join impiegati as Impiegato on Persona.id = Impiegato.persona_id
                                        LEFT JOIN attivita as Attivita on  Attivita.id = Ora.eAttivita
                                        WHERE Persona.id = $personaId AND MONTH(Ora.data) = $mese AND YEAR (Ora.data)=$anno
                                        AND Impiegato.disattivo = 0
                                        and Impiegato.id =(
                                             select id from impiegati where persona_id = Persona.id limit 1
                                          )
                                        ORDER BY Cognome, Attivita.name, data");
    } else {
      //Massimoi 6/9/13 - Non c'è speranza di usare il costruttore di query di cake per una query così!
      // VECCHIA QUERY FUNZIONANTE MA CHE TIRA FUORI LE ORE DI TUTTE LE PERSONE
      $ore = $this->Persona->query("SELECT Persona.id, DisplayName, Ora.data, Ora.numOre, eAttivita, Attivita.name
                                        FROM (ore as Ora LEFT JOIN persone as Persona on Ora.eRisorsa = Persona.id)
                                        right join impiegati as Impiegato on Persona.id = Impiegato.persona_id
                                        LEFT JOIN attivita as Attivita on  Attivita.id = Ora.eAttivita
                                        WHERE Ora.eRisorsa = Persona.id AND MONTH(Ora.data) = $mese AND YEAR (Ora.data)=$anno
                                        AND Impiegato.disattivo = 0
                                        and Impiegato.id =(
                                             select id from impiegati where persona_id = Persona.id limit 1
                                          )
                                        ORDER BY Cognome, Attivita.name, data");
    }

    $tabore = [];

    foreach ($ore as $riga) {

      if (!array_key_exists($riga['Ora']['eAttivita'], $special)) {
        $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['ore'] = array_fill(1, $days, 0);
        $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['nome'] = $riga['Attivita']['name'];
      }
    }

    //aggiungo i valori speciali successivamente
    foreach ($persone_list as $p) {
      foreach ($ore as $key => $value) {
        if ($p['Persona']['id'] == $value['Persona']['id']) {
          foreach ($special as $key => $value) {
            $tabore[$p['Persona']['DisplayName']][$key]['ore'] = array_fill(1, $days, 0);
            $tabore[$p['Persona']['DisplayName']][$key]['nome'] = $value;
          }
        }
      }
    }
    //debug($tabore);
    //Carico le ore
    foreach ($ore as $o) {

      $d = new DateTime($o['Ora']['data']);
      $day = intval($d->format('d'));

      $tabore[$o['Persona']['DisplayName']][$o['Ora']['eAttivita']]['ore'][$day] += $o['Ora']['numOre'];
    }

    return $tabore;
  }

  private function _getOreFasi($days, $anno, $mese, $personaId = NULL)
  {

    $persone_list = $this->Persona->Impiegato->attivo();
    //Devo correggere le ore e trasformare tutte le faseattivita_id == 0 in null
    $this->Persona->query("UPDATE ore set faseattivita_id=0 where faseattivita_id is NULL");

    if ($personaId) {
      $ore = $this->Persona->query("SELECT Persona.id, DisplayName, Ora.data, Ora.numOre, eAttivita, faseattivita_id, Attivita.name, Faseattivita.Descrizione
                                        FROM impiegati as Impiegato
                                            LEFT JOIN  persone as Persona  on Persona.id = Impiegato.persona_id
                                            LEFT JOIN ore as Ora on Ora.eRisorsa = Persona.id
                                            LEFT JOIN attivita as Attivita on  Attivita.id = Ora.eAttivita
                                            LEFT JOIN faseattivita as Faseattivita on Ora.faseattivita_id = Faseattivita.id
                                        WHERE Persona.id = $personaId AND MONTH(Ora.data) = $mese AND YEAR (Ora.data)=$anno
                                        AND Impiegato.disattivo = 0
                                        and Impiegato.id =(
                                             select id from impiegati where persona_id = Persona.id limit 1
                                          )
                                        ORDER BY Cognome, data, Attivita.name
                                        ");
    } else {
      // VECCHIA QUERY FUNZIONANTE MA CHE TIRA FUORI LE ORE DI TUTTE LE PERSONE
      //Massimoi 6/9/13 - Non c'è speranza di usare il costruttore di query di cake per una query così!
      $ore = $this->Persona->query("SELECT Persona.id, DisplayName, Ora.data, Ora.numOre, eAttivita, faseattivita_id, Attivita.name, Faseattivita.Descrizione
                                    FROM impiegati as Impiegato
                                        LEFT JOIN  persone as Persona  on Persona.id = Impiegato.persona_id
                                        LEFT JOIN ore as Ora on Ora.eRisorsa = Persona.id
                                        LEFT JOIN attivita as Attivita on  Attivita.id = Ora.eAttivita
                                        LEFT JOIN faseattivita as Faseattivita on Ora.faseattivita_id = Faseattivita.id
                                    WHERE MONTH(Ora.data) = $mese AND YEAR (Ora.data)=$anno
                                    AND Impiegato.disattivo = 0
                                    and Impiegato.id =(
                                             select id from impiegati where persona_id = Persona.id limit 1
                                          )
                                    ORDER BY Cognome, data, Attivita.name
                                    ");
    }

    //Creo una tabella con disposizione inversa rispetto a quella di consulente/report
    $tabore = [];

    // Filippo 20/04/16 - Ho creato questo loop per 'pulire' l'estrazione dei dati e utilizzare una sola query SQL
    foreach ($ore as $riga) {

      $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['fase'][$riga['Ora']['faseattivita_id']]['ore'] = array_fill(1, $days, 0);
      $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['fase'][$riga['Ora']['faseattivita_id']]['somma'] = 0;
      $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['nome'] = $riga['Attivita']['name'];
      $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['somma'] = 0;


      if (empty($riga['Ora']['faseattivita_id']))
        $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['fase'][$riga['Ora']['faseattivita_id']]['nome'] = 'Non definita';
      else
        $tabore[$riga['Persona']['DisplayName']][$riga['Ora']['eAttivita']]['fase'][$riga['Ora']['faseattivita_id']]['nome'] =
          ' -' . $riga['Faseattivita']['Descrizione'];
    }

    //carico le ore
    foreach ($ore as $o) {

      $d = new DateTime($o['Ora']['data']);
      $day = intval($d->format('d'));

      $tabore[$o['Persona']['DisplayName']][$o['Ora']['eAttivita']]['fase'][$o['Ora']['faseattivita_id']]['ore'][$day] += $o['Ora']['numOre'];
      $tabore[$o['Persona']['DisplayName']][$o['Ora']['eAttivita']]['fase'][$o['Ora']['faseattivita_id']]['somma'] += $o['Ora']['numOre'];
      $tabore[$o['Persona']['DisplayName']][$o['Ora']['eAttivita']]['somma'] += $o['Ora']['numOre'];
    }
    //debug($tabore);
    return $tabore;
  }

  function export_email($persone)
  {
    $in = [];
    foreach ($persone as $key => $value) {
      $in[] = $key;
    }
    $this->Persona->recursive = -1;
    $persone = $this->Persona->find('all', [
      'conditions' => ['id' => $in],
      'fields' => 'email',
    ]);

    $this->set('persone', $persone);
    $this->render('export_email');
  }

  public function ultimemodifiche()
  {

    $lastmodified = [];

    $res = $this->Persona->find('all', [
      'fields' => ['Persona.DisplayName', 'Persona.modified'],
      'limit' => '10',
      'order' => ['Persona.modified' => 'desc']
    ]);

    foreach ($res as $r) {

      $lastmodified[$r['Persona']['id']]['Nome'] = $r['Persona']['DisplayName'];
      $lastmodified[$r['Persona']['id']]['Modifica'] = $r['Persona']['modified'];
    }

    return $lastmodified;
  }

  /**
   * deleteDoc
   *
   * Prende l'id di una persona e ne cancella l'avatar, alla fine redirige sempre alla pagina
   * chiamante settando un messaggio che informa dell'esito della cancellazione.
   * E' estremamente simile a tutti gli altri metodi deleteDoc sparsi in iGAS, sarebbe da mettere
   * nel component UploadFiles.
   *
   * @param int $id
   * @param boolean $redirect true per redirigere alla pagine chiamate, false per non redirigere (utile
   * nel caso in cui deleteDoc sia chiamato da qualche metodo che già redirige), default true.
   * @return void
   */
  public function deleteDoc($id = null, $redirect = true)
  {
    $this->autoRender = false;
    if (($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2) or ($this->Session->read('Auth.User.persona_id') == $id)) {
      // Si può continuare, altrimenti vieni reindirizzato, questo è brutto lo so ma è la tecnica che attualmente
      // assicura al 100% la profilazione in questo punto
    } else {
      $this->Session->setFlash(__('Non è stato possibile cancellare immagine profilo'));
      $this->redirect(['action' => 'index']);
    }
    $fileExt = $this->UploadFiles->checkIfFileExists(WWW_ROOT . 'img' . DS . 'profiles' . DS . $id . '.');
    if (unlink(WWW_ROOT . 'img' . DS . 'profiles' . DS . $id . '.' . $fileExt)) {
      $this->Session->setFlash(__('Immagine profilo cancellata'));
    } else {
      $this->Session->setFlash(__('Non è stato possibile cancellare immagine profilo'));
    }
    if ($redirect) {
      if ($this->referer()) {
        $this->redirect($this->referer());
      } else {
        $this->redirect(['controller' => 'persone', 'action' => 'index']);
      }
    }
  }

  //TODO: impostata ma non funziona correggere!
  public function deleteMulti()
  {
    //Se hai premuto sul pulsante delete-contacts, cancello tutto
    if (isset($this->request->data['delete-contacts'])) {
      debug($this->request->data['Persona']['id']);
      //$this->deleteAll(array(), false);
    }
  }
}
