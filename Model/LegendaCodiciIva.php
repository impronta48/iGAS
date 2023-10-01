<?php
App::uses('AppModel', 'Model');
/**
 * LegendaCodiciIva Model
 *
 * @property Faseattivita $Faseattivita
 */
class LegendaCodiciIva extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'legenda_codici_iva';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'Descrizione';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Faseattivita' => [
			'className' => 'Faseattivita',
			'foreignKey' => 'legenda_codici_iva_id',
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

}
