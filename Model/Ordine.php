<?php
App::uses('AppModel', 'Model');
/**
 * Ordine Model
 *
 */
class Ordine extends AppModel {

    public $belongsTo = array(
		'Attivita' => array(
			'className' => 'Attivita',
			'foreignKey' => 'attivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Fornitore' => array(
			'className' => 'Fornitore',
			'foreignKey' => 'fornitore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    );
    
    public $hasMany = array(
        'Rigaordine',
    );
}
