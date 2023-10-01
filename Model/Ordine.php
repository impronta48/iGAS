<?php
App::uses('AppModel', 'Model');
/**
 * Ordine Model
 *
 */
class Ordine extends AppModel {

    public $belongsTo = [
		'Attivita' => [
			'className' => 'Attivita',
			'foreignKey' => 'attivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'Fornitore' => [
			'className' => 'Fornitore',
			'foreignKey' => 'fornitore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
    ];
    
    public $hasMany = [
        'Rigaordine',
    ];
}
