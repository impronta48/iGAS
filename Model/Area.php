<?php
class Area extends AppModel {
	var $name = 'Area';
	var $displayField = 'name';
	var $order = 'name';
	public $cacheQueries = true;
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = [
		'Attivita' => [
			'className' => 'Attivita',
			'foreignKey' => 'area_id',
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
?>