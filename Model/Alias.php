<?php
class Alias extends AppModel {

	var $belongsTo = [
		'Attivita' => [
			'className' => 'Attivita',
			'foreignKey' => 'attivita_id',
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