<?php
class Notaspesa extends AppModel {
	public $name = 'Notaspesa';
	public $displayField = 'ID';
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
		'LegendaCatSpesa' => [
			'className' => 'LegendaCatSpesa',
			'foreignKey' => 'eCatSpesa',
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
		'LegendaMezzi' => [
			'className' => 'LegendaMezzi',
			'foreignKey' => 'legenda_mezzi_id',
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
		'Provenienzasoldi' => [
			'className' => 'Provenienzasoldi',
			'foreignKey' => 'provenienzasoldi_id',
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
		'Faseattivita'
	];
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
