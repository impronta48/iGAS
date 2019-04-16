<?php
class Cespite extends AppModel {

	public $name = 'Cespite';
	public $displayField = 'ID';
	//public $actsAs = array('Containable');
    var $order= 'Cespite.displayName';

    var $validate = array(
        'DisplayName' => array(
            'rule' => 'notEmpty',
            'required' => true
        )
    );
    
    var $belongsTo = array(
        /*
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
        */
        /*
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
        */
    );  
    
}