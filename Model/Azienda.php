<?php
class Azienda extends AppModel {
	var $name = 'Azienda';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = [
		'Attivita' => [
			'className' => 'Attivita',
			'foreignKey' => 'azienda_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		],
		'User' => [
			'className' => 'User',
			'foreignKey' => 'azienda_id',
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