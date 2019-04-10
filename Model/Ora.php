<?php
class Ora extends AppModel {
	var $name = 'Ora';
    public $actsAs = array('Containable');
    
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Persona' => array(
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
		),
		'Attivita' => array(
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
		),
		'Faseattivita' => array(
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
		)
	); 

    var $validate = array(
	'numOre' => array(
		'rule' => array('numeric'),
        'required' => TRUE,
		'message' => 'Inserire il numero di ore lavorate'
	),
    'data' => array(
		'rule' => array('datetime','ymd'),
        'required' => TRUE,
		'message' => 'Inserire una data valida'

	),
    'eRisorsa' => array(
        'rule' => array('numeric'),
		'required' => TRUE,
		'message' => 'Campo Obbligatorio'

	),
    'eAttivita' => array(
        'rule' => array('numeric'),
		'required' => TRUE,
		'message' => 'Campo Obbligatorio'

	),
	);

	public function getPersone()
    {
      $persone = Cache::read('persone_list', 'short');
      if (!$persone) {
        $persone = $this->find('list', array(  'fields'=>array('Persona.id','Persona.DisplayName'),
                                               'contain'=>array('Persona') ,
                                               'order'=>'Persona.DisplayName'
                                                ));
        Cache::write('persone_list', $persone, 'short');
      }
      
      return $persone;       
    }
}
?>
