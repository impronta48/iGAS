<?php

class Cespitecalendario extends AppModel {

	public $name = 'Cespitecalendario';
    public $displayField = 'ID';
    var $order= 'Cespitecalendario.start';
    var $actsAs = array('Containable');
    
    var $validate = array(
        'start' => array(
            'rule' => 'notBlank',
            'required' => true
        ),
    );
    
    var $belongsTo = array(
        'Cespite' => array(
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
        ),
        'Persona' => array(
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
        ),
        'LegendaTipoAttivitaCalendario' => array(
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
        ),
        'Attivita' => array(
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

    public function beforeSave($options = Array()) {
        //debug($this->data);die();//DEBUG
    }
    
}