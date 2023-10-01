<?php
App::uses('AppModel', 'Model');
/**
 * Rigaddt Model
 *
 * @property Ddt $Ddt
 */
class Rigaddt extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'Descrizione';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = [
		'Ddt' => [
			'className' => 'Ddt',
			'foreignKey' => 'ddt_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'Faseattivita' => [
			'className' => 'Faseattivita',
			'foreignKey' => 'faseattivita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		], 
	];
}
