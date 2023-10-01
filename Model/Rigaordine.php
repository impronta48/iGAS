<?php
App::uses('AppModel', 'Model');
/**
 * Rigaordine Model
 *
 * @property Ordine $Ordine
 */
class Rigaordine extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = [
		'Ordine' => [
			'className' => 'Ordine',
			'foreignKey' => 'ordine_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];
}
