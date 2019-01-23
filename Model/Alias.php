<?php
class Alias extends AppModel {

	var $belongsTo = array(
		'Attivita' => array(
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
		)
	);

}
?>