<?php

class CespitiController extends AppController {

    //public $name = 'Cespiti';
    public $helpers = array('Html');
    public $components = array('Paginator');

    public function index(){
        $this->Cespite->recursive = 0;
        $conditions = array();
        //$paging = $this->request->query('paging');
        //Value querystring ancora da implementare
        /*
        if(empty($paging)){
            $paging = 4;
        }
        */
        $this->set('cespiti', $this->Cespite->find('all', array(
            'conditions' => $conditions,
            'contains' => array('Cespite'),
            'recursive' => -1,
        )));
        $this->set('cespiti', $this->Paginator->paginate());
    }

    public function add(){
        if(!empty($this->request->data)){
            $this->Cespite->create();
            if ($this->Cespite->save($this->request->data)) {
                $this->Session->setFlash(__('Asset has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                debug($this->request->data);
                $this->Session->setFlash(__('Asset could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null){
        if(!$id or !is_numeric($id)){
            $this->Session->setFlash(__('Invalid asset id'));
            $this->redirect(array('action' => 'index'));
        } else {
            if($this->request->is('post') || $this->request->is('put')){  
                if($this->Cespite->Save($this->request->data)){
                    $this->Session->setFlash('Asset aggiornato');
                } else {
                    $this->Session->setFlash('Problemi ad aggiornare asset, riprova');
                }
                $this->redirect(array('action' => 'index'));
            } else {
                $this->request->data = $this->Cespite->findById($id);
                //$this->request->data = $this->Cespite->read(null, $id);
            }
        }
    }

    public function delete($id = null){
        $this->loadModel('Cespitecalendario');
        if(!$id){
            $this->Session->setFlash(__('Invalid asset id'));
            $this->redirect(array('action' => 'index'));
        }
        $conditions = array('Cespitecalendario.cespite_id'=>$id);
        $calendar = $this->Cespitecalendario->find('all', array(
            'conditions' => $conditions,
            'contains' => array('Cespitecalendario'),
            'recursive' => -1,
            'contain' => array('Cespite.displayName','Cespite.id',
                            'Persona.displayName','Persona.id',
                            'LegendaTipoAttivitaCalendario.color','LegendaTipoAttivitaCalendario.textColor','LegendaTipoAttivitaCalendario.id'),
        ));
        if(count($calendar)===0){
            if($this->Cespite->delete($id)){
                $this->Session->setFlash(__('Asset deleted'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Session->setFlash(__('Asset was not deleted because there are '.count($calendar).' events related to this Asset'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Asset was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function calendar() {
        // To Do
        $this->loadModel('Cespitecalendario');
        $legenda_tipo_attivita_calendario = $this->Cespitecalendario->LegendaTipoAttivitaCalendario->find('list');
		$this->set(compact('legenda_tipo_attivita_calendario'));
    }

    public function events() {
        $this->loadModel('Cespitecalendario');
        $this->Cespitecalendario->recursive = 1;
        $conditions = array();
        $calendar=$this->Cespitecalendario->find('all', array(
            'conditions' => $conditions,
            'contains' => array('Cespitecalendario'),
            'recursive' => -1,
            'contain' => array('Cespite.displayName','Cespite.id',
                            'Persona.displayName','Persona.id',
                            'LegendaTipoAttivitaCalendario.color','LegendaTipoAttivitaCalendario.textColor','LegendaTipoAttivitaCalendario.id'),
        ));
        foreach($calendar as $key => $value){
            $sep = ' - ';
            $note = '';
            if(!empty($value['Cespitecalendario']['note'])){
                $note = $sep.$value['Cespitecalendario']['note'];
            }
            //$value['Cespitecalendario']['start'] = 'Sat Mar 3 2019 16:00:00 GMT+0100';
            $eventUser = ($value['Persona']['displayName'] !== NULL) ? $value['Persona']['displayName'] : $value['Cespitecalendario']['utilizzatore_esterno'];
            $value['Cespitecalendario']['durationEditable'] = true;
            $value['Cespitecalendario']['allDay'] = false;
            if($value['Cespitecalendario']['repeated']==1){
                //$value['Cespitecalendario']['startRecur'] = explode(' ',$value['Cespitecalendario']['start'])[0];
                //$value['Cespitecalendario']['endRecur'] = explode(' ',$value['Cespitecalendario']['end'])[0];
                //$value['Cespitecalendario']['startTime'] = explode(' ',$value['Cespitecalendario']['start'])[1];
                //$value['Cespitecalendario']['endTime'] = explode(' ',$value['Cespitecalendario']['end'])[1];
                //$value['Cespitecalendario']['allDay'] = true;
                //$value['Cespitecalendario']['daysOfWeek'] = [0,1,2,3,4,5,6];//TEST
                //unset($value['Cespitecalendario']['start']);
                //unset($value['Cespitecalendario']['end']);
            }
            $value['Cespitecalendario']['color'] = $value['LegendaTipoAttivitaCalendario']['color'];
            $value['Cespitecalendario']['textColor'] = $value['LegendaTipoAttivitaCalendario']['textColor'];//Non funziona, forse la versione di jquery full calendar è troppo vecchia o conflitti con altre cose?
            //$value['Cespitecalendario']['className'] = 'bg-warning';// Funzionano molte classi tranne quelle per il testo...
            //$value['Cespitecalendario']['url'] = 'https://www.example.com/';//Funziona Magari implementare in futuro
            $value['Cespitecalendario']['title'] = $value['Cespite']['displayName'].$sep.$eventUser.$note;
            //unset($value['Cespitecalendario']['user_id']);
            //unset($value['Cespitecalendario']['cespite_id']);
            //unset($value['Cespitecalendario']['event_type_id']);
            $arrForJson[]=$value['Cespitecalendario'];
            //debug($value['Cespitecalendario']['start']);

        }
        //debug($arrForJson);
        $this->set('events',$arrForJson);
    }

    function eventlist($groupId = null) {
        $this->loadModel('Cespitecalendario');
        $this->Cespitecalendario->recursive = 0;
        /*
        $paging = $this->request->query('paging');
        //Value querystring ancora da implementare
        if(empty($paging)){
            $paging = 4;
        }
        */
        if(!$groupId){
            $conditions = array();
            $this->set('events', $this->Cespitecalendario->find('all', array(
                'conditions' => $conditions,
                'contains' => array('Cespitecalendario'),
                'recursive' => -1,
                'contain' => array('Cespite.displayName','Cespite.id','Persona.displayName','Persona.id','LegendaTipoAttivitaCalendario.color','LegendaTipoAttivitaCalendario.textColor','LegendaTipoAttivitaCalendario.id'),
            )));
        } else {
            $conditions = array('Cespitecalendario.eventGroup' => $groupId);
            $this->set('events', $this->Cespitecalendario->find('all', array(
                'conditions' => $conditions,
                'contains' => array('Cespitecalendario'),
                'recursive' => -1,
                'contain' => array('Cespite.displayName','Cespite.id','Persona.displayName','Persona.id','LegendaTipoAttivitaCalendario.color','LegendaTipoAttivitaCalendario.textColor','LegendaTipoAttivitaCalendario.id'),
            )));
        }
        //$this->set('events', $this->Paginator->paginate());
    }

    public function _checkEventDate($edit = false){
        //debug($this->request->data);
        if($edit){
            $conditions = array('AND' => array(
                                        'Cespitecalendario.cespite_id'=>$this->request->data['Cespitecalendario']['cespite_id'],
                                        'NOT' => array('Cespitecalendario.id'=>$this->request->data['Cespitecalendario']['id'])
                                        )
                            );
        } else {
            $conditions = array('Cespitecalendario.cespite_id'=>$this->request->data['Cespitecalendario']['cespite_id']);
        }
        $relatedEvents = $this->Cespitecalendario->find('all', array(
            'conditions' => $conditions,
            'contains' => array('Cespitecalendario'),
            'recursive' => -1,
            'contain' => array('Cespite.displayName','Cespite.id',
                            'Persona.displayName','Persona.id',
                            'LegendaTipoAttivitaCalendario.color','LegendaTipoAttivitaCalendario.textColor','LegendaTipoAttivitaCalendario.id'),
        ));
        //debug($relatedEvents);
        //die();
        $newEventUnixtimeStart = strtotime($this->request->data['Cespitecalendario']['start']);
        $newEventUnixtimeEnd = strtotime($this->request->data['Cespitecalendario']['end']);
        foreach($relatedEvents as $event){
            $relEventUnixtimeStart = strtotime($event['Cespitecalendario']['start']);
            $relEventUnixtimeEnd = strtotime($event['Cespitecalendario']['end']);
            //debug($relEventUnixtimeStart);debug($event['Cespitecalendario']['start']);//DEBUG
            //debug($relEventUnixtimeEnd);debug($event['Cespitecalendario']['end']);//DEBUG
            //debug($newEventUnixtimeStart);debug($this->request->data['Cespitecalendario']['start']);//DEBUG
            //debug($newEventUnixtimeEnd);debug($this->request->data['Cespitecalendario']['end']);//DEBUG
            if(($newEventUnixtimeStart >= $relEventUnixtimeStart) && ($newEventUnixtimeStart <= $relEventUnixtimeEnd)){
                //debug('La nuova data è già usata (il nuovo start date è compreso nella durata dell\'evento '.$event['Cespitecalendario']['id'].')');//DEBUG
                return $event;
            } else if(($newEventUnixtimeEnd >= $relEventUnixtimeStart) && ($newEventUnixtimeEnd <= $relEventUnixtimeEnd)){
                //debug('La nuova data è già usata (il nuovo end date è compreso nella durata dell\'evento '.$event['Cespitecalendario']['id'].')');//DEBUG
                return $event;
            } else if(($relEventUnixtimeStart >= $newEventUnixtimeStart) && ($relEventUnixtimeEnd <= $newEventUnixtimeEnd)){
                //debug('Il vecchio evento '.$event['Cespitecalendario']['id'].' è compreso nelle date del nuovo evento.');//DEBUG
                return $event;
            } 
            //debug($this->request->data['Cespitecalendario']['start']);//DEBUG
            //debug($event['Cespitecalendario']['start']);//DEBUG
        }
        //debug($relatedEvents);//DEBUG
        return null;
    }

    /**
     * @param boolean $edit
     * @return true if start date is minor that end date, otherwhise false
     */
    public function _checkStartMinorEnd($edit = false){
        //debug(strtotime($this->request->data['Cespitecalendario']['end']));
        if(strtotime($this->request->data['Cespitecalendario']['end']) !== false){
            $newEventUnixtimeStart = strtotime($this->request->data['Cespitecalendario']['start']);
            $newEventUnixtimeEnd = strtotime($this->request->data['Cespitecalendario']['end']);
            if($newEventUnixtimeStart < $newEventUnixtimeEnd){
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * @return true if start date is minor that end date, otherwhise false
     */
    public function _checkGroupStartMinorEnd(){
        if(strtotime($this->request->data['Cespitecalendario']['repeatTo']) !== false){
            $newGroupUnixtimeStart = strtotime(explode(' ',$this->request->data['Cespitecalendario']['start'])[0]);
            $newGroupUnixtimeEnd = strtotime($this->request->data['Cespitecalendario']['repeatTo']);
            if($newGroupUnixtimeStart < $newGroupUnixtimeEnd){
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * 
     * Useful and Used only when adding new repeated events.
     * 
     * @return 
     */
    public function _checkNotBiggerThanADay(){
        if(strtotime($this->request->data['Cespitecalendario']['end']) !== false){
            $newEventUnixtimeStart = strtotime($this->request->data['Cespitecalendario']['start']);
            $newEventUnixtimeEnd = strtotime($this->request->data['Cespitecalendario']['end']);
            if(($newEventUnixtimeEnd - $newEventUnixtimeStart) < 86400){
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Se la data di fine non viene fornita, viene settata la fine a 24h dall'inizio
     *
     * @return void
     */
    public function _almostOneDay(){
        if(empty($this->request->data['Cespitecalendario']['end'])){
            $this->request->data['Cespitecalendario']['end'] = gmdate("Y-m-d H:i:s", strtotime($this->request->data['Cespitecalendario']['start'])+86399); // 86400 sono 24h precise
        }
    }

    public function eventadd() {
        $this->loadModel('Cespitecalendario');
        if(!empty($this->request->data)){
            if(!$this->Session->check('refererPage')){
                $this->Session->write('refererPage',basename($this->request->referer()));
            }
            if($this->request->data['Cespitecalendario']['repeated'] == 1){
                // Questo è il codice che viene eseguito se l'utente decide che l'evento sarà ripetuto
                //debug($this->request->data['Cespitecalendario']['start']);
                //die();
                $startIsMinorEnd = $this->_checkStartMinorEnd();
                $groupStartIsMinorEnd = $this->_checkGroupStartMinorEnd();
                $notBiggerThanADay = $this->_checkNotBiggerThanADay();
                if($startIsMinorEnd and $groupStartIsMinorEnd){
                    if($notBiggerThanADay){
                    //debug($this->request->data);
                    //die();
                    // Creo un ID da mettere su DB che legherà tutti  i  singoli eventi generati dall'evento ripetuto
                    //debug($this->request->data['Cespitecalendario']['repeatFrom']);//DEBUG
                    //debug($this->request->data['Cespitecalendario']['repeatTo']);//DEBUG
                    //debug($this->request->data['Cespitecalendario']['startTime']);//DEBUG
                    //debug($this->request->data['Cespitecalendario']['endTime']);//DEBUG
                    //die();
                    $eventGroup = time().'_'.rand(1000000,9999999);
                    // Nuova maniera
                    $givenStart = $this->request->data['Cespitecalendario']['repeatFrom'].' '.$this->request->data['Cespitecalendario']['startTime'];
                    $givenEnd = $this->request->data['Cespitecalendario']['repeatFrom'].' '.$this->request->data['Cespitecalendario']['endTime'];//sempre repeatFrom perchè i singoli eventi di un ripetuto devono durare un giorno
                    /*
                    // Vecchia maniera, quando non c'erano gli input time per eventi ripetuti
                    $givenStart = $this->request->data['Cespitecalendario']['start'];
                    $givenEnd = $this->request->data['Cespitecalendario']['end'];
                    */
                    // Nuova maniera
                    $startDay = $this->request->data['Cespitecalendario']['repeatFrom'];
                    $endDay = $this->request->data['Cespitecalendario']['repeatTo'];
                    $startTime = $this->request->data['Cespitecalendario']['startTime'];
                    $explodeEndTime = explode(':',$this->request->data['Cespitecalendario']['endTime']);
                    // Aggiusto il time finale perchè il timepicker usa time come 16:30:00 ma a me come time finale serve 16:29:59
                    if($explodeEndTime[1] == '30'){
                        $this->request->data['Cespitecalendario']['endTime'] = $explodeEndTime[0].':29:59';
                    } else if($explodeEndTime[1] == '00') {
                        // Faccio la stessa cosa nel caso i minuti finali siano 00, perchè il timepicker usa time come 17:00:00 ma a me serve 16:59:59
                        // Questo codice è pensato solo per orari come 22:59:59 e non per formati come 10:59:59 ma è facilmente modificabile in caso di necessità
                        if($explodeEndTime[0] == '00' || $explodeEndTime[0] == '0'){
                            $this->request->data['Cespitecalendario']['endTime'] = '23:59:59';
                        } else {
                            $this->request->data['Cespitecalendario']['endTime'] = (string)($explodeEndTime[0]-1).':59:59';
                        }
                    }
                    $endTime = $this->request->data['Cespitecalendario']['endTime'];
                    /*
                    // Vecchia maniera, quando non c'erano gli input time per eventi ripetuti
                    // Splitto le date passate dal form in maniera da differenziare giorno ed orario
                    $startDay = explode(' ',$this->request->data['Cespitecalendario']['start'])[0];
                    $endDay = explode(' ',$this->request->data['Cespitecalendario']['end'])[0];
                    $startTime = explode(' ',$this->request->data['Cespitecalendario']['start'])[1];
                    $endTime = explode(' ',$this->request->data['Cespitecalendario']['end'])[1];
                    */
                    // Calcolo la differenza tra giorno iniziale e giorni finale per vedere 
                    // quanti giorni sarà lungo questo evento ripetuto
                    // $start = date_create($startDay);
                    $start = date_create($this->request->data['Cespitecalendario']['repeatFrom']);
                    $end = date_create($this->request->data['Cespitecalendario']['repeatTo']);
                    $diff = date_diff($start,$end);
                    $eventDaysDuration = $diff->format("%a");
                    //debug($eventDaysDuration);die();//DEBUG
                    for($i = 0; $i<=$eventDaysDuration; $i++){
                        $start = new DateTime($givenStart);
                        $end = new DateTime($givenEnd);
                        $s = $start->add(new DateInterval('P'.$i.'D'));
                        $e = $end->add(new DateInterval('P'.$i.'D'));
                        $arrayStarts[] = $s->format("Y-m-d");
                        $arrayEnds[] = $e->format("Y-m-d");
                        $this->request->data['Cespitecalendario']['start'] = $s->format("Y-m-d").' '.$startTime;
                        $this->request->data['Cespitecalendario']['end'] = $e->format("Y-m-d").' '.$endTime;
                        $this->request->data['Cespitecalendario']['eventGroup'] = $eventGroup;
                        // debug($this->request->data); // DEBUG
                        // Qua eseguo almeno il controllo per vedere se gli orari dell'evento giornaliero sono già occupati
                        // Se c'è almeno un evento che combacia
                        $alreadyBooked = $this->_checkEventDate();
                        if($alreadyBooked !== null){
                            $alreadyBookedMex = 'Il cespite "'.$alreadyBooked['Cespite']['displayName'].'" è già occupato da "'
                                            .(($alreadyBooked['Cespitecalendario']['user_id'] != NULL) ? $alreadyBooked['Persona']['displayName'] : $alreadyBooked['Cespitecalendario']['utilizzatore_esterno'])
                                            .'" ('.$alreadyBooked['Cespitecalendario']['start'].' - '.$alreadyBooked['Cespitecalendario']['end'].')';
                            /*
                            $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                            //break; 
                            */
                        }
                        //debug($s->format("D"));
                        if($s->format("D") == 'Mon' and $this->request->data['Cespitecalendario']['RepeatMon'] == '1' ){
                            if($alreadyBooked !== null){
                                $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                                break 1;}else{$repeatedEvents[] = $this->request->data;}
                        } else if($s->format("D") == 'Tue' and $this->request->data['Cespitecalendario']['RepeatTue'] == '1' ){
                            if($alreadyBooked !== null){
                                $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                                break 1;}else{$repeatedEvents[] = $this->request->data;}
                        } else if($s->format("D") == 'Wed' and $this->request->data['Cespitecalendario']['RepeatWed'] == '1' ){
                            if($alreadyBooked !== null){
                                $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                                break 1;}else{$repeatedEvents[] = $this->request->data;}
                        } else if($s->format("D") == 'Thu' and $this->request->data['Cespitecalendario']['RepeatThu'] == '1' ){
                            if($alreadyBooked !== null){
                                $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                                break 1;}else{$repeatedEvents[] = $this->request->data;}
                        } else if($s->format("D") == 'Fri' and $this->request->data['Cespitecalendario']['RepeatFri'] == '1' ){
                            if($alreadyBooked !== null){
                                $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                                break 1;}else{$repeatedEvents[] = $this->request->data;}
                        } else if($s->format("D") == 'Sat' and $this->request->data['Cespitecalendario']['RepeatSat'] == '1' ){
                            if($alreadyBooked !== null){
                                $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                                break 1;}else{$repeatedEvents[] = $this->request->data;}
                        } else if($s->format("D") == 'Sun' and $this->request->data['Cespitecalendario']['RepeatSun'] == '1' ){
                            if($alreadyBooked !== null){
                                $this->Session->setFlash(__($alreadyBookedMex),'default',array('class' => 'text-danger'));
                                break 1;}else{$repeatedEvents[] = $this->request->data;}
                        }
                        //debug($this->request->data);
                        //debug('Ancora eseguito'); // DEBUG
                    }
                    //debug($repeatedEvents);die();
                    if(!isset($repeatedEvents)){
                        $this->Session->setFlash(__('Devi almeno selezionare un giorno negli eventi ripetuti.'));
                        $repeatedEvents = [];
                    }
                    // Se $alreadyBooked è ancora uguale a null vuol dire che nessun orario di nessun giorno 
                    // di questo evento ripetuto è già occupato. Quindi posso procedere con l'inserimento vero e proprio.
                    // ciclando su $repeatedEvent che contie
                    if($alreadyBooked === null){
                        foreach($repeatedEvents as $dailyEvent){
                            $this->request->data = $dailyEvent;
                            //debug($this->request->data);//DEBUG
                            $this->Cespitecalendario->create();
                            if($this->Cespitecalendario->save($this->request->data)){
                                // Usare il campo relatedTo della tabella cespiticalendario in maniera da 
                                // individuare facilmente tutti i singoli eventi dell'evento ripetuto e 
                                // cancellarli tutti in caso di un errore server.
                                $success = true;
                            } else {
                                $success = false;
                            }
                        }
                        if(@$success){
                            $this->Session->setFlash(__('Asset Event has been saved'));
                            $refPage = $this->Session->read('refererPage');
                            $this->Session->delete('refererPage');
                            if($refPage == 'calendar'){
                                debug('Codice eseguito redirect verso calendar');
                                $this->redirect(array('action' => 'calendar'));
                            } else {
                                debug('Codice eseguito redirect verso eventlist');
                                $this->redirect(array('action' => 'eventlist'));
                            }
                        } else {
                            $this->Session->setFlash(__('Asset Event could not be saved. Please, try again.'));
                        }
                    }
                    } else {
                        $this->Session->setFlash(__('La durata di un evento ripetuto non può durare più di un giorno.'), 
                                            'default', array('class' => 'text-danger'));
                    }
                } else {
                    $this->Session->setFlash(__('La data iniziale deve essere minore della data finale'), 
                                            'default', array('class' => 'text-danger'));
                }
            } else {
                // Questo è il codice per aggiungere eventi non ripetuti
                $this->_almostOneDay();
                $alreadyBooked = $this->_checkEventDate();
                $startIsMinorEnd = $this->_checkStartMinorEnd();
                if($alreadyBooked !== null){
                    $this->Session->setFlash(__('Il cespite "'.$alreadyBooked['Cespite']['displayName'].'" è già occupato da "'
                                                .(($alreadyBooked['Cespitecalendario']['user_id'] != NULL) ? $alreadyBooked['Persona']['displayName'] : $alreadyBooked['Cespitecalendario']['utilizzatore_esterno'])
                                                .'" ('.$alreadyBooked['Cespitecalendario']['start'].' - '.$alreadyBooked['Cespitecalendario']['end'].')'
                                                ), 
                                            'default', 
                                            array('class' => 'text-danger'));
                    //echo 'Il cespite indicato è già occupato dall\'evento '.$alreadyBooked['Cespitecalendario']['id'];
                } else {
                    if($startIsMinorEnd){
                        $this->Cespitecalendario->create();
                        if($this->Cespitecalendario->save($this->request->data)){
                            $this->Session->setFlash(__('Asset Event has been saved'));
                            $refPage = $this->Session->read('refererPage');
                            $this->Session->delete('refererPage');
                            if($refPage == 'calendar'){
                                $this->redirect(array('action' => 'calendar'));
                            } else {
                                $this->redirect(array('action' => 'eventlist'));
                            }
                        } else {
                            $this->Session->setFlash(__('Asset Event could not be saved. Please, try again.'));
                        }
                    } else {
                        $this->Session->setFlash(__('La data iniziale deve essere minore della data finale'), 
                                            'default', array('class' => 'text-danger'));
                    }
                }
            }
        }
        $legenda_tipo_attivita_calendario = $this->Cespitecalendario->LegendaTipoAttivitaCalendario->find('list');
        $this->set(compact('legenda_tipo_attivita_calendario'));
    }

    public function calendarEventMove($id = null){
        $this->autoRender = false;
        $this->loadModel('Cespitecalendario');
        if(!$id or !is_numeric($id)){
            $this->Session->setFlash(__('Invalid Asset Event id'));
            $this->redirect(array('action' => 'eventlist'));
        } else {
            if($this->request->is('post') || $this->request->is('put')){
                unset($this->request->data['delta']);// For future uses
                $this->request->data['Cespitecalendario']['id']=$this->request->data['id'];
                $this->request->data['Cespitecalendario']['cespite_id']=$this->request->data['cespite_id'];
                $this->request->data['Cespitecalendario']['event_type_id']=$this->request->data['event_type_id'];
                $this->request->data['Cespitecalendario']['start']=$this->request->data['newStartDate'];
                $this->request->data['Cespitecalendario']['end']=$this->request->data['newEndDate'];
                //$this->request->data['Cespitecalendario']['AllDays']=$this->request->data['AllDays'];
                $this->request->data['Cespitecalendario']['note']=$this->request->data['note'];
                unset($this->request->data['id']);
                unset($this->request->data['cespite_id']);
                unset($this->request->data['event_type_id']);
                unset($this->request->data['newStartDate']);
                unset($this->request->data['newEndDate']);
                //unset($this->request->data['AllDays']);
                unset($this->request->data['note']);
                // $this->_almostOneDay(); // Not yet tested here
                $alreadyBooked = $this->_checkEventDate(true);
                // $startIsMinorEnd = $this->_checkStartMinorEnd(); // Not yet tested here
                if($alreadyBooked !== null){
                    throw new Exception('Il cespite indicato è già occupato dall\'evento '.$alreadyBooked['Cespitecalendario']['id']);
                } else {
                    $this->Cespitecalendario->Save($this->request->data);
                }
            }
        }
    }

    public function eventedit($id = null){
        $this->loadModel('Cespitecalendario');
        if(!$id or !is_numeric($id)){
            $this->Session->setFlash(__('Invalid Asset Event id'));
            $this->redirect(array('action' => 'eventlist'));
        } else {
            if(!$this->Session->check('refererPage')){
                $this->Session->write('refererPage',basename($this->request->referer()));
            }
            if($this->request->is('post') || $this->request->is('put')){
                // Forse non è la strada giusta ma se non è settato $this->request->data['Cespitecalendario']['utilizzatore_esterno']
                // lo imposto a NULL in maniera da aggiornare anche il campo DB
                if(!isset($this->request->data['Cespitecalendario']['utilizzatore_esterno'])){
                    $this->request->data['Cespitecalendario']['utilizzatore_esterno'] = NULL;
                }
                $this->_almostOneDay();
                $alreadyBooked = $this->_checkEventDate(true);
                $startIsMinorEnd = $this->_checkStartMinorEnd();
                if($alreadyBooked !== null){
                    $this->Session->setFlash(__('Il cespite "'.$alreadyBooked['Cespite']['displayName'].'" è già occupato da "'
                                                .(($alreadyBooked['Cespitecalendario']['user_id'] != NULL) ? $alreadyBooked['Persona']['displayName'] : $alreadyBooked['Cespitecalendario']['utilizzatore_esterno'])
                                                .'" ('.$alreadyBooked['Cespitecalendario']['start'].' - '.$alreadyBooked['Cespitecalendario']['end'].')'
                                                ), 
                                                'default', 
                                                array('class' => 'text-danger'));
                    //echo 'Il cespite indicato è già occupato dall\'evento '.$alreadyBooked['Cespitecalendario']['id'];
                } else {
                    if($startIsMinorEnd){
                        if($this->Cespitecalendario->Save($this->request->data)){
                        //if($this->Cespitecalendario->SaveAll($this->request->data)){
                            $this->Session->setFlash('Asset Event aggiornato');
                        } else {
                            $this->Session->setFlash('Problemi ad aggiornare Asset Event, riprova');
                        }
                        $refPage = $this->Session->read('refererPage');
                        $this->Session->delete('refererPage');
                        if($refPage == 'calendar'){
                            $this->redirect(array('action' => 'calendar'));
                        } else {
                            $this->redirect(array('action' => 'eventlist'));
                        }
                    } else {
                        $this->Session->setFlash(__('La data iniziale deve essere minore della data finale'), 
                                            'default', 
                                            array('class' => 'text-danger'));
                    }
                }
            } else {
                $this->request->data = $this->Cespitecalendario->findById($id);
            }
        }
        $legenda_tipo_attivita_calendario = $this->Cespitecalendario->LegendaTipoAttivitaCalendario->find('list');
		$this->set(compact('legenda_tipo_attivita_calendario'));
    }
    
    public function eventdelete($id = null){
        $this->loadModel('Cespitecalendario');
        if(!$id){
            $this->Session->setFlash(__('Invalid Asset Event id'));
            $this->redirect(array('action' => 'eventlist'));
        }
        if($this->Cespitecalendario->delete($id)){
            $this->Session->setFlash(__('Asset Event deleted'));
            $this->redirect(array('action' => 'eventlist'));
        }
        $this->Session->setFlash(__('Asset Event was not deleted'));
        $this->redirect(array('action' => 'eventlist'));
    }

    public function eventgroupdelete($id = null){
        if(!$id){
            $this->Session->setFlash(__('Invalid Asset Event id'));
            $this->redirect(array('action' => 'eventlist'));
        }
        $this->loadModel('Cespitecalendario');
        $groupEvents = $this->Cespitecalendario->find('all', array(
            'conditions' => array('Cespitecalendario.eventGroup' => $id)
        ));
        $almostOneOk = false;
        foreach($groupEvents as $event){
            if($this->Cespitecalendario->delete($event['Cespitecalendario']['id'])){
                $almostOneOk = true;
            } else {
                $this->Session->setFlash(__('ERROR deleting Asset Event #'.$event['Cespitecalendario']['id']));
            }
        }
        if($almostOneOk){
            $this->Session->setFlash(__('Event group deleted'));
        }
        $this->redirect(array('action' => 'eventlist'));
    }

    function autocomplete() {
        $data = array();
        if (isset($this->request->query['term'])) {
            $data = $this->Cespite->find('all', array(
                'conditions' => array(
                    'Cespite.DisplayName LIKE' => '%' . $this->request->query['term'] . '%'
                ),
                'limit' => 50,
                'fields' => array('id', 'displayName'),
            ));
        }

        $res = array();

        foreach ($data as $d) {
            $a = new StdClass();
            $a->id = $d['Cespite']['id'];
            $a->value = $d['Cespite']['displayName'];
            $res[] = $a;
        }
        $this->layout = 'ajax';
        $this->autoLayout = false;
        $this->autoRender = false;

        $this->header('Content-Type: application/json');
        echo json_encode($res);
        exit();
    }

}
?>
