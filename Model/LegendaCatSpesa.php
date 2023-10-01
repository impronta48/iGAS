<?php
App::uses('AppModel', 'Model');
/**
 * LegendaCatSpesa Model
 *
 * @property Primanota $Primanota
 */
class LegendaCatSpesa extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $order = 'name';
	public $cacheQueries = true;

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Primanota' => [
			'className' => 'Primanota',
			'foreignKey' => 'legenda_cat_spesa_id',
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
