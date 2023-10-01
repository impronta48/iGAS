<?php

class Cespitecalendario extends AppModel {

	public $name = 'Cespitecalendario';
    public $displayField = 'ID';
    var $order= 'Cespitecalendario.start';
    var $actsAs = ['Containable'];
    
    var $validate = [
        'start' => [
            'rule' => 'notBlank',
            'required' => true
        ],
    ];
    
    var $belongsTo = [
        'Cespite' => [
            'className' => 'Cespite',
            'foreignKey' => 'cespite_id',
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
        'Persona' => [
            'className' => 'Persona',
            'foreignKey' => 'user_id',
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
        'LegendaTipoAttivitaCalendario' => [
            'className' => 'LegendaTipoAttivitaCalendario',
            'foreignKey' => 'event_type_id',
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
			'foreignKey' => 'attivita_id',
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

    public function beforeSave($options = []) {
        //debug($this->data);die();//DEBUG
    }
    
}