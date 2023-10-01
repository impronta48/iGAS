<?php
App::uses('AppModel', 'Model');
/**
 * LegendaMezzi Model
 *
 * @property Notaspesa $Notaspesa
 */
class LegendaMezzi extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $cacheQueries = true;


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Notaspesa' => [
			'className' => 'Notaspesa',
			'foreignKey' => 'legenda_mezzi_id',
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
