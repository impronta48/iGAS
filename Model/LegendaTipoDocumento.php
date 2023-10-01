<?php
App::uses('AppModel', 'Model');
/**
 * LegendaTipoDocumento Model
 *
 * @property Fatturaricevuta $Fatturaricevuta
 */
class LegendaTipoDocumento extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	public $cacheQueries = true;


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Fatturaricevuta' => [
			'className' => 'Fatturaricevuta',
			'foreignKey' => 'legenda_tipo_documento_id',
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
