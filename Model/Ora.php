<?php
class Ora extends AppModel {
	var $name = 'Ora';
    public $actsAs = ['Containable'];
    
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = [
		'Persona' => [
			'className' => 'Persona',
			'foreignKey' => 'eRisorsa',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'Impiegato' => [
			'className' => 'Impiegato',
			'foreignKey' => 'eRisorsa',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'Attivita' => [
			'className' => 'Attivita',
			'foreignKey' => 'eAttivita',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'Faseattivita' => [
			'className' => 'Faseattivita',
			'foreignKey' => 'faseattivita_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		]
	]; 

    var $validate = [
	'numOre' => [
		'rule' => ['numeric'],
        'required' => FALSE,
		'message' => 'Inserire il numero di ore lavorate'
	],
    'data' => [
		'rule' => ['date','ymd'],
        'required' => TRUE,
		'message' => 'Inserire una data valida'

	],
    'eRisorsa' => [
        'rule' => ['numeric'],
		'required' => TRUE,
		'message' => 'Campo Obbligatorio'

	],
    'eAttivita' => [
        'rule' => ['numeric'],
		'required' => TRUE,
		'message' => 'Campo Obbligatorio'

	],
	];

	public function beforeSave($options = []) {
		// Se faseattivita_id non è settato o se faseattivita_id == 0 le ore caricate non sono legate a nessuna faseattività e non devo quindi modificare nulla in nessuna fase
		if(isset($this->data['Ora']['faseattivita_id']) && $this->data['Ora']['faseattivita_id'] != 0){
			$this->Faseattivita->id = $this->data['Ora']['faseattivita_id'];
			$faseAttivitaQtaData = $this->Faseattivita->read('Faseattivita.qta, Faseattivita.qtaUtilizzata, Faseattivita.um');
			$qta = $faseAttivitaQtaData['Faseattivita']['qta'];
			$qtaUtilizzata = $faseAttivitaQtaData['Faseattivita']['qtaUtilizzata'];
			$um = $faseAttivitaQtaData['Faseattivita']['um'];
			if($um == 'gg' or $um == 'ore'){
				$hDayWork = ($um == 'gg') ? 8 : 1;
				if(isset($this->data['Ora']['old_numOre'])){ // Se è settato vuol dire che è un edit
					$qtaNew = $qtaUtilizzata - ((int)$this->data['Ora']['old_numOre']/$hDayWork);
					$qtaNew += ((int)$this->data['Ora']['numOre']/$hDayWork);
				} else {
					$qtaNew = $qtaUtilizzata + ((int)$this->data['Ora']['numOre']/$hDayWork);
				}
				//debug($this->data['Ora']['numOre']);
				//debug((int)$this->data['Ora']['numOre']/$hDayWork);
				//debug($faseAttivitaQtaData);
				//die();
			}
		}
		return true;
	}
 
	public function afterSave($created, $options = []) {
		// Se faseattivita_id non è settato o se faseattivita_id == 0 le ore caricate non sono legate a nessuna faseattività e non devo quindi modificare nulla in nessuna fase
		if(isset($this->data['Ora']['faseattivita_id']) && $this->data['Ora']['faseattivita_id'] != 0){
			$this->Faseattivita->id = $this->data['Ora']['faseattivita_id'];
			$faseAttivitaQtaData = $this->Faseattivita->read('Faseattivita.qtaUtilizzata, Faseattivita.um');
			$qtaUtilizzata = $faseAttivitaQtaData['Faseattivita']['qtaUtilizzata'];
			$um = $faseAttivitaQtaData['Faseattivita']['um'];
			if($um == 'gg' or $um == 'ore'){
				$hDayWork = ($um == 'gg') ? 8 : 1;
				if($created) {
					//debug($this->data['Ora']);
					//die();
					$qtaNew = $qtaUtilizzata + ((int)$this->data['Ora']['numOre']/$hDayWork);
				} else {
					// $qtaNew = $qtaUtilizzata - ((int)$this->data['Ora']['old_numOre']/$hDayWork);
					// $qtaNew += ((int)$this->data['Ora']['numOre']/$hDayWork);
					$qtaNew = ((int)$this->data['Ora']['numOre']/$hDayWork);
				}
				$this->Faseattivita->saveField('qtaUtilizzata', $qtaNew);
			}
		}
	}

	public function beforeDelete($cascade = true) {
        //debug($this->data);
        //die();
    }
    
    public function afterDelete() {
        //debug($this->data);
		//die();
		// Se faseattivita_id == 0 le ore caricate non sono legate a nessuna faseattività e non devo quindi modificare nulla in nessuna fase
		if($this->data['Ora']['faseattivita_id'] != 0){
			$this->Faseattivita->id = $this->data['Ora']['faseattivita_id'];
			$faseAttivitaQtaData = $this->Faseattivita->read('Faseattivita.qtaUtilizzata, Faseattivita.um');
			$qtaUtilizzata = $faseAttivitaQtaData['Faseattivita']['qtaUtilizzata'];
			$um = $faseAttivitaQtaData['Faseattivita']['um'];
			if($um == 'gg' or $um == 'ore'){
				$hDayWork = ($um == 'gg') ? 8 : 1;
				$qtaNew = $qtaUtilizzata - ((int)$this->data['Ora']['numOre']/$hDayWork);
				$this->Faseattivita->saveField('qtaUtilizzata', $qtaNew);
			}
		}
    }

	public function getPersone()
    {
      $persone = Cache::read('persone_list', 'short');
      if (!$persone) {
        $persone = $this->find('list', [  'fields'=>['Persona.id','Persona.DisplayName'],
                                               'contain'=>['Persona'] ,
                                               'order'=>'Persona.DisplayName'
                                                ]);
        Cache::write('persone_list', $persone, 'short');
      }
      
      return $persone;       
    }
}
?>
